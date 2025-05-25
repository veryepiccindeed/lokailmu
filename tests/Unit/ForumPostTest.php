<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ForumPost;
use App\Models\ThreadForum;
use App\Models\User;
use App\Models\ForumLike;
use App\Models\MediaForum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_forum_post_can_be_created()
    {
        $post = ForumPost::factory()->create();
        $this->assertInstanceOf(ForumPost::class, $post);
        $this->assertNotNull($post->idPost);
        $this->assertNotNull($post->idThread);
        $this->assertNotNull($post->dibuatOleh);
        $this->assertNotNull($post->isi);
    }

    public function test_forum_post_has_relationships()
    {
        $post = ForumPost::factory()
            ->has(ForumLike::factory()->count(2), 'likes') // Explicitly use 'likes' relationship
            ->has(MediaForum::factory()->count(2))
            ->create();

        $this->assertInstanceOf(ThreadForum::class, $post->threadForum);
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertCount(2, $post->likes); // Corrected: uses likes() relationship name
        $this->assertCount(2, $post->mediaForums);
    }

    public function test_forum_post_can_have_replies()
    {
        $parentPost = ForumPost::factory()->create();
        $replies = ForumPost::factory()->count(2)->create([
            'parentPost' => $parentPost->idPost
        ]);

        $this->assertCount(2, $parentPost->replies);
    }
}