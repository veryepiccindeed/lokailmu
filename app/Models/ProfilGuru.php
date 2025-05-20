<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilGuru extends Model
{
    use HasFactory;

    protected $table = 'profilgurus';
    protected $primaryKey = 'idUser';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idUser',
        'NUPTK',
        'NPSN',
        'tingkatPengajar',
        'pathKTP',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'idSekolah', 'idSekolah');
    }
} 