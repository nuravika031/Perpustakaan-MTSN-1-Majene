<?php

namespace App\Http\Controllers;

use App\Models\DdcClass;
use Illuminate\Http\Request;

class DdcClassController extends Controller
{
    /**
     * Menampilkan daftar semua kelas DDC.
     */
    public function index()
    {
        // Mengambil data DDC dan mengurutkannya berdasarkan kode angka (000 - 900)
        $ddcClasses = DdcClass::orderBy('code', 'asc')->get();
        return view('pustakawan.ddc.index', compact('ddcClasses'));
    }

    /**
     * Menampilkan form edit DDC.
     */
    public function edit($id)
    {
        $ddcClass = DdcClass::findOrFail($id);
        return view('pustakawan.ddc.edit', compact('ddcClass'));
    }

    /**
     * Menyimpan perubahan nama dan deskripsi DDC.
     */
    public function update(Request $request, $id)
    {
        $ddcClass = DdcClass::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $ddcClass->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('ddc.index')->with('success', 'Master DDC berhasil diperbarui!');
    }
}