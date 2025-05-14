<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;

    protected $table = 'forumlikes';
    protected $primaryKey = 'idLike';
    public $timestamps = false; // tglLike adalah custom

    // Laravel akan otomatis mengelola tglLike jika didefinisikan sebagai const UPDATED_AT = 'tglLike';
    // Namun, karena ada ON UPDATE current_timestamp(), lebih baik biarkan DB yang mengelola.
    // Jika ingin Laravel mengelolanya, hapus ON UPDATE current_timestamp() dari skema.
    // Untuk saat ini, kita set $timestamps = false dan tglLike di $fillable jika perlu diisi manual.

    protected $fillable = [
        'idPost',
        'likeOleh',
        'tglLike', // Jika ingin diisi manual oleh aplikasi
    ];

    protected $casts = [
        'tglLike' => 'datetime',
    ];

    // Relasi
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'idPost', 'idPost');
    }

    public function user() // atau liker()
    {
        return $this->belongsTo(User::class, 'likeOleh', 'idUser');
    }
}
