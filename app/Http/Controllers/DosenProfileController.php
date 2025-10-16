<?php

namespace App\Http\Controllers;

use App\Models\DosenProfile;
use Illuminate\Http\Request;

class DosenProfileController extends Controller
{
    public function index()
    {
        return response()->json(DosenProfile::with('user')->get());
    }

    public function show($id)
    {
        $dosen = DosenProfile::with('user')->findOrFail($id);
        return response()->json($dosen);
    }

    public function update(Request $request, $id)
    {
        $dosen = DosenProfile::with('user')->findOrFail($id);
        $user = $dosen->user;

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'nidn' => 'sometimes|string|unique:dosen_profiles,nidn,' . $dosen->id,
            'program_studi' => 'sometimes|string|max:255',
            'departemen' => 'nullable|string',
            'usia' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        if ($request->has('name')) {
            $user->update(['name' => $request->name]);
        }

        $dosen->update($request->only(['nip', 'jabatan', 'no_hp', 'alamat']));

        return response()->json([
            'message' => 'Data dosen diperbarui',
        ]);
    }

    public function destroy($id)
    {
        $dosen = DosenProfile::findOrFail($id);
        $dosen->delete();

        return response()->json(['message' => 'Profil dosen dihapus']);
    }
}
