<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentClassController extends Controller
{
    public function index()
    {
        $classes = StudentClass::orderBy('level', 'asc')->get();
        return view('pustakawan.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('pustakawan.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Tambahkan unique untuk mencegah duplikat nama kelas
            'class_name' => 'required|string|max:50|unique:classes,class_name', 
            'level' => 'required|in:7,8,9',
            'academic_year' => 'required|string|max:20',
        ], [
            // Pesan error kustom jika duplikat
            'class_name.unique' => 'Gagal! Nama kelas ini sudah terdaftar di sistem.'
        ]);

        StudentClass::create($validated);
        return redirect()->route('members.create')->with('success', 'Kelas baru berhasil ditambahkan! Silakan lanjut mengisi data anggota.');
    }

    // --- FITUR BARU: Menampilkan form edit ---
    public function edit($id)
    {
        $class = StudentClass::findOrFail($id);
        return view('pustakawan.classes.edit', compact('class'));
    }

    // --- FITUR BARU: Menyimpan perubahan data kelas ---
    public function update(Request $request, $id)
    {
        $class = StudentClass::findOrFail($id);

        $validated = $request->validate([
            // Pengecekan unique, tapi kecualikan ID kelas yang sedang diedit ini
            'class_name' => [
                'required', 'string', 'max:50',
                Rule::unique('classes', 'class_name')->ignore($class->id)
            ],
            'level' => 'required|in:7,8,9',
            'academic_year' => 'required|string|max:20',
        ], [
            'class_name.unique' => 'Nama kelas sudah dipakai oleh kelas lain.'
        ]);

        $class->update($validated);
        return redirect()->route('classes.index')->with('success', 'Perubahan data kelas berhasil disimpan!');
    }

    public function destroy($id)
    {
        $class = StudentClass::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus dari sistem!');
    }
}