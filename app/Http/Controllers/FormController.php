<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    // Hanya admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return $next($request);
        });
    }

    // List semua form
    public function index()
    {
        $forms = Form::with('sections.fields')->get();
        return response()->json($forms);
    }

    // Buat form baru
    public function store(Request $request)
    {
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

        return response()->json(['message' => 'Form created successfully', 'data' => $form]);
    }

    // Tampilkan detail form
    public function show($id)
    {
        $form = Form::with('sections.fields')->findOrFail($id);
        return response()->json($form);
    }

    // Update form
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $form->update($request->only('name', 'description', 'status', 'version'));

        return response()->json(['message' => 'Form updated successfully', 'data' => $form]);
    }

    // Hapus form
    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();

        return response()->json(['message' => 'Form deleted successfully']);
    }
}
