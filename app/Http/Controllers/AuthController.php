<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\MahasiswaProfile;
use App\Models\DosenProfile;

// JANGAN OTAK ATIK BAGIAN INI, SOALNYA MAISH SENSITIVE CASE
//SILAHKAN LAKUKAN PENYESUIAN PADA BAGIAN CONTROLLERT LAINNYA SESUAI KEBUTUHAN
//APAPAUN ERRORNYA JANGAN OTAK ATIK BAGIAN INI
//TERIMA KASIH

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,dosen,mahasiswa',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            // mahasiswa
            'npm' => 'nullable|string',
            'program_studi' => 'nullable|string',
            'semester' => 'nullable|string',
            // umum
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            // dosen
            'nidn' => 'nullable|string',
            'program_studi' => 'nullable|string',
            'departemen' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'mahasiswa') {
            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'npm' => $request->npm,
                'program_studi' => $request->program_studi,
                'semester' => $request->semester,
                'usia' => $request->usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        if ($request->role === 'dosen') {
            DosenProfile::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nidn' => $request->nidn,
                'program_studi' => $request->program_studi,
                'departemen' => $request->departemen,
                'usia' => $request->usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        return response()->json([
            'message' => 'Registrasi berhasil',
            'role' => $user->role
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['message' => 'Login successful', 'role' => auth()->user()->role, 'token' => $token]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); 
            return response()->json(['message' => 'Logout berhasil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal logout, token mungkin tidak valid'], 400);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::where('role', 'admin')->get();
        return response()->json($admin);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
