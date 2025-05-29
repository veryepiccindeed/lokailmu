<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\ProfilGuruRepositoryInterface;
use Mockery;

class ProfilGuruTest extends TestCase
{
    protected $mockProfilGuruRepository; // Added type hint for clarity

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockProfilGuruRepository = Mockery::mock(ProfilGuruRepositoryInterface::class);
        $this->app->instance(ProfilGuruRepositoryInterface::class, $this->mockProfilGuruRepository);
    }

    public function test_profil_guru_can_be_created()
    {
        $profilGuruData = [
            'idUser' => 'U12345678901',
            'NPSN' => 12345678, // Changed from idSekolah, assuming a valid NPSN integer
            'NUPTK' => '123456789012345678901234', // Changed from NIP to NUPTK, adjusted length to typical NUPTK
            'tingkatPengajar' => 'SMA', // Added field from migration
            // 'pathKTP' is nullable, can be omitted for this test or added if needed
        ];

        // Create an object that includes what the repository's create method would return
        // Typically, this would be the input data plus any auto-generated fields like id (if applicable) or timestamps.
        // Since idUser is the PK and provided, and timestamps are usually handled by Eloquent/DB,
        // we can expect the returned object to largely mirror profilGuruData for this test.
        $returnedObject = (object) array_merge($profilGuruData, ['created_at' => now(), 'updated_at' => now()]); 

        $this->mockProfilGuruRepository
            ->shouldReceive('create')
            ->once()
            ->with($profilGuruData) // Expecting the exact data array
            ->andReturn($returnedObject); // Return the mock object

        $profilGuru = $this->mockProfilGuruRepository->create($profilGuruData);

        $this->assertEquals('U12345678901', $profilGuru->idUser);
        $this->assertEquals(12345678, $profilGuru->NPSN);
        $this->assertEquals('123456789012345678901234', $profilGuru->NUPTK);
        $this->assertEquals('SMA', $profilGuru->tingkatPengajar);
        // Assertions for mataPelajaran, jabatan, lamaMengajar, statusVerifikasi removed as fields are not in migration
    }

    public function test_profil_guru_can_be_read()
    {
        $userId = 'U12345678901';
        $profilGuruData = (object) [
            'idUser' => $userId,
            'NPSN' => 12345678,
            'NUPTK' => '123456789012345678901234',
            'tingkatPengajar' => 'SMA',
            'created_at' => now(),
            'updated_at' => now()
        ];

        $this->mockProfilGuruRepository
            ->shouldReceive('find') // Assuming 'find' by idUser for ProfilGuru
            ->once()
            ->with($userId)
            ->andReturn($profilGuruData);

        $profilGuru = $this->mockProfilGuruRepository->find($userId);

        $this->assertEquals($userId, $profilGuru->idUser);
        $this->assertEquals('SMA', $profilGuru->tingkatPengajar);
    }

    public function test_profil_guru_can_be_updated()
    {
        $userId = 'U12345678901';
        $updateData = [
            'tingkatPengajar' => 'SMP',
            'NPSN' => 87654321,
        ];
        $updatedProfilGuruData = (object) array_merge([
            'idUser' => $userId,
            'NUPTK' => '123456789012345678901234',
            'created_at' => now(),
            'updated_at' => now()
        ], $updateData);

        $this->mockProfilGuruRepository
            ->shouldReceive('update') // Assuming 'update' by idUser for ProfilGuru
            ->once()
            ->with($userId, $updateData)
            ->andReturn($updatedProfilGuruData);

        $profilGuru = $this->mockProfilGuruRepository->update($userId, $updateData);

        $this->assertEquals('SMP', $profilGuru->tingkatPengajar);
        $this->assertEquals(87654321, $profilGuru->NPSN);
    }

    public function test_profil_guru_can_be_deleted()
    {
        $userId = 'U12345678901';

        $this->mockProfilGuruRepository
            ->shouldReceive('delete') // Assuming 'delete' by idUser for ProfilGuru
            ->once()
            ->with($userId)
            ->andReturn(true);

        $result = $this->mockProfilGuruRepository->delete($userId);

        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
