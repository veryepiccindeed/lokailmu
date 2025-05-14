<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaForum extends Model
{
    use HasFactory;

    protected $table = 'mediaforums';
    protected $primaryKey = 'idmedia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPost',
        'urlMedia',
    ];

    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'idPost', 'idPost');
    }
} 