<?php

return [

    'required' => ':attribute wajib diisi.',
    'required_if' => ':attribute wajib diisi jika :other adalah :value.',
    'string' => ':attribute harus berupa teks.',
    'integer' => ':attribute harus berupa angka.',
    'numeric' => ':attribute harus berupa angka.',
    'email' => ':attribute harus menggunakan format email yang benar.',
    'unique' => ':attribute sudah digunakan. Silakan gunakan data lain.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'in' => ':attribute yang dipilih tidak valid.',
    'image' => ':attribute harus berupa gambar.',
    'mimes' => ':attribute harus berformat: :values.',
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
        'file' => ':attribute maksimal :max KB.',
        'numeric' => ':attribute maksimal :max.',
    ],
    'min' => [
        'string' => ':attribute minimal :min karakter.',
        'file' => ':attribute minimal :min KB.',
        'numeric' => ':attribute minimal :min.',
    ],

    'attributes' => [
        'member_code' => 'Kode anggota',
        'nis_nip' => 'NIS / NIP',
        'name' => 'Nama lengkap',
        'member_type' => 'Jenis anggota',
        'gender' => 'Jenis kelamin',
        'student_class_id' => 'Kelas',
        'phone' => 'Nomor HP / WhatsApp',
        'status' => 'Status',
        'card_image' => 'Kartu anggota',

        'title' => 'Judul buku',
        'author' => 'Penulis',
        'publisher' => 'Penerbit',
        'publication_year' => 'Tahun terbit',
        'price' => 'Harga buku',
        'category_id' => 'Kategori',
        'ddc_class_id' => 'Kelas DDC',
        'is_borrowable' => 'Status peminjaman',
        'description' => 'Deskripsi',

        'book_id' => 'Buku induk',
        'item_code' => 'Kode eksemplar',
        'condition' => 'Kondisi buku',

        'code' => 'Kode',
        'username' => 'Username',
        'email' => 'Email',
        'password' => 'Password',
    ],

];