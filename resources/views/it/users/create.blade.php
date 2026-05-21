<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Buat Akun Staf Baru</h2>
                <p class="mt-1 text-sm text-gray-500">Daftarkan email dan kata sandi agar staf bisa masuk ke sistem perpustakaan.</p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <span>« Batal</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white text-center">
                    <h3 class="font-bold text-lg">Formulir Pendaftaran Akun</h3>
                </div>
                
                <form method="POST" action="{{ route('users.store') }}" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap Staf</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-2 block w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Contoh: Budi Santoso" />
                        @error('name')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email (Untuk Login)</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 block w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Contoh: budi@sekolah.com" />
                        @error('email')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        <input id="password" name="password" type="password" required class="mt-2 block w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" placeholder="Minimal 8 karakter..." />
                        @error('password')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="role_id" class="block text-sm font-semibold text-gray-700">Pilih Hak Akses (Peran)</label>
                        <select id="role_id" name="role_id" required class="mt-2 block w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            <option value="">-- Tentukan Peran --</option>
                            <option value="1">Pustakawan (Mengurus Buku & Sirkulasi)</option>
                            <option value="2">Kepala Sekolah (Hanya Melihat Laporan)</option>
                            <option value="3">Admin IT (Kelola Akun & Sistem)</option>
                        </select>
                        @error('role_id')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            Daftarkan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>