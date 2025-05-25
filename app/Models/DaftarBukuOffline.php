<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarBukuOffline extends Model
{
    use HasFactory;

    protected $table = 'daftarbukuofflines';
    protected $primaryKey = 'idOffline';
    public $incrementing = false; // Tambahkan ini
    protected $keyType = 'string';   // Tambahkan ini
    public $timestamps = false; // Karena ada tglDownload dan tglAkses, bukan created_at/updated_at

    protected $fillable = [
        'idBuku',
        'idUser',
        'pathCache',
        'tglDownload',
        'tglAkses',
    ];

    protected $casts = [
        'tglDownload' => 'datetime',
        'tglAkses' => 'datetime',
    ];

    // Relasi
    public function buku()
    {
        return $this->belongsTo(DaftarBuku::class, 'idBuku', 'idBuku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
}
