<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MediaForum;
use App\Models\ForumPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_media_forum_can_be_created()
    {
        $media = MediaForum::factory()->create();
        $this->assertInstanceOf(MediaForum::class, $media);
        $this->assertNotNull($media->idmedia);
        $this->assertNotNull($media->idPost);
        $this->assertNotNull($media->urlMedia);
    }

    public function test_media_forum_has_relationship()
    {
        $media = MediaForum::factory()->create();
        $this->assertInstanceOf(ForumPost::class, $media->forumPost);
    }
}