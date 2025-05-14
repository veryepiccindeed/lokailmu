<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadForum extends Model
{
    use HasFactory;

    protected $table = 'threadforums';
    protected $primaryKey = 'idThread';

    protected $fillable = [
        'judul',
        'idPostUtama',
    ];

    /**
     * Get the main post for the thread forum.
     */
    public function postUtama()
    {
        return $this->belongsTo(ForumPost::class, 'idPostUtama', 'idPost');
    }

    /**
     * Get all posts in the thread forum.
     */
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'idThread', 'idThread');
    }

    /**
     * The tags that belong to the thread forum.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tagthreads', 'idThread', 'idTag');
    }
} 