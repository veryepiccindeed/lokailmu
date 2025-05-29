<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\DaftarBukuOfflineRepositoryInterface;
use Mockery;

class DaftarBukuOfflineTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDaftarBukuOfflineRepository = Mockery::mock(DaftarBukuOfflineRepositoryInterface::class);
        $this->app->instance(DaftarBukuOfflineRepositoryInterface::class, $this->mockDaftarBukuOfflineRepository);
    }

    public function test_daftar_buku_offline_can_be_created()
    {
        $bukuOfflineData = [
            'idOffline' => 'OF123456',
            'idBuku' => 'BK123456',
            'idUser' => 'U12345678901',
            'pathCache' => '/cache/path',
            'tglDownload' => now(),
            'tglAkses' => now(),
        ];

        $this->mockDaftarBukuOfflineRepository
            ->shouldReceive('create')
            ->once()
            ->with($bukuOfflineData)
            ->andReturn((object) $bukuOfflineData);

        $bukuOffline = $this->mockDaftarBukuOfflineRepository->create($bukuOfflineData);

        $this->assertEquals('OF123456', $bukuOffline->idOffline);
        $this->assertEquals('BK123456', $bukuOffline->idBuku);
    }

    public function test_daftar_buku_offline_can_be_read()
    {
        $offlineId = 'OF123456';
        $tglDownload = now();
        $tglAkses = now();
        $bukuOfflineData = (object) [
            'idOffline' => $offlineId,
            'idBuku' => 'BK123456',
            'idUser' => 'U12345678901',
            'pathCache' => '/cache/path',
            'tglDownload' => $tglDownload,
            'tglAkses' => $tglAkses,
        ];

        $this->mockDaftarBukuOfflineRepository
            ->shouldReceive('find')
            ->once()
            ->with($offlineId)
            ->andReturn($bukuOfflineData);

        $bukuOffline = $this->mockDaftarBukuOfflineRepository->find($offlineId);

        $this->assertEquals($offlineId, $bukuOffline->idOffline);
        $this->assertEquals('BK123456', $bukuOffline->idBuku);
        $this->assertTrue($tglDownload->eq($bukuOffline->tglDownload));
    }

    public function test_daftar_buku_offline_can_be_updated()
    {
        $offlineId = 'OF123456';
        $newTglAkses = now()->addHour();
        $updateData = [
            'pathCache' => '/new/cache/path',
            'tglAkses' => $newTglAkses,
        ];
        $updatedBukuOfflineData = (object) array_merge([
            'idOffline' => $offlineId,
            'idBuku' => 'BK123456',
            'idUser' => 'U12345678901',
            'tglDownload' => now(),
        ], $updateData);

        $this->mockDaftarBukuOfflineRepository
            ->shouldReceive('update')
            ->once()
            ->with($offlineId, Mockery::on(function($arg) use ($updateData) {
                return $arg['pathCache'] === $updateData['pathCache'] &&
                       $arg['tglAkses'] instanceof \Carbon\Carbon &&
                       $arg['tglAkses']->eq($updateData['tglAkses']);
            }))
            ->andReturn($updatedBukuOfflineData);

        $bukuOffline = $this->mockDaftarBukuOfflineRepository->update($offlineId, $updateData);

        $this->assertEquals('/new/cache/path', $bukuOffline->pathCache);
        $this->assertTrue($newTglAkses->eq($bukuOffline->tglAkses));
    }

    public function test_daftar_buku_offline_can_be_deleted()
    {
        $offlineId = 'OF123456';

        $this->mockDaftarBukuOfflineRepository
            ->shouldReceive('delete')
            ->once()
            ->with($offlineId)
            ->andReturn(true);

        $result = $this->mockDaftarBukuOfflineRepository->delete($offlineId);

        $this->assertTrue($result);
    }
}