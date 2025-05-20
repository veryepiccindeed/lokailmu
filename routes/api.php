<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\PesananPelatihanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Autentikasi
Route::post('/login-guru', [Authentication::class, 'loginGuru']);
Route::post('/login-mentor', [Authentication::class, 'loginMentor']);
Route::post('/register-guru', [Authentication::class, 'registerGuru']);
Route::post('/register-mentor', [Authentication::class, 'registerMentor']);

// Yg butuh middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [Authentication::class, 'logout']);
    Route::post('/broadcasting/auth', function (Request $request) {return Broadcast::auth($request);});
    Route::get('/pesanan-pelatihan', [PesananPelatihanController::class, 'index']);
    Route::post('/pesan-pelatihan', [PesananPelatihanController::class, 'store']);
    Route::get('/pesanan-pelatihan/{id}', [PesananPelatihanController::class, 'show']);
    Route::patch('/pesanan-pelatihan/{id}/status', [PesananPelatihanController::class, 'updateStatus']);
});
