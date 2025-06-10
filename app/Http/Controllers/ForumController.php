<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThreadForum;
use App\Models\ForumPost;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function __construct()
    {
        // Ensure user is authenticated and is a guru
        $this->middleware('auth:sanctum');
        $this->middleware(function ($request, $next) {
            if (! $request->user() || ! $request->user()->profilGuru) {
                return response()->json(['error' => 'Forbidden: only guru may access forum'], 403);
            }
            return $next($request);
        });
    }
    /**
     * List all forum threads with pagination.
     */
    public function index()
    {
        $threads = ThreadForum::with(['user','tags','postUtama'])
            ->orderBy('created_at','desc')
            ->paginate(10);
        return response()->json($threads);
    }

    /**
     * Create a new forum thread with main post and tags.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'tags' => 'array',
            'kategori' => 'required|in:informatika,sains,bahasa,matematika', // Validate kategori
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate images
        ]);

        return DB::transaction(function () use ($request) {
            $thread = ThreadForum::create([
                'idThread' => (string) Str::uuid(),
                'judul' => $request->judul,
                'dibuatOleh' => Auth::id(),
                'kategori' => $request->kategori, // Save kategori
            ]);

            $post = ForumPost::create([
                'idThread' => $thread->idThread,
                'dibuatOleh' => Auth::id(),
                'isi' => $request->isi,
                'parentPost' => null,
            ]);

            $thread->idPostUtama = $post->idPost;
            $thread->save();

            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->tags as $tagName) {
                    $tag = Tag::firstOrCreate(['tag' => $tagName]);
                    $tagIds[] = $tag->idTag;
                }
                $thread->tags()->sync($tagIds);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('forum_images', 'public');
                    DB::table('mediaforums')->insert([
                        'idPost' => $post->idPost,
                        'urlMedia' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json($thread->load('tags', 'postUtama', 'user'), 201);
        });
    }

    /**
     * Show a single forum thread with all posts and replies.
     */
    public function show($idThread)
    {
        $thread = ThreadForum::with(['user','tags','forumPosts.replies.user'])
            ->findOrFail($idThread);
        return response()->json($thread);
    }

    /**
     * Add a comment or reply to a forum thread.
     */
    public function comment(Request $request, $idThread)
    {
        $request->validate([
            'isi'=>'required|string',
            'parentPost'=>'nullable|integer'
        ]);

        $thread = ThreadForum::findOrFail($idThread);
        $post = ForumPost::create([
            'idThread'=> $thread->idThread,
            'dibuatOleh'=> Auth::id(),
            'isi'=> $request->isi,
            'parentPost'=> $request->parentPost,
        ]);

        return response()->json($post, 201);
    }

    /**
     * Search forum threads and posts.
     */
    public function search(Request $request)
    {
        $query = $request->query('q');
        $threads = ThreadForum::where('judul', 'like', "%{$query}%")
            ->orWhereHas('forumPosts', function ($q2) use ($query) {
                $q2->where('isi', 'like', "%{$query}%");
            })
            ->with(['user','tags','postUtama'])
            ->paginate(10);
        return response()->json($threads);
    }

    /**
     * Update a forum thread (title, main post, tags) by its creator.
     */
    public function updateThread(Request $request, $idThread)
    {
        $request->validate([
            'judul' => 'required|string',
            'isi'   => 'required|string',
            'tags'  => 'array'
        ]);

        $thread = ThreadForum::findOrFail($idThread);
        if ($thread->dibuatOleh !== Auth::id()) {
            return response()->json(['error' => 'Forbidden: not thread owner'], 403);
        }

        return DB::transaction(function() use ($thread, $request) {
            // Update thread title
            $thread->judul = $request->judul;
            $thread->save();

            // Update main post content
            $mainPost = $thread->postUtama;
            $mainPost->isi = $request->isi;
            $mainPost->save();

            // Update tags if provided
            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->tags as $tagName) {
                    $tag = Tag::firstOrCreate(['tag' => $tagName]);
                    $tagIds[] = $tag->idTag;
                }
                $thread->tags()->sync($tagIds);
            }

            return response()->json($thread->load('tags','postUtama','user'));
        });
    }

    /**
     * Delete a forum thread and its posts by its creator.
     */
    public function deleteThread($idThread)
    {
        $thread = ThreadForum::findOrFail($idThread);
        if ($thread->dibuatOleh !== Auth::id()) {
            return response()->json(['error' => 'Forbidden: not thread owner'], 403);
        }

        return DB::transaction(function() use ($thread) {
            // Detach tags and delete all posts
            $thread->tags()->detach();
            $thread->forumPosts()->delete();
            $thread->delete();

            return response()->json(null, 204);
        });
    }

    /**
     * Update a forum post (reply) by its creator.
     */
    public function updatePost(Request $request, $idPost)
    {
        $request->validate(['isi' => 'required|string']);

        $post = ForumPost::findOrFail($idPost);
        if ($post->dibuatOleh !== Auth::id()) {
            return response()->json(['error' => 'Forbidden: not post owner'], 403);
        }

        $post->isi = $request->isi;
        $post->save();

        return response()->json($post);
    }

    /**
     * Delete a forum post (and its replies) by its creator.
     */
    public function deletePost($idPost)
    {
        $post = ForumPost::findOrFail($idPost);
        if ($post->dibuatOleh !== Auth::id()) {
            return response()->json(['error' => 'Forbidden: not post owner'], 403);
        }

        return DB::transaction(function() use ($post) {
            // Delete nested replies then the post
            $post->replies()->delete();
            $post->delete();

            return response()->json(null, 204);
        });
    }
}
