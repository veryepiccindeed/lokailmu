<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $table = 'forumposts';
    protected $primaryKey = 'idPost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idThread',
        'dibuatOleh',
        'isi',
        'parentPost',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tglPost' => 'datetime',
    ];

    public function threadForum()
    {
        return $this->belongsTo(ThreadForum::class, 'idThread', 'idThread');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuatOleh', 'idUser');
    }

    public function parent()
    {
        return $this->belongsTo(ForumPost::class, 'parentPost', 'idPost');
    }

    public function replies()
    {
        return $this->hasMany(ForumPost::class, 'parentPost', 'idPost');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class, 'idPost', 'idPost');
    }

    public function mediaForums()
    {
        return $this->hasMany(MediaForum::class, 'idPost', 'idPost');
    }
} 