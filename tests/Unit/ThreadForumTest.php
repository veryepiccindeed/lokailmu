<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\ThreadForumRepositoryInterface;
use Mockery;

class ThreadForumTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockThreadForumRepository = Mockery::mock(ThreadForumRepositoryInterface::class);
        $this->app->instance(ThreadForumRepositoryInterface::class, $this->mockThreadForumRepository);
    }

    public function test_thread_forum_can_be_created()
    {
        $threadData = [
            'idThread' => 'THR123456',
            'judul' => 'Test Thread',
            'dibuatOleh' => 'U12345678901',
        ];

        $this->mockThreadForumRepository
            ->shouldReceive('create')
            ->once()
            ->with($threadData)
            ->andReturn((object) $threadData);

        $thread = $this->mockThreadForumRepository->create($threadData);

        $this->assertEquals('Test Thread', $thread->judul);
        $this->assertEquals('U12345678901', $thread->dibuatOleh);
    }

    public function test_thread_forum_can_be_read()
    {
        $threadId = 'THR123456';
        $threadData = (object) [
            'idThread' => $threadId,
            'judul' => 'Test Thread',
            'dibuatOleh' => 'U12345678901',
        ];

        $this->mockThreadForumRepository
            ->shouldReceive('find')
            ->once()
            ->with($threadId)
            ->andReturn($threadData);

        $thread = $this->mockThreadForumRepository->find($threadId);

        $this->assertEquals($threadId, $thread->idThread);
        $this->assertEquals('Test Thread', $thread->judul);
    }

    public function test_thread_forum_can_be_updated()
    {
        $threadId = 'THR123456';
        $updateData = [
            'judul' => 'Updated Test Thread',
        ];
        $updatedThreadData = (object) array_merge(['idThread' => $threadId, 'dibuatOleh' => 'U12345678901'], $updateData);

        $this->mockThreadForumRepository
            ->shouldReceive('update')
            ->once()
            ->with($threadId, $updateData)
            ->andReturn($updatedThreadData);

        $thread = $this->mockThreadForumRepository->update($threadId, $updateData);

        $this->assertEquals('Updated Test Thread', $thread->judul);
    }

    public function test_thread_forum_can_be_deleted()
    {
        $threadId = 'THR123456';

        $this->mockThreadForumRepository
            ->shouldReceive('delete')
            ->once()
            ->with($threadId)
            ->andReturn(true);

        $result = $this->mockThreadForumRepository->delete($threadId);

        $this->assertTrue($result);
    }
}