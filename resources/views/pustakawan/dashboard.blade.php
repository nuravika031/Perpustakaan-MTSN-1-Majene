<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">
                Dashboard Perpustakaan
            </p>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">
                Sistem Manajemen Perpustakaan MTsN 1 Majene
            </h2>
            <p class="text-sm text-slate-500 max-w-3xl">
                Ringkasan aktivitas perpustakaan, data koleksi, transaksi peminjaman.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-8">

            {{-- Statistic Cards --}}
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="group relative overflow-hidden rounded-[1.5rem] border border-white/70 bg-white/60 backdrop-blur-xl p-6 shadow-[0_12px_35px_rgba(15,23,42,0.06)] transition hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-200/40 blur-2xl"></div>

                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                                Total Eksemplar
                            </p>
                            <h3 class="mt-4 text-4xl font-extrabold text-slate-950">
                                {{ number_format($totalBooks, 0, ',', '.') }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                Seluruh copy buku yang tercatat.
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">library_books</span>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[1.5rem] border border-white/70 bg-white/60 backdrop-blur-xl p-6 shadow-[0_12px_35px_rgba(15,23,42,0.06)] transition hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-sky-200/40 blur-2xl"></div>

                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                                Anggota Aktif
                            </p>
                            <h3 class="mt-4 text-4xl font-extrabold text-slate-950">
                                {{ number_format($activeMembers, 0, ',', '.') }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                Siswa dan guru aktif.
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-sky-700">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[1.5rem] border border-white/70 bg-white/60 backdrop-blur-xl p-6 shadow-[0_12px_35px_rgba(15,23,42,0.06)] transition hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-indigo-200/40 blur-2xl"></div>

                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                                Peminjaman Hari Ini
                            </p>
                            <h3 class="mt-4 text-4xl font-extrabold text-slate-950">
                                {{ number_format($loansToday, 0, ',', '.') }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ number_format($activeLoans, 0, ',', '.') }} masih diproses.
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">swap_horiz</span>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[1.5rem] border border-white/70 bg-white/60 backdrop-blur-xl p-6 shadow-[0_12px_35px_rgba(15,23,42,0.06)] transition hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-rose-200/40 blur-2xl"></div>

                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                                Denda Belum Dibayar
                            </p>
                            <h3 class="mt-4 text-3xl font-extrabold text-rose-600">
                                Rp {{ number_format($estimatedFines, 0, ',', '.') }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                Dari {{ number_format($overdueLoansCount, 0, ',', '.') }} transaksi telat.
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Main Content --}}
            <section class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                {{-- Book Highlight --}}
                <div class="xl:col-span-4">
                    <div class="h-full overflow-hidden rounded-[1.75rem] border border-white/70 bg-white/60 backdrop-blur-xl shadow-[0_12px_35px_rgba(15,23,42,0.06)]">
                        <div class="flex items-center justify-between border-b border-white/70 bg-white/40 px-6 py-5">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    Sorotan Buku
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Koleksi yang sering tampil di sistem.
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                <span class="material-symbols-outlined">auto_stories</span>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            @forelse($popularBooks as $book)
                                <div class="group flex items-center gap-4 rounded-2xl border border-white/70 bg-white/70 p-4 transition hover:border-emerald-200 hover:bg-emerald-50/70">
                                    <div class="flex h-16 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-100 to-white text-emerald-700 shadow-sm">
                                        <span class="material-symbols-outlined">menu_book</span>
                                    </div>

                                    <div class="min-w-0">
                                        <h4 class="truncate text-sm font-bold text-slate-900">
                                            {{ $book->title }}
                                        </h4>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $book->author }}
                                        </p>
                                        <p class="mt-2 text-[11px] font-bold uppercase tracking-[0.12em] text-emerald-700">
                                            Koleksi Buku
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-white/60 p-6 text-center">
                                    <p class="text-sm font-medium text-slate-500">
                                        Belum ada data buku.
                                    </p>
                                </div>
                            @endforelse

                            <a href="{{ route('books.index') }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white/75 px-4 py-3 text-sm font-bold text-emerald-800 transition hover:bg-emerald-50">
                                <span class="material-symbols-outlined text-[18px]">library_books</span>
                                Lihat Katalog Lengkap
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Recent Transactions --}}
                <div class="xl:col-span-8">
                    <div class="h-full overflow-hidden rounded-[1.75rem] border border-white/70 bg-white/60 backdrop-blur-xl shadow-[0_12px_35px_rgba(15,23,42,0.06)]">
                        <div class="flex flex-col gap-4 border-b border-white/70 bg-white/40 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    Transaksi Terbaru
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Aktivitas peminjaman terbaru di perpustakaan.
                                </p>
                            </div>

                            <a href="{{ route('loans.index') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-800">
                                Lihat Semua
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-white/70 bg-white/30 text-left">
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                                            ID Transaksi
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                                            Peminjam
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                                            Status
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-white/60">
                                    @forelse($recentLoans as $recent)
                                        @php
                                            $isLate = $recent->status === 'aktif' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($recent->due_date));
                                        @endphp

                                        <tr class="bg-white/35 transition hover:bg-white/70">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-slate-900">
                                                    {{ $recent->loan_code }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {{ \Carbon\Carbon::parse($recent->loan_date)->format('d M Y') }}
                                                </p>
                                            </td>

                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-slate-900">
                                                    {{ $recent->member->name ?? '-' }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {{ $recent->member->nis_nip ?? '-' }}
                                                </p>
                                            </td>

                                            <td class="px-6 py-4">
                                                @if($recent->status === 'selesai')
                                                    <span class="inline-flex items-center rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-bold text-sky-700">
                                                        Dikembalikan
                                                    </span>
                                                @elseif($isLate)
                                                    <span class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700">
                                                        Terlambat
                                                    </span>
                                                @elseif($recent->status === 'batal')
                                                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-bold text-slate-600">
                                                        Dibatalkan
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                                        Dipinjam
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-14 text-center">
                                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                                    <span class="material-symbols-outlined">receipt_long</span>
                                                </div>
                                                <p class="mt-4 text-sm font-semibold text-slate-600">
                                                    Belum ada transaksi di sistem.
                                                </p>
                                                <p class="mt-1 text-xs text-slate-400">
                                                    Transaksi peminjaman akan tampil di bagian ini.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </div>
</x-app-layout>