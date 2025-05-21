<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\PendaftaranPelatihan;
use App\Models\Pelatihan;

    // Channel untuk pesanan pelatihan
    Broadcast::channel('pesanan-pelatihan.{idPelatihan}', function ($user, $idPelatihan) {
    
        // Cek apakah pelatihan ada
        $pelatihan = Pelatihan::where('idPelatihan', $idPelatihan)->first();
        if (!$pelatihan) return false;

        // Mentor yang terkait dengan pelatihan
        if ($pelatihan->idMentor === $user->idUser) return true;
        
        // Guru yang mendaftar pelatihan ini
        $order = PendaftaranPelatihan::where('idPelatihan', $idPelatihan)
            ->where('idUser', $user->idUser)
            ->first();
        if ($order) return true;
        
        return false;
    });

    // Channel untuk mentor
    Broadcast::channel('mentor.{idMentor}', function ($user, $idMentor) {
        return $user->idUser === $idMentor && $user->profilMentor;
    });

    // Channel untuk user
    Broadcast::channel('user.{idUser}', function ($user, $idUser) {
        return $user->idUser === $idUser;
    });