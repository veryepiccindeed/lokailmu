<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPelatihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idPelatihan',
        'judul',
        'deskripsi',
        'biaya',
        'idMentor',
    ];

    /**
     * Get the mentor that owns the pelatihan.
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'idMentor', 'idUser');
    }

    /**
     * Get the pendaftaran pelatihans for the pelatihan.
     */
    public function pendaftaranPelatihans()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'idPelatihan', 'idPelatihan');
    }

    /**
     * Get the pembayarans for the pelatihan.
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'idPelatihan', 'idPelatihan');
    }
} 