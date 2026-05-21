<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Peminjaman & Pengembalian
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Proses Pengembalian Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Periksa buku yang dikembalikan, kondisi buku, dan denda keterlambatan.
                </p>
            </div>

            <a href="{{ route('loans.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    @php
        $today = \Carbon\Carbon::today();
        $dueDate = \Carbon\Carbon::parse($loan->due_date)->startOfDay();
        $isOverdue = $today->gt($dueDate) && $loan->status === 'aktif';
        $lateDays = $isOverdue ? (int) $dueDate->diffInDays($today) : 0;
        $finePerDay = 500;
        $estimatedFinePerItem = $lateDays * $finePerDay;

        $activeItems = $loan->loanItems->filter(function ($item) {
            return in_array($item->status, ['dipinjam', 'terlambat']);
        });
    @endphp

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

                    <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white shadow-sm">
                                <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">
                                    assignment_return
                                </span>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-50">
                                    Kode Transaksi
                                </p>
                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    {{ $loan->loan_code }}
                                </h3>
                                <p class="mt-2 text-sm text-emerald-50">
                                    Peminjam: <span class="font-semibold">{{ $loan->member->name ?? '-' }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            @if($isOverdue)
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">warning</span>
                                    Terlambat {{ $lateDays }} hari
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    Belum Terlambat
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-8">

                    <section class="grid gap-5 md:grid-cols-4">
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                Nama Peminjam
                            </p>
                            <p class="mt-2 text-sm font-bold text-gray-900">
                                {{ $loan->member->name ?? '-' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $loan->member->nis_nip ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                Kelas / Jenis
                            </p>
                            <p class="mt-2 text-sm font-bold text-gray-900">
                                {{ $loan->member->studentClass->class_name ?? 'Guru/Staff' }}
                            </p>
                            <p class="mt-1 text-xs capitalize text-gray-500">
                                {{ $loan->member->member_type ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-sky-700">
                                Tanggal Pinjam
                            </p>
                            <p class="mt-2 text-sm font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl border {{ $isOverdue ? 'border-red-100 bg-red-50/70' : 'border-emerald-100 bg-emerald-50/60' }} p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.14em] {{ $isOverdue ? 'text-red-700' : 'text-emerald-700' }}">
                                Jatuh Tempo
                            </p>
                            <p class="mt-2 text-sm font-bold {{ $isOverdue ? 'text-red-700' : 'text-gray-900' }}">
                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                            </p>
                        </div>
                    </section>

                    @if($isOverdue)
                        <section class="rounded-3xl border border-orange-200 bg-orange-50 p-5 md:p-6">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-orange-700">
                                    <span class="material-symbols-outlined">payments</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-orange-800">
                                        Informasi Denda
                                    </h4>
                                    <p class="mt-1 text-sm leading-6 text-orange-700">
                                        Transaksi ini terlambat {{ $lateDays }} hari. Denda dihitung sebesar
                                        <span class="font-bold">Rp{{ number_format($finePerDay, 0, ',', '.') }}</span>
                                        per hari untuk setiap buku yang dikembalikan.
                                    </p>
                                    <p class="mt-2 text-sm font-bold text-orange-800">
                                        Estimasi denda per buku: Rp{{ number_format($estimatedFinePerItem, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </section>
                    @endif

                    <form method="POST" action="{{ route('loans.update', $loan->id) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <span class="material-symbols-outlined text-[20px]">format_list_bulleted</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Daftar Buku yang Dikembalikan
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Pilih kondisi setiap buku sesuai kondisi fisik saat dikembalikan.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @forelse($activeItems as $index => $item)
                                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5">
                                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-sm font-bold text-emerald-700 shadow-sm">
                                                    {{ $index + 1 }}
                                                </div>

                                                <div>
                                                    <p class="text-sm font-bold text-gray-900">
                                                        {{ $item->bookItem->book->title ?? '-' }}
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        Kode Eksemplar:
                                                        <span class="font-mono font-bold">{{ $item->bookItem->item_code ?? '-' }}</span>
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        Kondisi saat ini:
                                                        <span class="font-semibold capitalize">{{ $item->bookItem->condition ?? '-' }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="w-full md:w-64">
                                                <label class="mb-1.5 block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                                    Kondisi Kembali
                                                </label>

                                                <div class="relative">
                                                    <select
                                                        name="items[{{ $item->id }}][return_condition]"
                                                        required
                                                        class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-sm font-semibold text-gray-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                    >
                                                        <option value="baik">Kembali Baik</option>
                                                        <option value="rusak ringan">Rusak Ringan</option>
                                                        <option value="rusak berat">Rusak Berat</option>
                                                        <option value="hilang">Buku Hilang</option>
                                                    </select>

                                                    <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                                        expand_more
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-gray-400">
                                            <span class="material-symbols-outlined">task_alt</span>
                                        </div>
                                        <p class="mt-4 text-sm font-semibold text-gray-700">
                                            Tidak ada buku aktif untuk dikembalikan.
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            Kemungkinan transaksi ini sudah selesai diproses.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </section>

                        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('loans.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                                Batal
                            </a>

                            @if($activeItems->count() > 0)
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                                    <span>Selesaikan Pengembalian</span>
                                    <span class="material-symbols-outlined text-[18px]">task_alt</span>
                                </button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>