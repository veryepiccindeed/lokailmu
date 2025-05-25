<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DaftarBuku;
use App\Models\DaftarBukuOffline;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DaftarBukuTest extends TestCase
{
    use RefreshDatabase;

    public function test_daftar_buku_can_be_created()
    {
        $buku = DaftarBuku::factory()->create();
        $this->assertInstanceOf(DaftarBuku::class, $buku);
        $this->assertNotNull($buku->idBuku);
        $this->assertNotNull($buku->judul);
        $this->assertNotNull($buku->deskripsi);
        $this->assertNotNull($buku->penulis);
        $this->assertNotNull($buku->tglTerbit);
        $this->assertNotNull($buku->urlCover);
        $this->assertNotNull($buku->genre);
    }

    public function test_daftar_buku_has_offline_downloads_relationship()
    {
        $user = \App\Models\User::factory()->create();
        $buku = DaftarBuku::factory()->create();
        DaftarBukuOffline::factory()->count(2)->create([
            'idBuku' => $buku->idBuku,
            'idUser' => $user->idUser,
        ]);
        $buku->refresh();
        $this->assertCount(2, $buku->offlineDownloads);
    }
}