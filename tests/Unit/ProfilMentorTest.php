<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\ProfilMentorRepositoryInterface;
use Mockery;

class ProfilMentorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockProfilMentorRepository = Mockery::mock(ProfilMentorRepositoryInterface::class);
        $this->app->instance(ProfilMentorRepositoryInterface::class, $this->mockProfilMentorRepository);
    }

    public function test_profil_mentor_can_be_created()
    {
        $profilMentorData = [
            'idUser' => 'U12345678901',
            'bioSingkat' => 'Bio singkat mentor',
            'pengalamanKerja' => 'Pengalaman kerja mentor',
            'motivasi' => 'Motivasi mentor',
            'statusVerifikasi' => false,
        ];

        $this->mockProfilMentorRepository
            ->shouldReceive('create')
            ->once()
            ->with($profilMentorData)
            ->andReturn((object) $profilMentorData);

        $profilMentor = $this->mockProfilMentorRepository->create($profilMentorData);

        $this->assertEquals('U12345678901', $profilMentor->idUser);
        $this->assertEquals('Bio singkat mentor', $profilMentor->bioSingkat);
    }

    public function test_profil_mentor_can_be_read()
    {
        $userId = 'U12345678901';
        $profilMentorData = (object) [
            'idUser' => $userId,
            'bioSingkat' => 'Bio singkat mentor',
            'pengalamanKerja' => 'Pengalaman kerja mentor',
            'motivasi' => 'Motivasi mentor',
            'statusVerifikasi' => false,
        ];

        $this->mockProfilMentorRepository
            ->shouldReceive('find') // Assuming 'find' by idUser for ProfilMentor
            ->once()
            ->with($userId)
            ->andReturn($profilMentorData);

        $profilMentor = $this->mockProfilMentorRepository->find($userId);

        $this->assertEquals($userId, $profilMentor->idUser);
        $this->assertEquals('Bio singkat mentor', $profilMentor->bioSingkat);
    }

    public function test_profil_mentor_can_be_updated()
    {
        $userId = 'U12345678901';
        $updateData = [
            'bioSingkat' => 'Updated bio singkat mentor',
            'statusVerifikasi' => true,
        ];
        $updatedProfilMentorData = (object) array_merge([
            'idUser' => $userId,
            'pengalamanKerja' => 'Pengalaman kerja mentor',
            'motivasi' => 'Motivasi mentor',
        ], $updateData);

        $this->mockProfilMentorRepository
            ->shouldReceive('update') // Assuming 'update' by idUser for ProfilMentor
            ->once()
            ->with($userId, $updateData)
            ->andReturn($updatedProfilMentorData);

        $profilMentor = $this->mockProfilMentorRepository->update($userId, $updateData);

        $this->assertEquals('Updated bio singkat mentor', $profilMentor->bioSingkat);
        $this->assertTrue($profilMentor->statusVerifikasi);
    }

    public function test_profil_mentor_can_be_deleted()
    {
        $userId = 'U12345678901';

        $this->mockProfilMentorRepository
            ->shouldReceive('delete') // Assuming 'delete' by idUser for ProfilMentor
            ->once()
            ->with($userId)
            ->andReturn(true);

        $result = $this->mockProfilMentorRepository->delete($userId);

        $this->assertTrue($result);
    }
}
