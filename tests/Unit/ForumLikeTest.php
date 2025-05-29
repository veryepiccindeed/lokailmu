<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\ForumLikeRepositoryInterface;
use Mockery;

class ForumLikeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockForumLikeRepository = Mockery::mock(ForumLikeRepositoryInterface::class);
        $this->app->instance(ForumLikeRepositoryInterface::class, $this->mockForumLikeRepository);
    }

    public function test_forum_like_can_be_created()
    {
        $likeData = [
            'idLike' => 1,
            'idPost' => 1, // Assuming idPost is an integer, adjust if it's a string
            'likeOleh' => 'U12345678901',
            'tglLike' => now(),
        ];

        $this->mockForumLikeRepository
            ->shouldReceive('create')
            ->once()
            ->with($likeData)
            ->andReturn((object) $likeData);

        $like = $this->mockForumLikeRepository->create($likeData);

        $this->assertEquals(1, $like->idLike);
        $this->assertEquals('U12345678901', $like->likeOleh);
    }

    public function test_forum_like_can_be_read()
    {
        $likeId = 1;
        $tglLike = now();
        $likeData = (object) [
            'idLike' => $likeId,
            'idPost' => 1,
            'likeOleh' => 'U12345678901',
            'tglLike' => $tglLike,
        ];

        $this->mockForumLikeRepository
            ->shouldReceive('find')
            ->once()
            ->with($likeId)
            ->andReturn($likeData);

        $like = $this->mockForumLikeRepository->find($likeId);

        $this->assertEquals($likeId, $like->idLike);
        $this->assertEquals('U12345678901', $like->likeOleh);
        $this->assertTrue($tglLike->eq($like->tglLike));
    }

    // ForumLike typically doesn't have an update operation, only create (like) and delete (unlike).
    // If an update operation is indeed required (e.g., changing the like type if that exists),
    // then a test_forum_like_can_be_updated method would be added here.
    // For now, we assume no update operation.

    public function test_forum_like_can_be_deleted()
    {
        $likeId = 1;

        $this->mockForumLikeRepository
            ->shouldReceive('delete')
            ->once()
            ->with($likeId)
            ->andReturn(true);

        $result = $this->mockForumLikeRepository->delete($likeId);

        $this->assertTrue($result);
    }
}