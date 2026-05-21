<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentClassController extends Controller
{
    public function index()
    {
        $classes = StudentClass::orderBy('level')
            ->orderBy('class_name')
            ->get();

        return view('pustakawan.classes.index', compact('classes'));
    }

    public function create()
    {
        return redirect()->route('classes.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classes' => ['required', 'array', 'min:1', 'max:20'],
            'classes.*.class_name' => ['required', 'string', 'max:100'],
            'classes.*.level' => ['required', Rule::in(['7', '8', '9'])],
            'classes.*.academic_year' => ['required', 'string', 'max:20'],
        ], $this->validationMessages(), $this->validationAttributes());

        $rows = collect($validated['classes'])
            ->map(function ($row) {
                return [
                    'class_name' => trim($row['class_name']),
                    'level' => trim($row['level']),
                    'academic_year' => trim($row['academic_year']),
                ];
            })
            ->values();

        $seen = [];

        foreach ($rows as $index => $row) {
            $key = strtolower($row['class_name'] . '|' . $row['academic_year']);

            if (in_array($key, $seen)) {
                throw ValidationException::withMessages([
                    "classes.$index.class_name" => 'Baris ke-' . ($index + 1) . ' memiliki data kelas yang sama dengan baris sebelumnya.',
                ]);
            }

            $seen[] = $key;

            $exists = StudentClass::where('class_name', $row['class_name'])
                ->where('academic_year', $row['academic_year'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    "classes.$index.class_name" => 'Kelas "' . $row['class_name'] . '" untuk tahun ajaran ' . $row['academic_year'] . ' sudah tersedia.',
                ]);
            }
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                StudentClass::create($row);
            }
        });

        return redirect()
            ->route('classes.index')
            ->with('success_title', 'Kelas berhasil ditambahkan')
            ->with('success_message', $rows->count() . ' data kelas berhasil ditambahkan ke sistem.')
            ->with('success_detail', 'Data kelas sudah dapat digunakan pada form anggota siswa.');
    }

    public function edit(StudentClass $class)
    {
        return view('pustakawan.classes.edit', compact('class'));
    }

    public function update(Request $request, StudentClass $class)
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:100'],
            'level' => ['required', Rule::in(['7', '8', '9'])],
            'academic_year' => ['required', 'string', 'max:20'],
        ], $this->validationMessages(), $this->validationAttributes());

        $exists = StudentClass::where('class_name', $validated['class_name'])
            ->where('academic_year', $validated['academic_year'])
            ->where('id', '!=', $class->id)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'class_name' => 'Kelas "' . $validated['class_name'] . '" untuk tahun ajaran ' . $validated['academic_year'] . ' sudah tersedia.',
            ]);
        }

        $class->update($validated);

        return redirect()
            ->route('classes.index')
            ->with('success_title', 'Kelas berhasil diperbarui')
            ->with('success_message', 'Data kelas "' . $class->class_name . '" berhasil diperbarui.')
            ->with('success_detail', 'Perubahan data kelas sudah tersimpan di sistem.');
    }

    public function destroy(StudentClass $class)
    {
        if ($class->members()->count() > 0) {
            return redirect()
                ->route('classes.index')
                ->with('error_title', 'Kelas tidak bisa dihapus')
                ->with('error_message', 'Kelas "' . $class->class_name . '" masih digunakan oleh data anggota.')
                ->with('error_detail', 'Pindahkan atau ubah data anggota terlebih dahulu sebelum menghapus kelas ini.');
        }

        $className = $class->class_name;

        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('success_title', 'Kelas berhasil dihapus')
            ->with('success_message', 'Data kelas "' . $className . '" berhasil dihapus dari sistem.')
            ->with('success_detail', 'Kelas tersebut tidak akan tampil lagi pada daftar kelas.');
    }

    private function validationMessages(): array
    {
        return [
            'classes.required' => 'Minimal satu data kelas wajib diisi.',
            'classes.array' => 'Format data kelas tidak valid.',
            'classes.min' => 'Minimal satu data kelas wajib diisi.',
            'classes.max' => 'Maksimal hanya boleh menambahkan 20 kelas dalam satu kali simpan.',

            'classes.*.class_name.required' => 'Nama kelas wajib diisi.',
            'classes.*.class_name.max' => 'Nama kelas tidak boleh lebih dari 100 karakter.',
            'classes.*.level.required' => 'Tingkat kelas wajib dipilih.',
            'classes.*.level.in' => 'Tingkat kelas harus dipilih antara kelas 7, 8, atau 9.',
            'classes.*.academic_year.required' => 'Tahun ajaran wajib diisi.',
            'classes.*.academic_year.max' => 'Tahun ajaran tidak boleh lebih dari 20 karakter.',

            'class_name.required' => 'Nama kelas wajib diisi.',
            'class_name.max' => 'Nama kelas tidak boleh lebih dari 100 karakter.',
            'level.required' => 'Tingkat kelas wajib dipilih.',
            'level.in' => 'Tingkat kelas harus dipilih antara kelas 7, 8, atau 9.',
            'academic_year.required' => 'Tahun ajaran wajib diisi.',
            'academic_year.max' => 'Tahun ajaran tidak boleh lebih dari 20 karakter.',
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'class_name' => 'Nama kelas',
            'level' => 'Tingkat kelas',
            'academic_year' => 'Tahun ajaran',
            'classes.*.class_name' => 'Nama kelas',
            'classes.*.level' => 'Tingkat kelas',
            'classes.*.academic_year' => 'Tahun ajaran',
        ];
    }
}