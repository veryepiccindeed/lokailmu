<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPelatihan extends Model
{
    use HasFactory;

    protected $table = 'pendaftaranpelatihans';
    // Laravel uses `created_at` and `updated_at` by default.
    // If tglMulai and tglSelesai are not meant to be these, 
    // we might need to set public $timestamps = false; or customize timestamp column names.
    // For now, assuming they are distinct fields and timestamps() in migration handles created_at/updated_at.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPelatihan',
        'idUser',
        'tglMulai',
        'tglSelesai',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tglMulai' => 'datetime',
        'tglSelesai' => 'datetime',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'idPelatihan', 'idPelatihan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
} 