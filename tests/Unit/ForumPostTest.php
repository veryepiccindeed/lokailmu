<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\ForumPostRepositoryInterface;
use Mockery;

class ForumPostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockForumPostRepository = Mockery::mock(ForumPostRepositoryInterface::class);
        $this->app->instance(ForumPostRepositoryInterface::class, $this->mockForumPostRepository);
    }

    public function test_forum_post_can_be_created()
    {
        $postData = [
            'idPost' => 1,
            'idThread' => 'THR123456',
            'dibuatOleh' => 'U12345678901',
            'isi' => 'Ini adalah isi post.',
            'parentPost' => null,
        ];

        $this->mockForumPostRepository
            ->shouldReceive('create')
            ->once()
            ->with($postData)
            ->andReturn((object) $postData);

        $post = $this->mockForumPostRepository->create($postData);

        $this->assertEquals(1, $post->idPost);
        $this->assertEquals('Ini adalah isi post.', $post->isi);
    }

    public function test_forum_post_can_be_read()
    {
        $postId = 1;
        $postData = (object) [
            'idPost' => $postId,
            'idThread' => 'THR123456',
            'dibuatOleh' => 'U12345678901',
            'isi' => 'Ini adalah isi post.',
            'parentPost' => null,
        ];

        $this->mockForumPostRepository
            ->shouldReceive('find')
            ->once()
            ->with($postId)
            ->andReturn($postData);

        $post = $this->mockForumPostRepository->find($postId);

        $this->assertEquals($postId, $post->idPost);
        $this->assertEquals('Ini adalah isi post.', $post->isi);
    }

    public function test_forum_post_can_be_updated()
    {
        $postId = 1;
        $updateData = [
            'isi' => 'Ini adalah isi post yang sudah diupdate.',
        ];
        $updatedPostData = (object) array_merge([
            'idPost' => $postId,
            'idThread' => 'THR123456',
            'dibuatOleh' => 'U12345678901',
            'parentPost' => null,
        ], $updateData);

        $this->mockForumPostRepository
            ->shouldReceive('update')
            ->once()
            ->with($postId, $updateData)
            ->andReturn($updatedPostData);

        $post = $this->mockForumPostRepository->update($postId, $updateData);

        $this->assertEquals('Ini adalah isi post yang sudah diupdate.', $post->isi);
    }

    public function test_forum_post_can_be_deleted()
    {
        $postId = 1;

        $this->mockForumPostRepository
            ->shouldReceive('delete')
            ->once()
            ->with($postId)
            ->andReturn(true);

        $result = $this->mockForumPostRepository->delete($postId);

        $this->assertTrue($result);
    }
}