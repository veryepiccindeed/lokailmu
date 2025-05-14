<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'idTransaksi';
    public $incrementing = false; // Since idTransaksi is a string
    protected $keyType = 'string'; // Since idTransaksi is a string

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idTransaksi',
        'idGuru',
        'idPelatihan',
        'total',
        'jumlahDP',
        'statusByr',
        'tglBayarDP',
        'tglLunas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tglBayarDP' => 'datetime',
        'tglLunas' => 'datetime',
        'total' => 'decimal:2',
        'jumlahDP' => 'decimal:2',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'idPelatihan', 'idPelatihan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idGuru', 'idUser');
    }
} 