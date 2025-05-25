<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DaftarBukuOffline;
use App\Models\DaftarBuku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DaftarBukuOfflineTest extends TestCase
{
    use RefreshDatabase;

    public function test_daftar_buku_offline_can_be_created()
    {
        $user = User::factory()->create();
        $buku = DaftarBuku::factory()->create();
        $bukuOffline = DaftarBukuOffline::factory()->create([
            'idBuku' => $buku->idBuku,
            'idUser' => $user->idUser,
        ]);
        $this->assertInstanceOf(DaftarBukuOffline::class, $bukuOffline);
        $this->assertNotNull($bukuOffline->idBuku);
        $this->assertNotNull($bukuOffline->idUser);
        $this->assertNotNull($bukuOffline->pathCache);
        $this->assertNotNull($bukuOffline->tglDownload);
        $this->assertNotNull($bukuOffline->tglAkses);
    }

    public function test_daftar_buku_offline_has_relationships()
    {
        $user = User::factory()->create();
        $buku = DaftarBuku::factory()->create();
        $bukuOffline = DaftarBukuOffline::factory()->create([
            'idBuku' => $buku->idBuku,
            'idUser' => $user->idUser,
        ]);
        $this->assertInstanceOf(DaftarBuku::class, $bukuOffline->buku);
        $this->assertInstanceOf(User::class, $bukuOffline->user);
    }
}