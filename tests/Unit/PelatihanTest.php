<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pelatihan;
use App\Models\User;
use App\Models\PendaftaranPelatihan;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PelatihanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelatihan_can_be_created()
    {
        $pelatihan = Pelatihan::factory()->create();
        $this->assertInstanceOf(Pelatihan::class, $pelatihan);
        $this->assertNotNull($pelatihan->idPelatihan);
        $this->assertNotNull($pelatihan->judul);
        $this->assertNotNull($pelatihan->deskripsi);
        $this->assertNotNull($pelatihan->biaya);
        $this->assertNotNull($pelatihan->idMentor);
    }

    public function test_pelatihan_has_relationships()
    {
        $pelatihan = Pelatihan::factory()
            ->has(PendaftaranPelatihan::factory()->count(2))
            ->has(Pembayaran::factory()->count(2))
            ->create();

        $this->assertInstanceOf(User::class, $pelatihan->mentor);
        $this->assertCount(2, $pelatihan->pendaftaranPelatihans);
        $this->assertCount(2, $pelatihan->pembayarans);
    }
}