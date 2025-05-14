<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarBuku extends Model
{
    use HasFactory;

    protected $table = 'daftarbukus';
    protected $primaryKey = 'idBuku';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idBuku',
        'judul',
        'deskripsi',
        'penulis',
        'tglTerbit',
        'urlCover',
        'genre',
    ];

    protected $casts = [
        'tglTerbit' => 'date',
    ];

    // Relasi
    public function offlineDownloads()
    {
        return $this->hasMany(DaftarBukuOffline::class, 'idBuku', 'idBuku');
    }
}
