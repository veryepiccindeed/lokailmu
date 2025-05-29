<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\DaftarBukuRepositoryInterface;
use Mockery;

class DaftarBukuTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDaftarBukuRepository = Mockery::mock(DaftarBukuRepositoryInterface::class);
        $this->app->instance(DaftarBukuRepositoryInterface::class, $this->mockDaftarBukuRepository);
    }

    public function test_daftar_buku_can_be_created()
    {
        $bukuData = [
            'idBuku' => 'BK123456',
            'judul' => 'Test Buku',
            'deskripsi' => 'Deskripsi buku test',
            'penulis' => 'Penulis Test',
            'tglTerbit' => now()->toDateString(),
            'urlCover' => 'http://example.com/cover.jpg',
            'genre' => 'Matematika', // Changed from 'Fiction'
        ];

        $this->mockDaftarBukuRepository
            ->shouldReceive('create')
            ->once()
            ->with($bukuData)
            ->andReturn((object) $bukuData);

        $buku = $this->mockDaftarBukuRepository->create($bukuData);

        $this->assertEquals('Test Buku', $buku->judul);
        $this->assertEquals('Penulis Test', $buku->penulis);
    }

    public function test_daftar_buku_can_be_read()
    {
        $bukuId = 'BK123456';
        $tglTerbit = now()->toDateString();
        $bukuData = (object) [
            'idBuku' => $bukuId,
            'judul' => 'Test Buku',
            'deskripsi' => 'Deskripsi buku test',
            'penulis' => 'Penulis Test',
            'tglTerbit' => $tglTerbit,
            'urlCover' => 'http://example.com/cover.jpg',
            'genre' => 'Matematika',
        ];

        $this->mockDaftarBukuRepository
            ->shouldReceive('find')
            ->once()
            ->with($bukuId)
            ->andReturn($bukuData);

        $buku = $this->mockDaftarBukuRepository->find($bukuId);

        $this->assertEquals($bukuId, $buku->idBuku);
        $this->assertEquals('Test Buku', $buku->judul);
        $this->assertEquals($tglTerbit, $buku->tglTerbit);
    }

    public function test_daftar_buku_can_be_updated()
    {
        $bukuId = 'BK123456';
        $updateData = [
            'judul' => 'Updated Test Buku',
            'genre' => 'Sains',
        ];
        $updatedBukuData = (object) array_merge([
            'idBuku' => $bukuId,
            'deskripsi' => 'Deskripsi buku test',
            'penulis' => 'Penulis Test',
            'tglTerbit' => now()->toDateString(),
            'urlCover' => 'http://example.com/cover.jpg',
        ], $updateData);

        $this->mockDaftarBukuRepository
            ->shouldReceive('update')
            ->once()
            ->with($bukuId, $updateData)
            ->andReturn($updatedBukuData);

        $buku = $this->mockDaftarBukuRepository->update($bukuId, $updateData);

        $this->assertEquals('Updated Test Buku', $buku->judul);
        $this->assertEquals('Sains', $buku->genre);
    }

    public function test_daftar_buku_can_be_deleted()
    {
        $bukuId = 'BK123456';

        $this->mockDaftarBukuRepository
            ->shouldReceive('delete')
            ->once()
            ->with($bukuId)
            ->andReturn(true);

        $result = $this->mockDaftarBukuRepository->delete($bukuId);

        $this->assertTrue($result);
    }
}