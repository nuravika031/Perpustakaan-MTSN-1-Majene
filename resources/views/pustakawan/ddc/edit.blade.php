<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Edit Master DDC</h2>
                <p class="mt-1 text-sm text-gray-500">Sesuaikan penamaan klasifikasi agar mudah dipahami oleh staf perpustakaan.</p>
            </div>
            <a href="{{ route('ddc.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <span>« Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-3xl border border-indigo-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-blue-500 p-6 text-white text-center">
                    <h3 class="font-bold text-lg flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">edit_note</span>
                        Perbarui Informasi Kelas DDC
                    </h3>
                </div>
                
                <form method="POST" action="{{ route('ddc.update', $ddcClass->id) }}" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Kode DDC (Standar Internasional)</label>
                        <div class="mt-2 flex items-center gap-3">
                            <input type="text" value="{{ $ddcClass->code }}" readonly disabled class="block w-32 rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-500 font-bold cursor-not-allowed" />
                            <span class="text-xs text-red-500 font-medium">
                                *Kode ini tidak dapat diedit karena terhubung dengan rak dan label buku fisik.
                            </span>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Klasifikasi</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $ddcClass->name) }}" required class="mt-2 block w-full rounded-2xl border border-indigo-200 bg-indigo-50/50 px-4 py-3 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" />
                        @error('name')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi / Penjelasan (Opsional)</label>
                        <textarea id="description" name="description" rows="3" class="mt-2 block w-full rounded-2xl border border-indigo-200 bg-indigo-50/50 px-4 py-3 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all">{{ old('description', $ddcClass->description) }}</textarea>
                        @error('description')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('ddc.index') }}" class="px-6 py-3 font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>