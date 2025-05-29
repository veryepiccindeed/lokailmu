<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\ThreadForumRepositoryInterface;
use App\Models\Repositories\ThreadForumRepository;
use App\Models\Repositories\TagRepositoryInterface;
use App\Models\Repositories\TagRepository;
use App\Models\Repositories\DaftarBukuRepositoryInterface;
use App\Models\Repositories\DaftarBukuRepository;
use App\Models\Repositories\DaftarBukuOfflineRepositoryInterface;
use App\Models\Repositories\DaftarBukuOfflineRepository;
use App\Models\Repositories\ForumLikeRepositoryInterface;
use App\Models\Repositories\ForumLikeRepository;
use App\Models\Repositories\ForumPostRepositoryInterface;
use App\Models\Repositories\ForumPostRepository;
use App\Models\Repositories\MediaForumRepositoryInterface;
use App\Models\Repositories\MediaForumRepository;
use App\Models\Repositories\PelatihanRepositoryInterface;
use App\Models\Repositories\PelatihanRepository;
use App\Models\Repositories\PembayaranRepositoryInterface;
use App\Models\Repositories\PembayaranRepository;
use App\Models\Repositories\PendaftaranPelatihanRepositoryInterface;
use App\Models\Repositories\PendaftaranPelatihanRepository;
use App\Models\Repositories\ProfilGuruRepositoryInterface;
use App\Models\Repositories\ProfilGuruRepository;
use App\Models\Repositories\ProfilMentorRepositoryInterface;
use App\Models\Repositories\ProfilMentorRepository;
use App\Models\Repositories\SekolahRepositoryInterface;
use App\Models\Repositories\SekolahRepository;
use App\Models\Repositories\SpesialisasiUserRepositoryInterface;
use App\Models\Repositories\SpesialisasiUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ThreadForumRepositoryInterface::class, ThreadForumRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(DaftarBukuRepositoryInterface::class, DaftarBukuRepository::class);
        $this->app->bind(DaftarBukuOfflineRepositoryInterface::class, DaftarBukuOfflineRepository::class);
        $this->app->bind(ForumLikeRepositoryInterface::class, ForumLikeRepository::class);
        $this->app->bind(ForumPostRepositoryInterface::class, ForumPostRepository::class);
        $this->app->bind(MediaForumRepositoryInterface::class, MediaForumRepository::class);
        $this->app->bind(PelatihanRepositoryInterface::class, PelatihanRepository::class);
        $this->app->bind(PembayaranRepositoryInterface::class, PembayaranRepository::class);
        $this->app->bind(PendaftaranPelatihanRepositoryInterface::class, PendaftaranPelatihanRepository::class);
        $this->app->bind(ProfilGuruRepositoryInterface::class, ProfilGuruRepository::class);
        $this->app->bind(ProfilMentorRepositoryInterface::class, ProfilMentorRepository::class);
        $this->app->bind(SekolahRepositoryInterface::class, SekolahRepository::class);
        $this->app->bind(SpesialisasiUserRepositoryInterface::class, SpesialisasiUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
