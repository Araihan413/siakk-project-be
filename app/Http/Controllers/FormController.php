<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    // List semua form
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $forms = Form::with('sections.fields')->get();
        return response()->json($forms);
    }

    // Tampilkan detail form
    public function show($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $form = Form::with('sections.fields')->findOrFail($id);
        return response()->json($form);
    }

    // Buat form baru
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $form = Form::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Form created successfully',
            'data' => $form
        ]);
    }

    // Update form
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $form = Form::findOrFail($id);

        $form->update($request->only('name', 'description', 'status', 'version'));

        return response()->json([
            'message' => 'Form updated successfully',
            'data' => $form
        ]);
    }

    // Hapus form
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $form = Form::findOrFail($id);
        $form->delete();

        return response()->json(['message' => 'Form deleted successfully']);
    }
}
