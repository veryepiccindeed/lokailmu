<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\SpesialisasiUserRepositoryInterface;
use Mockery;

class SpesialisasiUserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockSpesialisasiUserRepository = Mockery::mock(SpesialisasiUserRepositoryInterface::class);
        $this->app->instance(SpesialisasiUserRepositoryInterface::class, $this->mockSpesialisasiUserRepository);
    }

    public function test_spesialisasi_user_can_be_created()
    {
        $spesialisasiData = [
            'idSpesialisasiUser' => 1,
            'idUser' => 'U12345678901',
            'spesialisasi' => 'Web Development',
        ];

        $this->mockSpesialisasiUserRepository
            ->shouldReceive('create')
            ->once()
            ->with($spesialisasiData)
            ->andReturn((object) $spesialisasiData);

        $spesialisasiUser = $this->mockSpesialisasiUserRepository->create($spesialisasiData);

        $this->assertEquals(1, $spesialisasiUser->idSpesialisasiUser);
        $this->assertEquals('Web Development', $spesialisasiUser->spesialisasi);
    }

    public function test_spesialisasi_user_can_be_read()
    {
        $spesialisasiId = 1;
        $spesialisasiData = (object) [
            'idSpesialisasiUser' => $spesialisasiId,
            'idUser' => 'U12345678901',
            'spesialisasi' => 'Web Development',
        ];

        $this->mockSpesialisasiUserRepository
            ->shouldReceive('find')
            ->once()
            ->with($spesialisasiId)
            ->andReturn($spesialisasiData);

        $spesialisasiUser = $this->mockSpesialisasiUserRepository->find($spesialisasiId);

        $this->assertEquals($spesialisasiId, $spesialisasiUser->idSpesialisasiUser);
        $this->assertEquals('Web Development', $spesialisasiUser->spesialisasi);
    }

    public function test_spesialisasi_user_can_be_updated()
    {
        $spesialisasiId = 1;
        $updateData = [
            'spesialisasi' => 'Mobile Development',
        ];
        $updatedSpesialisasiData = (object) array_merge(['idSpesialisasiUser' => $spesialisasiId, 'idUser' => 'U12345678901'], $updateData);

        $this->mockSpesialisasiUserRepository
            ->shouldReceive('update')
            ->once()
            ->with($spesialisasiId, $updateData)
            ->andReturn($updatedSpesialisasiData);

        $spesialisasiUser = $this->mockSpesialisasiUserRepository->update($spesialisasiId, $updateData);

        $this->assertEquals('Mobile Development', $spesialisasiUser->spesialisasi);
    }

    public function test_spesialisasi_user_can_be_deleted()
    {
        $spesialisasiId = 1;

        $this->mockSpesialisasiUserRepository
            ->shouldReceive('delete')
            ->once()
            ->with($spesialisasiId)
            ->andReturn(true);

        $result = $this->mockSpesialisasiUserRepository->delete($spesialisasiId);

        $this->assertTrue($result);
    }
}
