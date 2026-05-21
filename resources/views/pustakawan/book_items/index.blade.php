<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Koleksi
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Eksemplar Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola setiap copy fisik buku, kode eksemplar, status, dan kondisi buku.
                </p>
            </div>

            <a href="{{ route('book_items.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Tambah Eksemplar Baru
            </a>
        </div>
    </x-slot>

    @php
        $itemCount = method_exists($bookItems, 'total') ? $bookItems->total() : $bookItems->count();
    @endphp

    <div class="py-10 bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow-sm">
                    <div class="font-bold mb-2">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl bg-white/75 backdrop-blur-xl shadow-sm border border-white/70">

                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-700 to-teal-500 p-6">
                    <div class="absolute -right-16 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-20 bottom-0 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

                    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-white text-lg font-semibold">
                                Daftar Eksemplar Buku
                            </h3>
                            <p class="text-emerald-50 mt-1 text-sm">
                                Pantau copy fisik buku berdasarkan kode, judul, status, dan kondisi.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/15 px-4 py-3 text-white">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-50">Total Eksemplar</p>
                                <p class="text-lg font-bold">{{ number_format($itemCount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto rounded-3xl border border-emerald-100 bg-emerald-50/70 p-4">
                        <table class="min-w-[950px] w-full divide-y divide-emerald-100 text-left text-sm">
                            <thead class="bg-white text-xs uppercase tracking-wider text-emerald-700">
                                <tr>
                                    <th class="px-5 py-3 font-bold w-[180px]">Kode Eksemplar</th>
                                    <th class="px-5 py-3 font-bold w-[330px]">Judul Buku</th>
                                    <th class="px-5 py-3 font-bold w-[150px]">Status</th>
                                    <th class="px-5 py-3 font-bold w-[170px]">Kondisi</th>
                                    <th class="px-5 py-3 font-bold w-[220px]">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-emerald-50 bg-white">
                                @forelse($bookItems as $item)
                                    <tr class="transition-colors hover:bg-emerald-50/70">
                                        <td class="px-5 py-5 align-middle">
                                            <div class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2">
                                                <span class="material-symbols-outlined text-[16px] text-slate-500">qr_code_2</span>
                                                <span class="font-mono text-xs font-bold text-slate-800">
                                                    {{ $item->item_code }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            <div class="max-w-[320px]">
                                                <p class="font-semibold leading-5 text-gray-900">
                                                    {{ $item->book->title ?? '-' }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    Penulis: {{ $item->book->author ?? '-' }}
                                                </p>
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            @if($item->status === 'tersedia')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                    Tersedia
                                                </span>
                                            @elseif($item->status === 'dipinjam')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                                    <span class="material-symbols-outlined text-[14px]">autorenew</span>
                                                    Dipinjam
                                                </span>
                                            @elseif($item->status === 'rusak')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                                    Rusak
                                                </span>
                                            @elseif($item->status === 'hilang')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600">
                                                    <span class="material-symbols-outlined text-[14px]">help</span>
                                                    Hilang
                                                </span>
                                            @elseif($item->status === 'nonaktif')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                                    <span class="material-symbols-outlined text-[14px]">block</span>
                                                    Nonaktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center whitespace-nowrap rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                                    {{ ucfirst($item->status ?? '-') }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            @if($item->condition === 'baik')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                                    <span class="material-symbols-outlined text-[14px]">verified</span>
                                                    Baik
                                                </span>
                                            @elseif($item->condition === 'rusak ringan')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                                    <span class="material-symbols-outlined text-[14px]">build</span>
                                                    Rusak Ringan
                                                </span>
                                            @elseif($item->condition === 'rusak berat')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                                    <span class="material-symbols-outlined text-[14px]">report</span>
                                                    Rusak Berat
                                                </span>
                                            @elseif($item->condition === 'hilang')
                                                <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600">
                                                    <span class="material-symbols-outlined text-[14px]">help</span>
                                                    Hilang
                                                </span>
                                            @else
                                                <span class="inline-flex items-center whitespace-nowrap rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                                    {{ ucfirst($item->condition ?? '-') }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ route('book_items.show', $item) }}"
                                                   class="inline-flex items-center gap-1 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100">
                                                    <span class="material-symbols-outlined text-[15px]">visibility</span>
                                                    Lihat
                                                </a>

                                                <a href="{{ route('book_items.edit', $item) }}"
                                                   class="inline-flex items-center gap-1 rounded-full border border-teal-200 bg-teal-50 px-3 py-1.5 text-xs font-bold text-teal-700 transition hover:bg-teal-100">
                                                    <span class="material-symbols-outlined text-[15px]">edit</span>
                                                    Edit
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('book_items.destroy', $item) }}"
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus eksemplar ini?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 transition hover:bg-red-100">
                                                        <span class="material-symbols-outlined text-[15px]">delete</span>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-14 text-center">
                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                                <span class="material-symbols-outlined">inventory_2</span>
                                            </div>
                                            <p class="mt-4 text-sm font-semibold text-gray-700">
                                                Belum ada eksemplar buku.
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Klik tombol Tambah Eksemplar Baru untuk mulai menambahkan copy fisik buku.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($bookItems, 'links'))
                        <div class="mt-6">
                            {{ $bookItems->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>