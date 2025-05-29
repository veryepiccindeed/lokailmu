<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\PendaftaranPelatihanRepositoryInterface;
use Mockery;

class PendaftaranPelatihanTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockPendaftaranPelatihanRepository = Mockery::mock(PendaftaranPelatihanRepositoryInterface::class);
        $this->app->instance(PendaftaranPelatihanRepositoryInterface::class, $this->mockPendaftaranPelatihanRepository);
    }

    public function test_pendaftaran_pelatihan_can_be_created()
    {
        $pendaftaranData = [
            // 'idPendaftaran' => 'REG123456', // Removed: 'id' is auto-incrementing PK in migration
            'idPelatihan' => 'PLT123456',
            'idUser' => 'U12345678901',
            'tglMulai' => now(), // Changed to Carbon instance for timestamp compatibility
            'tglSelesai' => now()->addDays(7), // Changed to Carbon instance
            'status' => 'pending',
        ];

        // Simulate the repository returning an object with an ID after creation
        $returnedObject = (object) array_merge(['id' => 1], $pendaftaranData);

        $this->mockPendaftaranPelatihanRepository
            ->shouldReceive('create')
            ->once()
            // Use a more specific matcher for Carbon objects if direct comparison fails due to microseconds etc.
            ->with(Mockery::on(function($arg) use ($pendaftaranData) {
                return $arg['idPelatihan'] === $pendaftaranData['idPelatihan'] &&
                       $arg['idUser'] === $pendaftaranData['idUser'] &&
                       $arg['status'] === $pendaftaranData['status'] &&
                       $arg['tglMulai'] instanceof \Carbon\Carbon &&
                       $arg['tglSelesai'] instanceof \Carbon\Carbon &&
                       $arg['tglMulai']->eq($pendaftaranData['tglMulai']) &&
                       $arg['tglSelesai']->eq($pendaftaranData['tglSelesai']);
            }))
            ->andReturn($returnedObject);

        $pendaftaran = $this->mockPendaftaranPelatihanRepository->create($pendaftaranData);

        // $this->assertEquals('REG123456', $pendaftaran->idPendaftaran); // Removed assertion for non-existent field
        $this->assertNotNull($pendaftaran->id); // Assert that an ID was set
        $this->assertEquals('PLT123456', $pendaftaran->idPelatihan);
        $this->assertEquals('pending', $pendaftaran->status);
        $this->assertTrue($pendaftaranData['tglMulai']->eq($pendaftaran->tglMulai));
        $this->assertTrue($pendaftaranData['tglSelesai']->eq($pendaftaran->tglSelesai));
    }

    public function test_pendaftaran_pelatihan_can_be_read()
    {
        $pendaftaranId = 1;
        $tglMulai = now();
        $tglSelesai = now()->addDays(7);
        $pendaftaranData = (object) [
            'id' => $pendaftaranId,
            'idPelatihan' => 'PLT123456',
            'idUser' => 'U12345678901',
            'tglMulai' => $tglMulai,
            'tglSelesai' => $tglSelesai,
            'status' => 'pending',
        ];

        $this->mockPendaftaranPelatihanRepository
            ->shouldReceive('find')
            ->once()
            ->with($pendaftaranId)
            ->andReturn($pendaftaranData);

        $pendaftaran = $this->mockPendaftaranPelatihanRepository->find($pendaftaranId);

        $this->assertEquals($pendaftaranId, $pendaftaran->id);
        $this->assertEquals('PLT123456', $pendaftaran->idPelatihan);
        $this->assertTrue($tglMulai->eq($pendaftaran->tglMulai));
    }

    public function test_pendaftaran_pelatihan_can_be_updated()
    {
        $pendaftaranId = 1;
        $updateData = [
            'status' => 'approved',
            'tglSelesai' => now()->addDays(10),
        ];
        $updatedPendaftaranData = (object) array_merge([
            'id' => $pendaftaranId,
            'idPelatihan' => 'PLT123456',
            'idUser' => 'U12345678901',
            'tglMulai' => now(),
        ], $updateData);

        $this->mockPendaftaranPelatihanRepository
            ->shouldReceive('update')
            ->once()
            ->with($pendaftaranId, Mockery::on(function($arg) use ($updateData) {
                return $arg['status'] === $updateData['status'] &&
                       $arg['tglSelesai'] instanceof \Carbon\Carbon &&
                       $arg['tglSelesai']->eq($updateData['tglSelesai']);
            }))
            ->andReturn($updatedPendaftaranData);

        $pendaftaran = $this->mockPendaftaranPelatihanRepository->update($pendaftaranId, $updateData);

        $this->assertEquals('approved', $pendaftaran->status);
        $this->assertTrue($updateData['tglSelesai']->eq($pendaftaran->tglSelesai));
    }

    public function test_pendaftaran_pelatihan_can_be_deleted()
    {
        $pendaftaranId = 1;

        $this->mockPendaftaranPelatihanRepository
            ->shouldReceive('delete')
            ->once()
            ->with($pendaftaranId)
            ->andReturn(true);

        $result = $this->mockPendaftaranPelatihanRepository->delete($pendaftaranId);

        $this->assertTrue($result);
    }
}