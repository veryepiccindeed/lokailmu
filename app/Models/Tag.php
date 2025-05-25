<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'idTag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tag',
    ];

    public $timestamps = false;

    /**
     * The thread forums that belong to the tag.
     */
    public function threadForums()
    {
        return $this->belongsToMany(ThreadForum::class, 'tagthreads', 'idTag', 'idThread');
    }
}