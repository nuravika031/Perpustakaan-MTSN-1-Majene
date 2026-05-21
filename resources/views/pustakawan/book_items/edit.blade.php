<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Koleksi
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Edit Eksemplar Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Perbarui data copy fisik buku, kode eksemplar, status, dan kondisi buku.
                </p>
            </div>

            <a href="{{ route('book_items.index') }}"
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
                                    Form Edit Eksemplar
                                </h3>
                                <p class="mt-1 text-sm text-emerald-50">
                                    Ubah informasi copy fisik buku sesuai kondisi dan status terbaru.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/20 bg-white/15 px-4 py-3">
                            <p class="text-xs text-emerald-50">Kode Eksemplar</p>
                            <p class="mt-1 font-mono text-sm font-bold text-white">
                                {{ $bookItem->item_code }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('book_items.update', $bookItem) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <section class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5 md:p-6">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Buku Induk
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Pilih judul buku induk yang memiliki eksemplar ini.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label for="book_id" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Judul Buku Induk <span class="text-red-500">*</span>
                                </label>

                                <div class="relative mt-2">
                                    <select
                                        id="book_id"
                                        name="book_id"
                                        required
                                        class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >
                                        <option value="">Pilih Judul Buku</option>
                                        @forelse($books as $book)
                                            <option value="{{ $book->id }}" {{ old('book_id', $bookItem->book_id) == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada buku tersedia</option>
                                        @endforelse
                                    </select>

                                    <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                        expand_more
                                    </span>
                                </div>

                                @error('book_id')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700">
                                    <span class="material-symbols-outlined text-[20px]">qr_code_2</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Identitas Eksemplar
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Kode ini digunakan untuk membedakan setiap copy fisik buku.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label for="item_code" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Kode Eksemplar / Barcode <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="item_code"
                                    name="item_code"
                                    type="text"
                                    value="{{ old('item_code', $bookItem->item_code) }}"
                                    placeholder="Contoh: 500-BUD-m-001"
                                    required
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 font-mono text-sm font-bold text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >

                                <p class="mt-2 text-xs text-gray-500">
                                    Pastikan kode sesuai dengan label fisik yang tertempel pada buku.
                                </p>

                                @error('item_code')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                    <span class="material-symbols-outlined text-[20px]">rule</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Status dan Kondisi
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Perbarui status ketersediaan dan kondisi fisik eksemplar.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="status" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Status <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="status"
                                            name="status"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Status</option>
                                            <option value="tersedia" {{ old('status', $bookItem->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="dipinjam" {{ old('status', $bookItem->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="rusak" {{ old('status', $bookItem->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="hilang" {{ old('status', $bookItem->status) == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                            <option value="nonaktif" {{ old('status', $bookItem->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('status')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="condition" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Kondisi Fisik <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="condition"
                                            name="condition"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Kondisi</option>
                                            <option value="baik" {{ old('condition', $bookItem->condition) == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="rusak ringan" {{ old('condition', $bookItem->condition) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                            <option value="rusak berat" {{ old('condition', $bookItem->condition) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                                            <option value="hilang" {{ old('condition', $bookItem->condition) == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('condition')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-amber-700">info</span>
                                    <p class="text-xs leading-5 text-amber-700">
                                        Jika status diubah menjadi <span class="font-bold">rusak</span> atau <span class="font-bold">hilang</span>,
                                        buku tidak akan tersedia untuk peminjaman sampai diperbarui kembali.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('book_items.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                                <span>Perbarui Eksemplar</span>
                                <span class="material-symbols-outlined text-[18px]">save</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>