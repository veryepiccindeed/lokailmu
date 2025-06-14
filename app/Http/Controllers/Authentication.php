<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\ProfilGuru;
use App\Models\ProfilMentor;
use App\Models\SpesialisasiUser; 
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Helpers\IdGenerator;

class Authentication extends Controller
{
    public function getProfileGuru(Request $request)
    {
        // Load related profilGuru and spesialisasiUsers
        $user = $request->user()->load(['profilGuru', 'spesialisasiUsers']);
        
        if (!$user->profilGuru) {
            return response()->json([
                'message' => 'Profil guru tidak ditemukan.'
            ], 404);
        }
        
        return response()->json([
            'user' => $user,
            'profil_guru' => $user->profilGuru,
            'spesialisasi' => $user->spesialisasiUsers
        ], 200);
    }
    
    public function getProfileMentor(Request $request)
    {
        // Load related profilMentor and spesialisasiUsers
        $user = $request->user()->load(['profilMentor', 'spesialisasiUsers']);
        
        if (!$user->profilMentor) {
            return response()->json([
                'message' => 'Profil mentor tidak ditemukan.'
            ], 404);
        }
        
        return response()->json([
            'user' => $user,
            'profil_mentor' => $user->profilMentor,
            'spesialisasi' => $user->spesialisasiUsers
        ], 200);
    }
    
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
                'pathKTP' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate KTP image
                'tgl_lahir' => 'required|date',
                'spesialisasi' => 'required|array|max:10',
                'spesialisasi.*' => 'string|max:45' // Added validation for array items
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

                // Handle KTP image upload
                $pathKTP = null;
                if ($request->hasFile('pathKTP')) {
                    $pathKTP = $request->file('pathKTP')->store('ktp_images', 'public');
                }
            
                $profilGuru = ProfilGuru::create([
                    'idUser' => $idUser,
                    'NPSN' => $request->NPSN,
                    'idSekolah' => $sekolah->idSekolah,
                    'NUPTK' => $request->NUPTK,
                    'tingkatPengajar' => $request->tingkatPengajar,
                    'pathKTP' => $pathKTP, // Save the uploaded KTP path
                ]);

                // Create spesialisasi entries
                foreach ($request->spesialisasi as $spesialisasi) {
                    SpesialisasiUser::create([
                        'idUser' => $idUser,
                        'spesialisasi' => $spesialisasi,
                    ]);
                }

                // Jika semua proses berhasil, commit transaction
                DB::commit();
            
                return response()->json([
                    'user' => $user,
                    'profil_guru' => $profilGuru,
                    'spesialisasi' => $request->spesialisasi
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
                'spesialisasi' => 'required|array|max:10', // Modified validation
                'spesialisasi.*' => 'string|max:45', // Added validation for array items
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
                    'pathCV' => $request->pathCV,
                    'pathSertifikat' => $request->pathSertifikat,
                ]);

                // Create spesialisasi entries
                foreach ($request->spesialisasi as $spesialisasi) {
                    SpesialisasiUser::create([
                        'idUser' => $idUser,
                        'spesialisasi' => $spesialisasi,
                    ]);
                }

                // Jika semua proses berhasil, commit transaction
                DB::commit();
            
                return response()->json([
                    'user' => $user,
                    'profil_mentor' => $profilMentor,
                    'spesialisasi' => $request->spesialisasi // Added spesialisasi to response
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

    public function editProfileGuru(Request $request)
    {
        try {
            // Check if the user role is guru (has a guru profile)
            if (!$request->user()->profilGuru) {
                return response()->json([
                    'message' => 'Akses ditolak. Hanya guru yang dapat mengakses API ini'
                ], 403);
            }

            $request->validate([
                'nama_lengkap' => 'nullable|string',
                'email' => 'nullable|email|unique:users,email,' . $request->user()->idUser . ',idUser',
                'no_hp' => 'nullable|unique:users,noHP,' . $request->user()->idUser . ',idUser',
                'password' => 'nullable|min:6',
                'NPSN' => 'nullable|exists:sekolahs,NPSN',
                'NUPTK' => 'nullable|unique:profilgurus,NUPTK,' . $request->user()->idUser . ',idUser',
                'tingkatPengajar' => 'nullable|string',
                'tgl_lahir' => 'nullable|date',
                'spesialisasi' => 'nullable|array|max:10',
                'spesialisasi.*' => 'string|max:45'
            ]);

            DB::transaction(function () use ($request) {
                $user = $request->user();

                // Update user data
                if ($request->filled('nama_lengkap')) {
                    $user->namaLengkap = $request->nama_lengkap;
                }
                if ($request->filled('email')) {
                    $user->email = $request->email;
                }
                if ($request->filled('no_hp')) {
                    $user->noHP = $request->no_hp;
                }
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                if ($request->filled('tgl_lahir')) {
                    $user->tglLahir = $request->tgl_lahir;
                }
                $user->save();

                // Update profil guru
                $profilGuru = $user->profilGuru;
                if ($request->filled('NPSN')) {
                    $sekolah = Sekolah::where('NPSN', $request->NPSN)->first();
                    $profilGuru->NPSN = $request->NPSN;
                }
                if ($request->filled('NUPTK')) {
                    $profilGuru->NUPTK = $request->NUPTK;
                }
                if ($request->filled('tingkatPengajar')) {
                    $profilGuru->tingkatPengajar = $request->tingkatPengajar;
                }
                $profilGuru->save();

                // Update spesialisasi
                if ($request->filled('spesialisasi')) {
                    SpesialisasiUser::where('idUser', $user->idUser)->delete();
                    foreach ($request->spesialisasi as $spesialisasi) {
                        SpesialisasiUser::create([
                            'idUser' => $user->idUser,
                            'spesialisasi' => $spesialisasi,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'Profil berhasil diperbarui'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editProfileMentor(Request $request)
    {
        try {
            // Check if the user role is mentor (has a mentor profile)
            if (!$request->user()->profilMentor) {
                return response()->json([
                    'message' => 'Akses ditolak. Hanya mentor yang dapat mengakses API ini'
                ], 403);
            }

            $request->validate([
                'nama_lengkap'    => 'nullable|string',
                'email'           => 'nullable|email|unique:users,email,' . $request->user()->idUser . ',idUser',
                'no_hp'           => 'nullable|unique:users,noHP,' . $request->user()->idUser . ',idUser',
                'password'        => 'nullable|min:6',
                'tgl_lahir'       => 'nullable|date',
                'pathCV'          => 'nullable|mimes:pdf|max:2048', 
                'pathSertifikat'  => 'nullable',
                'spesialisasi'    => 'nullable|array|max:10',
                'spesialisasi.*'  => 'string|max:45'
            ]);

            DB::transaction(function () use ($request) {
                $user = $request->user();
                
                // Update user data
                if ($request->filled('nama_lengkap')) {
                    $user->namaLengkap = $request->nama_lengkap;
                }
                if ($request->filled('email')) {
                    $user->email = $request->email;
                }
                if ($request->filled('no_hp')) {
                    $user->noHP = $request->no_hp;
                }
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                if ($request->filled('tgl_lahir')) {
                    $user->tglLahir = $request->tgl_lahir;
                }
                $user->save();

                // Update profil mentor
                $profilMentor = $user->profilMentor;
                if ($request->hasFile('pathCV')) {
                    $pathCV = $request->file('pathCV')->store('cv_files', 'public');
                    $profilMentor->pathCV = $pathCV;
                } elseif ($request->filled('pathCV')) {
                    $profilMentor->pathCV = $request->pathCV;
                }
                if ($request->hasFile('pathSertifikat')) {
                    $pathSertifikat = $request->file('pathSertifikat')->store('sertifikat_files', 'public');
                    $profilMentor->pathSertifikat = $pathSertifikat;
                } elseif ($request->filled('pathSertifikat')) {
                    $profilMentor->pathSertifikat = $request->pathSertifikat;
                }
                $profilMentor->save();

                // Update spesialisasi
                if ($request->filled('spesialisasi')) {
                    SpesialisasiUser::where('idUser', $user->idUser)->delete();
                    foreach ($request->spesialisasi as $spesialisasi) {
                        SpesialisasiUser::create([
                            'idUser'      => $user->idUser,
                            'spesialisasi'=> $spesialisasi,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'Profil mentor berhasil diperbarui'], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui profil mentor',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
