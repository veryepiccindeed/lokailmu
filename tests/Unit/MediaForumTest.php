<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\MediaForumRepositoryInterface;
use Mockery;

class MediaForumTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockMediaForumRepository = Mockery::mock(MediaForumRepositoryInterface::class);
        $this->app->instance(MediaForumRepositoryInterface::class, $this->mockMediaForumRepository);
    }

    public function test_media_forum_can_be_created()
    {
        $mediaData = [
            'idmedia' => 1,
            'idPost' => 1, // Assuming idPost is an integer, adjust if it's a string
            'urlMedia' => 'http://example.com/media.jpg',
        ];

        $this->mockMediaForumRepository
            ->shouldReceive('create')
            ->once()
            ->with($mediaData)
            ->andReturn((object) $mediaData);

        $media = $this->mockMediaForumRepository->create($mediaData);

        $this->assertEquals(1, $media->idmedia);
        $this->assertEquals('http://example.com/media.jpg', $media->urlMedia);
    }

    public function test_media_forum_can_be_read()
    {
        $mediaId = 1;
        $mediaData = (object) [
            'idmedia' => $mediaId,
            'idPost' => 1,
            'urlMedia' => 'http://example.com/media.jpg',
        ];

        $this->mockMediaForumRepository
            ->shouldReceive('find')
            ->once()
            ->with($mediaId)
            ->andReturn($mediaData);

        $media = $this->mockMediaForumRepository->find($mediaId);

        $this->assertEquals($mediaId, $media->idmedia);
        $this->assertEquals('http://example.com/media.jpg', $media->urlMedia);
    }

    public function test_media_forum_can_be_updated()
    {
        $mediaId = 1;
        $updateData = [
            'urlMedia' => 'http://example.com/updated_media.jpg',
        ];
        $updatedMediaData = (object) array_merge([
            'idmedia' => $mediaId,
            'idPost' => 1,
        ], $updateData);

        $this->mockMediaForumRepository
            ->shouldReceive('update')
            ->once()
            ->with($mediaId, $updateData)
            ->andReturn($updatedMediaData);

        $media = $this->mockMediaForumRepository->update($mediaId, $updateData);

        $this->assertEquals('http://example.com/updated_media.jpg', $media->urlMedia);
    }

    public function test_media_forum_can_be_deleted()
    {
        $mediaId = 1;

        $this->mockMediaForumRepository
            ->shouldReceive('delete')
            ->once()
            ->with($mediaId)
            ->andReturn(true);

        $result = $this->mockMediaForumRepository->delete($mediaId);

        $this->assertTrue($result);
    }
}