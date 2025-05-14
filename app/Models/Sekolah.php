<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolahs';
    protected $primaryKey = 'idSekolah';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NPSN',
        'alamatSekolah',
    ];

    /**
     * Get the guru profiles for the sekolah.
     */
    public function profilGurus()
    {
        return $this->hasMany(ProfilGuru::class, 'idSekolah', 'idSekolah');
    }
} 