<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaProfileController extends Controller
{
    public function index()
    {
        $mahasiswa = MahasiswaProfile::with('user')->get();
        return response()->json($mahasiswa);
    }

    public function show($id)
    {
        $mahasiswa = MahasiswaProfile::with('user')->findOrFail($id);
        return response()->json($mahasiswa);
    }

    public function update(Request $request, $id)
    {
        $profile = MahasiswaProfile::with('user')->findOrFail($id);
        $user = $profile->user;

        $request->validate([
            'name' => 'required|string|max:255', 
            'npm' => 'required|string|unique:mahasiswa_profiles,npm,' . $id,
            'program_studi' => 'required|string',
            'semester' => 'nullable|string',
            'usia' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $profile->update([
            'npm' => $request->npm,
            'program_studi' => $request->program_studi,
            'semester' => $request->semester,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json(['message' => 'Mahasiswa berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $profile = MahasiswaProfile::findOrFail($id);
        $profile->user()->delete(); 

        return response()->json(['message' => 'Mahasiswa berhasil dihapus']);
    }
}
