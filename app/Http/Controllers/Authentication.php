<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\ProfilGuru;
use App\Models\ProfilMentor;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Helpers\IdGenerator;

class Authentication extends Controller
{
    public function loginGuru(Request $request)
    {
        try {
            $request->validate([
                'email_or_hp' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email_or_hp)
                ->orWhere('noHP', $request->email_or_hp)
                ->first();

            if (!$user || !$user->profilGuru) {
                return response()->json([
                    'message' => 'Akun guru tidak ditemukan.'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Password salah.'
                ], 401);
            }

            // Hapus token lama jika ada
            $user->tokens()->delete();

            // Buat token baru
            $token = $user->createToken('guru-token', ['guru'])->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'profil_guru' => $user->profilGuru,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function loginMentor(Request $request)
    {
        try {
            $request->validate([
                'email_or_hp' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email_or_hp)
                ->orWhere('noHP', $request->email_or_hp)
                ->first();

            if (!$user || !$user->profilMentor) {
                return response()->json([
                    'message' => 'Akun mentor tidak ditemukan.'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Password salah.'
                ], 401);
            }

            // Hapus token lama jika ada
            $user->tokens()->delete();

            // Buat token baru
            $token = $user->createToken('mentor-token', ['mentor'])->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'profil_mentor' => $user->profilMentor,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function registerGuru(Request $request)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'required|unique:users,noHP',
                'password' => 'required|min:6',
                'NPSN' => 'required|exists:sekolahs,NPSN',
                'NUPTK' => 'required|unique:profilgurus,NUPTK',
                'tingkatPengajar' => 'required',
                'pathKTP' => 'nullable',
                'tgl_lahir' => 'required|date'
            ]);

            // Mencari sekolah berdasarkan inputan NPSN
            $sekolah = Sekolah::where('NPSN', $request->NPSN)->first();
            
            if (!$sekolah) {
                return response()->json([
                    'message' => 'Tidak ada sekolah sesuai dengan NPSN yang dimasukkan'
                ], 422);
            }

            // Mulai database transaction
            DB::beginTransaction();
            
            try {
                // Generate ID User
                $idUser = IdGenerator::generateUserId();
            
                $user = User::create([
                    'idUser' => $idUser,
                    'namaLengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'noHP' => $request->no_hp,
                    'password' => Hash::make($request->password),
                    'tglLahir' => $request->tgl_lahir,
                ]);
            
                $profilGuru = ProfilGuru::create([
                    'idUser' => $idUser,
                    'NPSN' => $request->NPSN,
                    'idSekolah' => $sekolah->idSekolah,
                    'NUPTK' => $request->NUPTK,
                    'tingkatPengajar' => $request->tingkatPengajar,
                    'pathKTP' => $request->pathKTP,
                ]);

                // Jika semua proses berhasil, commit transaction
                DB::commit();
            
                return response()->json([
                    'user' => $user,
                    'profil_guru' => $profilGuru,
                ], 201);

            } catch (\Exception $e) {
                // Jika terjadi error, rollback semua perubahan
                DB::rollBack();
                
                return response()->json([
                    'message' => 'Terjadi kesalahan saat registrasi',
                    'error' => $e->getMessage()
                ], 500);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat registrasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function registerMentor(Request $request)
    {
        try {
            $request->validate([
                'nama_lengkap' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'required|unique:users,noHP',
                'password' => 'required|min:6',
                'spesialisasi' => 'required',
                'pathCV' => 'nullable',
                'pathSertifikat' => 'nullable',
                'tgl_lahir' => 'required|date'
            ]);
        
            // Mulai database transaction
            DB::beginTransaction();
            
            try {
                // Generate ID User
                $idUser = IdGenerator::generateUserId();
            
                $user = User::create([
                    'idUser' => $idUser,
                    'namaLengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'noHP' => $request->no_hp,
                    'password' => Hash::make($request->password),
                    'tglLahir' => $request->tgl_lahir,
                ]);
            
                $profilMentor = ProfilMentor::create([
                    'idUser' => $idUser,
                    'spesialisasi' => $request->spesialisasi,
                    'pathCV' => $request->pathCV,
                    'pathSertifikat' => $request->pathSertifikat,
                ]);

                // Jika semua proses berhasil, commit transaction
                DB::commit();
            
                return response()->json([
                    'user' => $user,
                    'profil_mentor' => $profilMentor,
                ], 201);

            } catch (\Exception $e) {
                // Jika terjadi error, rollback semua perubahan
                DB::rollBack();
                
                return response()->json([
                    'message' => 'Terjadi kesalahan saat registrasi mentor',
                    'error' => $e->getMessage()
                ], 500);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat registrasi mentor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
