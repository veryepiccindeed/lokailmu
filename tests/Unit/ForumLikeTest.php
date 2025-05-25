<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ForumLike;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForumLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_forum_like_can_be_created()
    {
        $like = ForumLike::factory()->create();
        $this->assertInstanceOf(ForumLike::class, $like);
        $this->assertNotNull($like->idLike);
        $this->assertNotNull($like->idPost);
        $this->assertNotNull($like->likeOleh);
        $this->assertNotNull($like->tglLike);
    }

    public function test_forum_like_has_relationships()
    {
        $like = ForumLike::factory()->create();

        $this->assertInstanceOf(ForumPost::class, $like->post);
        $this->assertInstanceOf(User::class, $like->user);
    }
}