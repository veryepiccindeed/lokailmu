<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Pelatihan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    public function test_pembayaran_can_be_created()
    {
        $pembayaran = Pembayaran::factory()->create();
        $this->assertInstanceOf(Pembayaran::class, $pembayaran);
        $this->assertNotNull($pembayaran->idTransaksi);
        $this->assertNotNull($pembayaran->idGuru);
        $this->assertNotNull($pembayaran->idPelatihan);
        $this->assertNotNull($pembayaran->total);
        $this->assertNotNull($pembayaran->jumlahDP);
        $this->assertNotNull($pembayaran->statusByr);
    }

    public function test_pembayaran_has_relationships()
    {
        $pembayaran = Pembayaran::factory()->create();

        $this->assertInstanceOf(Pelatihan::class, $pembayaran->pelatihan);
        $this->assertInstanceOf(User::class, $pembayaran->user);
    }
}