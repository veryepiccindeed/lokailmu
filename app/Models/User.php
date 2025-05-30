<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idUser',
        'namaLengkap',
        'email',
        'noHP',
        'tglLahir',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $primaryKey = 'idUser'; // Assuming idUser is the primary key based on other tables
    public $incrementing = false; // Assuming idUser is not auto-incrementing (e.g. string)
    protected $keyType = 'string'; // Assuming idUser is a string

    public function profilGuru()
    {
        return $this->hasOne(ProfilGuru::class, 'idUser', 'idUser');
    }

    public function profilMentor()
    {
        return $this->hasOne(ProfilMentor::class, 'idUser', 'idUser');
    }

    public function spesialisasiUsers()
    {
        return $this->hasMany(SpesialisasiUser::class, 'idUser', 'idUser');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'idGuru', 'idUser');
    }

    public function pendaftaranPelatihans()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'idUser', 'idUser');
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'dibuatOleh', 'idUser');
    }

    public function forumLikes()
    {
        return $this->hasMany(ForumLike::class, 'likeOleh', 'idUser');
    }

    // Conversations where the user is a guru
    public function conversationsAsGuru()
    {
        return $this->hasMany(Conversation::class, 'guru_id', 'idUser');
    }

    // Conversations where the user is a mentor
    public function conversationsAsMentor()
    {
        return $this->hasMany(Conversation::class, 'mentor_id', 'idUser');
    }

    // All conversations for the user
    public function allConversations()
    {
        return Conversation::where('guru_id', $this->idUser)
                            ->orWhere('mentor_id', $this->idUser);
    }

    // Messages sent by the user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'idUser');
    }

    // Messages received by the user (though typically accessed via conversation)
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'idUser');
    }
}
