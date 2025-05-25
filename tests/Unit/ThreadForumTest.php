<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ThreadForum;
use App\Models\ForumPost;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_thread_forum_can_be_created()
    {
        $thread = ThreadForum::factory()->create();
        $this->assertInstanceOf(ThreadForum::class, $thread);
        $this->assertNotNull($thread->idThread);
        $this->assertNotNull($thread->judul);
        $this->assertNotNull($thread->idPostUtama);
    }

    public function test_thread_forum_has_relationships()
    {
        $thread = ThreadForum::factory()
            ->has(ForumPost::factory()->count(2)) // This creates 2 additional posts
            ->has(Tag::factory()->count(2))
            ->create();
        // The factory also creates 1 main post (postUtama)

        $this->assertInstanceOf(ForumPost::class, $thread->postUtama);
        // Total posts = 1 (postUtama) + 2 (additional posts) = 3
        $this->assertCount(3, $thread->forumPosts); // Adjusted to expect 3 posts
        $this->assertCount(2, $thread->tags);
    }
}