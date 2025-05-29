<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\PelatihanRepositoryInterface;
use Mockery;

class PelatihanTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockPelatihanRepository = Mockery::mock(PelatihanRepositoryInterface::class);
        $this->app->instance(PelatihanRepositoryInterface::class, $this->mockPelatihanRepository);
    }

    public function test_pelatihan_can_be_created()
    {
        $pelatihanData = [
            'idPelatihan' => 'PLT123456',
            'judul' => 'Test Pelatihan',
            'deskripsi' => 'Deskripsi pelatihan test',
            'biaya' => 100000.00, // Changed from 100000
            'idMentor' => 'U12345678901',
        ];

        $this->mockPelatihanRepository
            ->shouldReceive('create')
            ->once()
            ->with($pelatihanData)
            ->andReturn((object) $pelatihanData);

        $pelatihan = $this->mockPelatihanRepository->create($pelatihanData);

        $this->assertEquals('PLT123456', $pelatihan->idPelatihan);
        $this->assertEquals('Test Pelatihan', $pelatihan->judul);
    }

    public function test_pelatihan_can_be_read()
    {
        $pelatihanId = 'PLT123456';
        $pelatihanData = (object) [
            'idPelatihan' => $pelatihanId,
            'judul' => 'Test Pelatihan',
            'deskripsi' => 'Deskripsi pelatihan test',
            'biaya' => 100000.00,
            'idMentor' => 'U12345678901',
        ];

        $this->mockPelatihanRepository
            ->shouldReceive('find')
            ->once()
            ->with($pelatihanId)
            ->andReturn($pelatihanData);

        $pelatihan = $this->mockPelatihanRepository->find($pelatihanId);

        $this->assertEquals($pelatihanId, $pelatihan->idPelatihan);
        $this->assertEquals('Test Pelatihan', $pelatihan->judul);
    }

    public function test_pelatihan_can_be_updated()
    {
        $pelatihanId = 'PLT123456';
        $updateData = [
            'judul' => 'Updated Test Pelatihan',
            'biaya' => 150000.00,
        ];
        $updatedPelatihanData = (object) array_merge([
            'idPelatihan' => $pelatihanId,
            'deskripsi' => 'Deskripsi pelatihan test',
            'idMentor' => 'U12345678901',
        ], $updateData);

        $this->mockPelatihanRepository
            ->shouldReceive('update')
            ->once()
            ->with($pelatihanId, $updateData)
            ->andReturn($updatedPelatihanData);

        $pelatihan = $this->mockPelatihanRepository->update($pelatihanId, $updateData);

        $this->assertEquals('Updated Test Pelatihan', $pelatihan->judul);
        $this->assertEquals(150000.00, $pelatihan->biaya);
    }

    public function test_pelatihan_can_be_deleted()
    {
        $pelatihanId = 'PLT123456';

        $this->mockPelatihanRepository
            ->shouldReceive('delete')
            ->once()
            ->with($pelatihanId)
            ->andReturn(true);

        $result = $this->mockPelatihanRepository->delete($pelatihanId);

        $this->assertTrue($result);
    }
}