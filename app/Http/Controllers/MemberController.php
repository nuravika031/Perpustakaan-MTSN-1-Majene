<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar semua anggota perpustakaan.
     */
    public function index()
    {
        $members = Member::with('studentClass')->latest()->get();
        return view('pustakawan.members.index', compact('members'));
    }

    /**
     * Menampilkan form untuk menambah anggota baru.
     */
    public function create()
    {
        // Mengurutkan kelas berdasarkan tingkat (level) agar rapi
        $classes = StudentClass::orderBy('level', 'asc')->get();
        return view('pustakawan.members.create', compact('classes'));
    }

    /**
     * Menyimpan data anggota baru ke dalam database (Mendukung Form Biasa & AJAX Quick Add).
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nis_nip' => 'required|string|max:50|unique:members,nis_nip',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'member_type' => 'required|in:siswa,guru',
            'gender' => 'required|in:laki-laki,perempuan',
            // Jika tipe anggota = siswa, wajib diisi dan harus ada di tabel classes
            'student_class_id' => 'required_if:member_type,siswa|nullable|exists:classes,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            // 2. Logika Auto-Generate Kode Anggota
            $lastMember = Member::orderBy('id', 'desc')->first();

            if (!$lastMember) {
                $newCode = 'ANG-001';
            } else {
                $lastCode = $lastMember->member_code;
                $lastNumber = (int) substr($lastCode, 4); 
                $newNumber = $lastNumber + 1; 
                $newCode = 'ANG-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT); 
            }

            // Sisipkan kode otomatis
            $validated['member_code'] = $newCode;

            // 3. Simpan ke database
            $member = Member::create($validated);

            // 4. PENANGANAN AJAX (Untuk fitur Daftar Kilat di Kasir Peminjaman)
            if ($request->wantsJson() || $request->ajax()) {
                
                // Ambil label nama kelas untuk dikembalikan ke dropdown kasir
                $className = 'Guru/Staff';
                if ($member->member_type === 'siswa' && $member->student_class_id) {
                    $studentClass = StudentClass::find($member->student_class_id);
                    $className = $studentClass ? $studentClass->class_name : 'Siswa';
                }

                // Kirim balik data berformat JSON (Status 201 = Created)
                return response()->json([
                    'success' => true,
                    'message' => 'Anggota berhasil didaftarkan secara kilat.',
                    'member' => $member,
                    'class_name' => $className
                ], 201);
            }

            // 5. PENANGANAN NORMAL (Form Biasa)
            return redirect()->route('members.index')->with('success', 'Berhasil! Anggota baru terdaftar dengan ID: ' . $newCode);

        } catch (\Exception $e) {
            
            // Jika gagal tingkat database (Penanganan AJAX)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan ke database.',
                    'error' => $e->getMessage() // Opsional: Untuk melihat detail error di console
                ], 500);
            }

            // Jika gagal tingkat database (Penanganan Form Biasa)
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan anggota sistem.']);
        }
    }

    /**
     * Menampilkan detail satu anggota.
     */
    public function show(Member $member)
    {
        return view('pustakawan.members.show', compact('member'));
    }

    /**
     * Menampilkan form untuk mengedit data anggota.
     */
    public function edit(Member $member)
    {
        $classes = StudentClass::orderBy('level', 'asc')->get();
        return view('pustakawan.members.edit', compact('member', 'classes'));
    }

    /**
     * Memperbarui data anggota di database.
     */
    public function update(Request $request, Member $member)
    {
        // Pengecualian unique untuk data yang sedang diedit
        $validatedData = $request->validate([
            'nis_nip' => 'required|unique:members,nis_nip,' . $member->id,
            'name' => 'required|string|max:255',
            'member_type' => 'required|in:siswa,guru',
            'gender' => 'required|in:laki-laki,perempuan',
            'student_class_id' => 'required_if:member_type,siswa|nullable|exists:classes,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $member->update($validatedData);

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Menghapus data anggota.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}