<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tag;
use App\Models\ThreadForum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_can_be_created()
    {
        $tag = Tag::factory()->create();
        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertNotNull($tag->idTag);
        $this->assertNotNull($tag->tag);
    }

    public function test_tag_has_relationship()
    {
        $tag = Tag::factory()
            ->has(ThreadForum::factory()->count(2))
            ->create();

        $this->assertCount(2, $tag->threadForums);
    }
}