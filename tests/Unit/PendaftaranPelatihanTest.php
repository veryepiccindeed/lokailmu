<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PendaftaranPelatihan;
use App\Models\User;
use App\Models\Pelatihan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PendaftaranPelatihanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pendaftaran_pelatihan_can_be_created()
    {
        $pendaftaran = PendaftaranPelatihan::factory()->create();
        $this->assertInstanceOf(PendaftaranPelatihan::class, $pendaftaran);
        $this->assertNotNull($pendaftaran->idPelatihan);
        $this->assertNotNull($pendaftaran->idUser);
        $this->assertNotNull($pendaftaran->tglMulai);
        $this->assertNotNull($pendaftaran->tglSelesai);
        $this->assertNotNull($pendaftaran->status);
    }

    public function test_pendaftaran_pelatihan_has_relationships()
    {
        $pendaftaran = PendaftaranPelatihan::factory()->create();

        $this->assertInstanceOf(Pelatihan::class, $pendaftaran->pelatihan);
        $this->assertInstanceOf(User::class, $pendaftaran->user);
    }
}