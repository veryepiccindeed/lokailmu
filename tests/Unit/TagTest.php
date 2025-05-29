<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\TagRepositoryInterface;
use Mockery;

class TagTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockTagRepository = Mockery::mock(TagRepositoryInterface::class);
        $this->app->instance(TagRepositoryInterface::class, $this->mockTagRepository);
    }

    public function test_tag_can_be_created()
    {
        $tagData = [
            'idTag' => 1,
            'tag' => 'Test Tag',
        ];

        $this->mockTagRepository
            ->shouldReceive('create')
            ->once()
            ->with($tagData)
            ->andReturn((object) $tagData);

        $tag = $this->mockTagRepository->create($tagData);

        $this->assertEquals('Test Tag', $tag->tag);
    }

    public function test_tag_can_be_read()
    {
        $tagId = 1;
        $tagData = (object) [
            'idTag' => $tagId,
            'tag' => 'Test Tag',
        ];

        $this->mockTagRepository
            ->shouldReceive('find')
            ->once()
            ->with($tagId)
            ->andReturn($tagData);

        $tag = $this->mockTagRepository->find($tagId);

        $this->assertEquals($tagId, $tag->idTag);
        $this->assertEquals('Test Tag', $tag->tag);
    }

    public function test_tag_can_be_updated()
    {
        $tagId = 1;
        $updateData = [
            'tag' => 'Updated Test Tag',
        ];
        $updatedTagData = (object) array_merge(['idTag' => $tagId], $updateData);

        $this->mockTagRepository
            ->shouldReceive('update')
            ->once()
            ->with($tagId, $updateData)
            ->andReturn($updatedTagData);

        $tag = $this->mockTagRepository->update($tagId, $updateData);

        $this->assertEquals('Updated Test Tag', $tag->tag);
    }

    public function test_tag_can_be_deleted()
    {
        $tagId = 1;

        $this->mockTagRepository
            ->shouldReceive('delete')
            ->once()
            ->with($tagId)
            ->andReturn(true);

        $result = $this->mockTagRepository->delete($tagId);

        $this->assertTrue($result);
    }
}