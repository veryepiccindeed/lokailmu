<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\PesananPelatihanUpdated;

class PelatihanController extends Controller
{
    // List all orders for authenticated user (as Guru or Mentor)
    public function index(Request $request)
    {
        $user = $request->user();
        $query = PendaftaranPelatihan::query();
        if ($user->profilGuru) {
            $query->where('idUser', $user->idUser);
        } elseif ($user->profilMentor) {
            $query->whereHas('pelatihan', function($q) use ($user) {
                $q->where('idMentor', $user->idUser);
            });
        }
        $orders = $query->with(['pelatihan', 'user'])->get();
        return response()->json($orders);
    }

    // Create new order (Guru mendaftar pelatihan)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idPelatihan' => 'required|exists:pelatihans,idPelatihan',
            'tglMulai' => 'required|date|after:today',
            'tglSelesai' => 'required|date|after:tglMulai',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Validasi role
        if (!$request->user()->profilGuru) {
            return response()->json(['error' => 'Only teachers can register for training'], 403);
        }
    
        $order = PendaftaranPelatihan::create([
            'idPelatihan' => $request->idPelatihan,
            'idUser' => $request->user()->idUser,
            'tglMulai' => $request->tglMulai,
            'tglSelesai' => $request->tglSelesai,
            'status' => 'pending'
        ]);
    
        broadcast(new PesananPelatihanUpdated($order))->toOthers();
        return response()->json($order, 201);
    }

    // Update status (ongoing/done) - asumsikan ada kolom 'status' di tabel pendaftaranpelatihans
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,ongoing,done,cancelled',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $order = PendaftaranPelatihan::findOrFail($id);
        
        // Validasi: hanya mentor yang bisa update status
        if (!$request->user()->profilMentor || 
            $order->pelatihan->idMentor !== $request->user()->idUser) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();
        
        broadcast(new PesananPelatihanUpdated($order))->toOthers();
        
        return response()->json($order);
    }

    // Show detail order
    public function show($id)
    {
        $user = request()->user();
        $order = PendaftaranPelatihan::with(['pelatihan', 'user'])->findOrFail($id);
        
        // Validasi: hanya guru yang membuat pesanan atau mentor yang terkait yang bisa lihat
        if ($user->idUser !== $order->idUser && 
            (!$order->pelatihan || $order->pelatihan->idMentor !== $user->idUser)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json($order);
    }
} 