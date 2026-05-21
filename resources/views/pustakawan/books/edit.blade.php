<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Koleksi
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Edit Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Perbarui informasi buku agar data katalog perpustakaan tetap akurat.
                </p>
            </div>

            <a href="{{ route('books.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/40 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow-sm">
                    <div class="font-bold mb-2">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/75 backdrop-blur-xl shadow-[0_20px_60px_rgba(15,23,42,0.08)]">

                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-700 to-teal-500 p-6 text-white">
                    <div class="absolute -right-16 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-20 bottom-0 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

                    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white shadow-sm">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                                    edit_note
                                </span>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold">
                                    Form Ubah Buku
                                </h3>
                                <p class="mt-1 text-sm text-emerald-50">
                                    Perbarui data utama buku yang tersimpan pada katalog perpustakaan.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/20 bg-white/15 px-4 py-3">
                            <p class="text-xs text-emerald-50">Buku yang diedit</p>
                            <p class="mt-1 max-w-[260px] truncate text-sm font-bold text-white">
                                {{ $book->title }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('books.update', $book) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <section class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5 md:p-6">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Informasi Utama Buku
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Data dasar yang digunakan untuk menampilkan buku pada katalog.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Judul Buku <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="title"
                                        name="title"
                                        type="text"
                                        value="{{ old('title', $book->title) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                    @error('title')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="author" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Penulis <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="author"
                                        name="author"
                                        type="text"
                                        value="{{ old('author', $book->author) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                    @error('author')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="publisher" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Penerbit <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="publisher"
                                        name="publisher"
                                        type="text"
                                        value="{{ old('publisher', $book->publisher) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                    @error('publisher')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="publication_year" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Tahun Terbit
                                    </label>
                                    <input
                                        id="publication_year"
                                        name="publication_year"
                                        type="number"
                                        min="1900"
                                        max="{{ date('Y') + 1 }}"
                                        value="{{ old('publication_year', $book->publication_year) }}"
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                    @error('publication_year')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Harga Buku
                                    </label>
                                    <input
                                        id="price"
                                        name="price"
                                        type="number"
                                        min="0"
                                        value="{{ old('price', $book->price) }}"
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                    @error('price')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700">
                                    <span class="material-symbols-outlined text-[20px]">category</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Kategori dan Klasifikasi
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Tentukan kategori mata pelajaran dan nomor klasifikasi buku.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="category_id" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="category_id"
                                            name="category_id"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Kategori</option>
                                            @forelse($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Tidak ada kategori tersedia</option>
                                            @endforelse
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @if($categories->isEmpty())
                                        <p class="mt-2 text-xs font-medium text-amber-700">
                                            Belum ada data kategori. Tambahkan kategori terlebih dahulu di menu Kategori.
                                        </p>
                                    @endif

                                    @error('category_id')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ddc_class_id" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Kelas DDC <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="ddc_class_id"
                                            name="ddc_class_id"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih DDC</option>
                                            @forelse($ddcClasses as $ddcClass)
                                                <option value="{{ $ddcClass->id }}" {{ old('ddc_class_id', $book->ddc_class_id) == $ddcClass->id ? 'selected' : '' }}>
                                                    {{ $ddcClass->code }} - {{ $ddcClass->name ?? 'Klasifikasi Buku' }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Tidak ada kelas DDC tersedia</option>
                                            @endforelse
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @if($ddcClasses->isEmpty())
                                        <p class="mt-2 text-xs font-medium text-amber-700">
                                            Belum ada data kelas DDC. Tambahkan DDC terlebih dahulu di menu Kelas DDC.
                                        </p>
                                    @endif

                                    @error('ddc_class_id')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                    <span class="material-symbols-outlined text-[20px]">rule</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Aturan Peminjaman
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Tentukan apakah buku ini bisa dipinjam pulang atau hanya dibaca di tempat.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="is_borrowable" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Status Peminjaman
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="is_borrowable"
                                            name="is_borrowable"
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="1" {{ old('is_borrowable', $book->is_borrowable) == 1 ? 'selected' : '' }}>
                                                Bisa Dipinjam
                                            </option>
                                            <option value="0" {{ old('is_borrowable', $book->is_borrowable) == 0 ? 'selected' : '' }}>
                                                Baca di Tempat
                                            </option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('is_borrowable')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Deskripsi / Catatan
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="3"
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        placeholder="Catatan tambahan tentang buku..."
                                    >{{ old('description', $book->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('books.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                                <span>Perbarui Buku</span>
                                <span class="material-symbols-outlined text-[18px]">save</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>