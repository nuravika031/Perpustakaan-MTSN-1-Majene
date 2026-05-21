<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Manajemen Sirkulasi</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data peminjaman, pengembalian, dan pantau status transaksi perpustakaan.</p>
            </div>
            <a href="{{ route('loans.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-colors">
                Peminjaman Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm border border-emerald-100">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6">
                    <h3 class="text-white text-lg font-semibold">Riwayat Transaksi</h3>
                    <p class="text-emerald-100 mt-1 text-sm">Pantau daftar buku yang sedang dipinjam, terlambat, atau sudah dikembalikan.</p>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto rounded-3xl border border-emerald-100 bg-emerald-50 p-4">
                        <table class="min-w-full divide-y divide-emerald-200 text-left text-sm">
                            <thead class="rounded-3xl bg-white text-xs uppercase tracking-wider text-emerald-700">
                                <tr>
                                    <th class="px-6 py-3">Kode Transaksi</th>
                                    <th class="px-6 py-3">Nama Peminjam</th>
                                    <th class="px-6 py-3">Tgl Pinjam</th>
                                    <th class="px-6 py-3">Jatuh Tempo</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-100 bg-white">
                                @forelse($loans as $loan)
                                    <tr class="hover:bg-emerald-50 transition-colors">
                                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $loan->loan_code }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $loan->member->name }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                        
                                        <td class="px-6 py-4 text-gray-700">
                                            @php
                                                $isOverdue = \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($loan->due_date)->startOfDay()) && $loan->status == 'aktif';
                                            @endphp
                                            <span class="{{ $isOverdue ? 'text-red-600 font-bold flex items-center gap-1' : '' }}">
                                                @if($isOverdue) <span class="material-symbols-outlined text-[16px]">warning</span> @endif
                                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            @if($loan->status == 'aktif')
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-800">
                                                    DIPINJAM
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    SELESAI
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 text-sm font-medium text-emerald-700 space-x-2">
                                            <a href="{{ route('loans.show', $loan->id) }}" class="inline-flex items-center gap-1 rounded-full px-3 py-1 hover:bg-emerald-100 transition-colors">
                                                Lihat
                                            </a>

                                            @if($loan->status == 'aktif')
                                                <a href="{{ route('loans.edit', $loan->id) }}" class="inline-flex items-center gap-1 rounded-full px-3 py-1 hover:bg-emerald-100 transition-colors text-blue-600 hover:text-blue-800">
                                                    Proses
                                                </a>
                                            @endif

                                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat transaksi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-red-600 hover:bg-red-100 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            Belum ada data transaksi peminjaman. Klik tombol Peminjaman Baru untuk memulai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>