<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\PendaftaranPelatihan;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('pesanan-pelatihan.{idPelatihan}', function ($user, $idPelatihan) {
    // Guru yang mendaftar atau mentor pelatihan boleh subscribe
    $order = PendaftaranPelatihan::find($idPelatihan);
    if (!$order) return false;
    // Guru
    if ($user->idUser === $order->idUser) return true;
    // Mentor
    if ($order->pelatihan && $order->pelatihan->idMentor === $user->idUser) return true;
    return false;
});
