<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\PesananPelatihanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForumController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Autentikasi
Route::post('/login-guru', [Authentication::class, 'loginGuru']);
Route::post('/login-mentor', [Authentication::class, 'loginMentor']);
Route::post('/register-guru', [Authentication::class, 'registerGuru']);
Route::post('/register-mentor', [Authentication::class, 'registerMentor']);

// Yg butuh middleware
Route::middleware(['auth:sanctum','throttle:60,1'])->group(function () {
    Route::post('/logout', [Authentication::class, 'logout']);
    // Auth websocket
    Route::post('/broadcasting/auth', function (Request $request) {return Broadcast::auth($request);});
    // Pesanan Pelatihan Routes
    Route::get('/pesanan-pelatihan', [PesananPelatihanController::class, 'index']);
    Route::post('/pesan-pelatihan', [PesananPelatihanController::class, 'store']);
    Route::get('/pesanan-pelatihan/{id}', [PesananPelatihanController::class, 'show']);
    Route::put('/pesanan-pelatihan/{id}/status', [PesananPelatihanController::class, 'updateStatus']);

    // Chat Routes
    Route::get('/conversations', [ChatController::class, 'getConversations']);
    Route::get('/conversations/{conversationId}/messages', [ChatController::class, 'getMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
    Route::put('/messages/{messageId}', [ChatController::class, 'editMessage']);
    Route::delete('/messages/{messageId}', [ChatController::class, 'deleteMessage']);

    // Forum discussion routes
    Route::get('/forum', [ForumController::class, 'index']);
    Route::post('/forum', [ForumController::class, 'store']);
    Route::get('/forum/{idThread}', [ForumController::class, 'show']);
    Route::put('/forum/{idThread}', [ForumController::class, 'updateThread']);
    Route::delete('/forum/{idThread}', [ForumController::class, 'deleteThread']);
    Route::post('/forum/{idThread}/comment', [ForumController::class, 'comment']);
    Route::get('/forum/search', [ForumController::class, 'search']);
    // Post update/delete post forum
    Route::put('/forum/post/{idPost}', [ForumController::class, 'updatePost']);
    Route::delete('/forum/post/{idPost}', [ForumController::class, 'deletePost']);
});
