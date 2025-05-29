<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\UserRepositoryInterface;
use Mockery;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockUserRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->app->instance(UserRepositoryInterface::class, $this->mockUserRepository);
    }

    public function test_user_can_be_created()
    {
        $userData = [
            'idUser' => 'U12345678901',
            'namaLengkap' => 'Test User',
            'email' => 'test@example.com',
            'noHP' => '081234567890',
        ];

        $this->mockUserRepository
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn((object) $userData);

        $user = $this->mockUserRepository->create($userData);

        $this->assertEquals('Test User', $user->namaLengkap);
        $this->assertEquals('test@example.com', $user->email);
    }

    public function test_user_can_be_read()
    {
        $userId = 'U12345678901';
        $userData = (object) [
            'idUser' => $userId,
            'namaLengkap' => 'Test User',
            'email' => 'test@example.com',
            'noHP' => '081234567890',
        ];

        $this->mockUserRepository
            ->shouldReceive('find')
            ->once()
            ->with($userId)
            ->andReturn($userData);

        $user = $this->mockUserRepository->find($userId);

        $this->assertEquals($userId, $user->idUser);
        $this->assertEquals('Test User', $user->namaLengkap);
    }

    public function test_user_can_be_updated()
    {
        $userId = 'U12345678901';
        $updateData = [
            'namaLengkap' => 'Updated Test User',
            'noHP' => '089876543210',
        ];
        $updatedUserData = (object) array_merge(['idUser' => $userId, 'email' => 'test@example.com'], $updateData);

        $this->mockUserRepository
            ->shouldReceive('update')
            ->once()
            ->with($userId, $updateData)
            ->andReturn($updatedUserData);

        $user = $this->mockUserRepository->update($userId, $updateData);

        $this->assertEquals('Updated Test User', $user->namaLengkap);
        $this->assertEquals('089876543210', $user->noHP);
    }

    public function test_user_can_be_deleted()
    {
        $userId = 'U12345678901';

        $this->mockUserRepository
            ->shouldReceive('delete')
            ->once()
            ->with($userId)
            ->andReturn(true);

        $result = $this->mockUserRepository->delete($userId);

        $this->assertTrue($result);
    }
}