<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProfilGuru;
use App\Models\ProfilMentor;
use App\Models\SpesialisasiUser;
use App\Models\Pembayaran;
use App\Models\PendaftaranPelatihan;
use App\Models\ForumPost;
use App\Models\ForumLike;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->idUser);
        $this->assertNotNull($user->namaLengkap);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->noHP);
    }

    public function test_user_has_profil_guru_relationship()
    {
        $user = User::factory()
            ->has(ProfilGuru::factory())
            ->create();

        $this->assertInstanceOf(ProfilGuru::class, $user->profilGuru);
        $this->assertEquals($user->idUser, $user->profilGuru->idUser);
    }

    public function test_user_has_profil_mentor_relationship()
    {
        $user = User::factory()
            ->has(ProfilMentor::factory())
            ->create();

        $this->assertInstanceOf(ProfilMentor::class, $user->profilMentor);
        $this->assertEquals($user->idUser, $user->profilMentor->idUser);
    }

    public function test_user_has_many_relationships()
    {
        $user = User::factory()
            ->has(SpesialisasiUser::factory()->count(2))
            ->has(Pembayaran::factory()->count(2))
            ->has(PendaftaranPelatihan::factory()->count(2))
            ->has(ForumPost::factory()->count(2))
            ->has(ForumLike::factory()->count(2))
            ->create();

        $this->assertCount(2, $user->spesialisasiUsers);
        $this->assertCount(2, $user->pembayarans);
        $this->assertCount(2, $user->pendaftaranPelatihans);
        $this->assertCount(2, $user->forumPosts);
        $this->assertCount(2, $user->forumLikes);
    }
}