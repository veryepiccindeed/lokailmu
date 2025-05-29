<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\SekolahRepositoryInterface;
use Mockery;

class SekolahTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockSekolahRepository = Mockery::mock(SekolahRepositoryInterface::class);
        $this->app->instance(SekolahRepositoryInterface::class, $this->mockSekolahRepository);
    }

    public function test_sekolah_can_be_created()
    {
        $sekolahData = [
            'idSekolah' => 1,
            'namaSekolah' => 'SMA Negeri 1 Test',
            'alamatSekolah' => 'Jl. Test No. 1',
            'akreditasi' => 'A',
            'kurikulum' => 'K13',
            'statusSekolah' => 'Negeri',
        ];

        $this->mockSekolahRepository
            ->shouldReceive('create')
            ->once()
            ->with($sekolahData)
            ->andReturn((object) $sekolahData);

        $sekolah = $this->mockSekolahRepository->create($sekolahData);

        $this->assertEquals(1, $sekolah->idSekolah);
        $this->assertEquals('SMA Negeri 1 Test', $sekolah->namaSekolah);
    }

    public function test_sekolah_can_be_read()
    {
        $sekolahId = 1;
        $sekolahData = (object) [
            'idSekolah' => $sekolahId,
            'namaSekolah' => 'SMA Negeri 1 Test',
            'alamatSekolah' => 'Jl. Test No. 1',
            'akreditasi' => 'A',
            'kurikulum' => 'K13',
            'statusSekolah' => 'Negeri',
        ];

        $this->mockSekolahRepository
            ->shouldReceive('find')
            ->once()
            ->with($sekolahId)
            ->andReturn($sekolahData);

        $sekolah = $this->mockSekolahRepository->find($sekolahId);

        $this->assertEquals($sekolahId, $sekolah->idSekolah);
        $this->assertEquals('SMA Negeri 1 Test', $sekolah->namaSekolah);
    }

    public function test_sekolah_can_be_updated()
    {
        $sekolahId = 1;
        $updateData = [
            'namaSekolah' => 'SMA Negeri 2 Test',
            'akreditasi' => 'B',
        ];
        $updatedSekolahData = (object) array_merge([
            'idSekolah' => $sekolahId,
            'alamatSekolah' => 'Jl. Test No. 1',
            'kurikulum' => 'K13',
            'statusSekolah' => 'Negeri',
        ], $updateData);

        $this->mockSekolahRepository
            ->shouldReceive('update')
            ->once()
            ->with($sekolahId, $updateData)
            ->andReturn($updatedSekolahData);

        $sekolah = $this->mockSekolahRepository->update($sekolahId, $updateData);

        $this->assertEquals('SMA Negeri 2 Test', $sekolah->namaSekolah);
        $this->assertEquals('B', $sekolah->akreditasi);
    }

    public function test_sekolah_can_be_deleted()
    {
        $sekolahId = 1;

        $this->mockSekolahRepository
            ->shouldReceive('delete')
            ->once()
            ->with($sekolahId)
            ->andReturn(true);

        $result = $this->mockSekolahRepository->delete($sekolahId);

        $this->assertTrue($result);
    }
}
