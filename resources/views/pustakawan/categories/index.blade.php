<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Master Data
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Kategori Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola pengelompokan buku agar koleksi perpustakaan lebih mudah dicari dan diatur.
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    @php
        $categoryCount = method_exists($categories, 'total') ? $categories->total() : $categories->count();
    @endphp

    <div class="py-10 bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
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

                {{-- Header Card --}}
                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-700 to-teal-500 p-6">
                    <div class="absolute -right-16 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-20 bottom-0 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

                    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-white text-lg font-semibold">
                                Daftar Kategori Buku
                            </h3>
                            <p class="text-emerald-50 mt-1 text-sm">
                                Gunakan kategori untuk mengelompokkan buku berdasarkan mata pelajaran atau jenis koleksi.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/15 px-4 py-3 text-white">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20">
                                <span class="material-symbols-outlined">category</span>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-50">Total Kategori</p>
                                <p class="text-lg font-bold">{{ number_format($categoryCount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto rounded-3xl border border-emerald-100 bg-emerald-50/70 p-4">
                        <table class="min-w-[850px] w-full divide-y divide-emerald-100 text-left text-sm">
                            <thead class="bg-white text-xs uppercase tracking-wider text-emerald-700">
                                <tr>
                                    <th class="px-5 py-3 font-bold w-[80px]">No</th>
                                    <th class="px-5 py-3 font-bold w-[260px]">Nama Kategori</th>
                                    <th class="px-5 py-3 font-bold">Deskripsi</th>
                                    <th class="px-5 py-3 font-bold w-[180px] text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-emerald-50 bg-white">
                                @forelse($categories as $index => $category)
                                    <tr class="transition-colors hover:bg-emerald-50/70">
                                        <td class="px-5 py-5 align-middle">
                                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-sm font-bold text-emerald-700">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5">
                                                <span class="material-symbols-outlined text-[15px] text-emerald-700">label</span>
                                                <span class="text-xs font-bold text-emerald-700">
                                                    {{ $category->name }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-5 py-5 align-middle">
                                            <p class="max-w-2xl text-sm leading-6 text-gray-600">
                                                {{ $category->description ?? 'Belum ada deskripsi kategori.' }}
                                            </p>
                                        </td>

                                        <td class="px-5 py-5 align-middle text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                   class="inline-flex items-center gap-1 rounded-full border border-teal-200 bg-teal-50 px-3 py-1.5 text-xs font-bold text-teal-700 transition hover:bg-teal-100">
                                                    <span class="material-symbols-outlined text-[15px]">edit</span>
                                                    Edit
                                                </a>

                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                      method="POST"
                                                      class="inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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
                                        <td colspan="4" class="px-6 py-14 text-center">
                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                                <span class="material-symbols-outlined">category</span>
                                            </div>
                                            <p class="mt-4 text-sm font-semibold text-gray-700">
                                                Belum ada data kategori.
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Klik tombol Tambah Kategori untuk mulai membuat pengelompokan buku.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($categories, 'links'))
                        <div class="mt-6">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>