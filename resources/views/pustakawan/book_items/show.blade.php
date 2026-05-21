<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Koleksi
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Detail Eksemplar Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Lihat informasi lengkap copy fisik buku, kode eksemplar, status, dan kondisi buku.
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

            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

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

                {{-- Header Card --}}
                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-700 to-teal-500 p-6 text-white">
                    <div class="absolute -right-16 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-20 bottom-0 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

                    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white shadow-sm">
                                <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">
                                    inventory_2
                                </span>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-50">
                                    Detail Eksemplar
                                </p>
                                <h3 class="mt-2 max-w-2xl text-2xl font-bold leading-snug text-white">
                                    {{ $bookItem->book->title ?? '-' }}
                                </h3>
                                <p class="mt-2 text-sm text-emerald-50">
                                    Kode Eksemplar:
                                    <span class="font-mono font-bold">{{ $bookItem->item_code }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if($bookItem->status === 'tersedia')
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    Tersedia
                                </span>
                            @elseif($bookItem->status === 'dipinjam')
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">autorenew</span>
                                    Dipinjam
                                </span>
                            @elseif($bookItem->status === 'rusak')
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">error</span>
                                    Rusak
                                </span>
                            @elseif($bookItem->status === 'hilang')
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">help</span>
                                    Hilang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    {{ ucfirst($bookItem->status ?? '-') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-8">

                    {{-- Informasi Buku Induk --}}
                    <section class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5 md:p-6">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <span class="material-symbols-outlined text-[20px]">menu_book</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Informasi Buku Induk
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Data utama buku yang menjadi induk dari eksemplar ini.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Judul Buku
                                </p>
                                <p class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                    {{ $bookItem->book->title ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Penulis
                                </p>
                                <p class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                    {{ $bookItem->book->author ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Penerbit
                                </p>
                                <p class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                    {{ $bookItem->book->publisher ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Tahun Terbit
                                </p>
                                <p class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                    {{ $bookItem->book->publication_year ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Kategori dan Kode --}}
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
                                    Informasi pengelompokan buku untuk memudahkan pencarian dan penempatan rak.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-3">
                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Kategori
                                </p>
                                <div class="mt-3">
                                    <span class="inline-flex rounded-full border border-emerald-200 bg-white px-3 py-1.5 text-xs font-bold text-emerald-700">
                                        {{ $bookItem->book->category->name ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-sky-700">
                                    Kelas DDC
                                </p>
                                <div class="mt-3">
                                    <span class="inline-flex rounded-full border border-sky-200 bg-white px-3 py-1.5 text-xs font-bold text-sky-700">
                                        {{ $bookItem->book->ddcClass->code ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">
                                    Kode Eksemplar
                                </p>
                                <div class="mt-3">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 font-mono text-xs font-bold text-slate-700">
                                        <span class="material-symbols-outlined text-[14px]">qr_code_2</span>
                                        {{ $bookItem->item_code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Informasi Eksemplar --}}
                    <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <span class="material-symbols-outlined text-[20px]">rule</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Status dan Kondisi Eksemplar
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Status menunjukkan ketersediaan buku, sedangkan kondisi menunjukkan keadaan fisiknya.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-3">
                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Status
                                </p>

                                <div class="mt-3">
                                    @if($bookItem->status === 'tersedia')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                            Tersedia
                                        </span>
                                    @elseif($bookItem->status === 'dipinjam')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                            <span class="material-symbols-outlined text-[14px]">autorenew</span>
                                            Dipinjam
                                        </span>
                                    @elseif($bookItem->status === 'rusak')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                            <span class="material-symbols-outlined text-[14px]">error</span>
                                            Rusak
                                        </span>
                                    @elseif($bookItem->status === 'hilang')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600">
                                            <span class="material-symbols-outlined text-[14px]">help</span>
                                            Hilang
                                        </span>
                                    @elseif($bookItem->status === 'nonaktif')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                            <span class="material-symbols-outlined text-[14px]">block</span>
                                            Nonaktif
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                            {{ ucfirst($bookItem->status ?? '-') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Kondisi Fisik
                                </p>

                                <div class="mt-3">
                                    @if($bookItem->condition === 'baik')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                            <span class="material-symbols-outlined text-[14px]">verified</span>
                                            Baik
                                        </span>
                                    @elseif($bookItem->condition === 'rusak ringan')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                            <span class="material-symbols-outlined text-[14px]">build</span>
                                            Rusak Ringan
                                        </span>
                                    @elseif($bookItem->condition === 'rusak berat')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                            <span class="material-symbols-outlined text-[14px]">report</span>
                                            Rusak Berat
                                        </span>
                                    @elseif($bookItem->condition === 'hilang')
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600">
                                            <span class="material-symbols-outlined text-[14px]">help</span>
                                            Hilang
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                            {{ ucfirst($bookItem->condition ?? '-') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Terakhir Diperbarui
                                </p>
                                <p class="mt-3 text-sm font-bold text-gray-900">
                                    {{ $bookItem->updated_at ? $bookItem->updated_at->format('d M Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('book_items.edit', $bookItem) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Edit Eksemplar
                        </a>

                        <form method="POST"
                              action="{{ route('book_items.destroy', $bookItem) }}"
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus eksemplar ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-red-200 bg-white px-6 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50 sm:w-auto">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                Hapus Eksemplar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>