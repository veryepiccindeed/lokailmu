<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilGuru;
use App\Models\ProfilMentor;
use Illuminate\Validation\ValidationException;

class Authentication extends Controller
{
    public function loginGuru(Request $request)
    {
        $request->validate([
            'email_or_hp' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email_or_hp)
            ->orWhere('no_hp', $request->email_or_hp)
            ->first();

        if (!$user || !$user->profilGuru) {
            throw ValidationException::withMessages([
                'email_or_hp' => ['Akun guru tidak ditemukan.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password salah.'],
            ]);
        }

        $token = $user->createToken('guru-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'profil_guru' => $user->profilGuru,
            'token' => $token,
        ]);
    }

    public function loginMentor(Request $request)
    {
        $request->validate([
            'email_or_hp' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email_or_hp)
            ->orWhere('no_hp', $request->email_or_hp)
            ->first();

        if (!$user || !$user->profilMentor) {
            throw ValidationException::withMessages([
                'email_or_hp' => ['Akun mentor tidak ditemukan.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password salah.'],
            ]);
        }

        $token = $user->createToken('mentor-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'profil_mentor' => $user->profilMentor,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function registerGuru(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|unique:users,no_hp',
            'password' => 'required|min:6',
            'NPSN' => 'required',
            'NUPTK' => 'required',
            'idSekolah' => 'required',
            'tingkatPengajar' => 'required',
            'pathKTP' => 'required',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        $profilGuru = ProfilGuru::create([
            'idUser' => $user->idUser,
            'NPSN' => $request->NPSN,
            'NUPTK' => $request->NUPTK,
            'idSekolah' => $request->idSekolah,
            'tingkatPengajar' => $request->tingkatPengajar,
            'pathKTP' => $request->pathKTP,
        ]);

        return response()->json([
            'user' => $user,
            'profil_guru' => $profilGuru,
        ], 201);
    }

    public function registerMentor(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|unique:users,no_hp',
            'password' => 'required|min:6',
            'spesialisasi' => 'required',
            'pathCV' => 'required',
            'pathSertifikat' => 'required',
            'pathKTP' => 'required',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        $profilMentor = ProfilMentor::create([
            'idUser' => $user->idUser,
            'pathCV' => $request->pathCV,
            'pathSertifikat' => $request->pathSertifikat,
        ]);

        // Simpan spesialisasi ke tabel relasi jika ada (opsional, tergantung model)
        // $user->spesialisasiUsers()->create(['spesialisasi' => $request->spesialisasi]);

        return response()->json([
            'user' => $user,
            'profil_mentor' => $profilMentor,
        ], 201);
    }
}
