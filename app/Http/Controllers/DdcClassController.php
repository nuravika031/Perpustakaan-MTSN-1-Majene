<?php

namespace App\Http\Controllers;

use App\Models\DdcClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DdcClassController extends Controller
{
    /**
     * Menampilkan daftar semua kelas DDC.
     */
    public function index()
    {
        $ddcClasses = DdcClass::orderBy('code', 'asc')->get();

        return view('pustakawan.ddc.index', compact('ddcClasses'));
    }

    /**
     * Menampilkan form edit DDC.
     */
    public function edit($id)
    {
        $ddcClass = DdcClass::withCount('books')->findOrFail($id);

        $isCodeEditable = $ddcClass->books_count === 0;

        return view('pustakawan.ddc.edit', compact('ddcClass', 'isCodeEditable'));
    }

    /**
     * Menyimpan perubahan DDC.
     *
     * Kode DDC hanya boleh diedit jika belum ada buku yang memakai DDC tersebut.
     */
    public function update(Request $request, $id)
    {
        $ddcClass = DdcClass::withCount('books')->findOrFail($id);

        $isCodeEditable = $ddcClass->books_count === 0;

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ];

        if ($isCodeEditable) {
            $rules['code'] = [
                'required',
                'string',
                'max:20',
                Rule::unique('ddc_classes', 'code')->ignore($ddcClass->id),
            ];
        }

        $validated = $request->validate($rules);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ];

        if ($isCodeEditable) {
            $updateData['code'] = $validated['code'];
        }

        $ddcClass->update($updateData);

        return redirect()
            ->route('ddc.index')
            ->with('success', 'Master DDC berhasil diperbarui.');
    }
}