<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Master Data
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Manajemen Kelas
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data kelas aktif untuk pengelompokan anggota perpustakaan.
                </p>
            </div>

            <button
                type="button"
                onclick="window.dispatchEvent(new CustomEvent('open-create-class-modal'))"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800"
            >
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Tambah Kelas
            </button>
        </div>
    </x-slot>

    @php
        $classCount = method_exists($classes, 'total') ? $classes->total() : $classes->count();
        $oldRows = old('classes', []);

        $levelOptions = $classes->pluck('level')->filter()->unique()->sort()->values();
        $yearOptions = $classes->pluck('academic_year')->filter()->unique()->sortDesc()->values();
    @endphp

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/30 to-sky-50/30 py-8"
        x-data="classPage(@js($oldRows), @js($errors->any()))"
        @open-create-class-modal.window="openModal()"
        @keydown.escape.window="showCreateModal = false"
    >
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-[0_18px_50px_rgba(15,23,42,0.06)] backdrop-blur-xl">
                <div class="border-b border-gray-100 bg-white px-6 py-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                <span class="material-symbols-outlined">school</span>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Database Kelas
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Total {{ number_format($classCount, 0, ',', '.') }} kelas tersimpan.
                                </p>
                            </div>
                        </div>

                        <div class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                            <span class="material-symbols-outlined text-[18px]">layers</span>
                            {{ number_format($classCount, 0, ',', '.') }} Kelas
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 lg:grid-cols-[1.4fr_1fr_1fr_auto]">
                        <div class="relative">
                            <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">
                                search
                            </span>

                            <input
                                type="text"
                                x-model="search"
                                placeholder="Cari nama kelas atau tahun ajaran..."
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-12 py-3 text-sm text-gray-800 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                            >
                        </div>

                        <div class="relative">
                            <select
                                x-model="filterLevel"
                                class="w-full appearance-none rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 pr-10 text-sm text-gray-700 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                            >
                                <option value="">Semua Tingkat</option>
                                @foreach($levelOptions as $level)
                                    <option value="{{ $level }}">Kelas {{ $level }}</option>
                                @endforeach
                            </select>

                            <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">
                                expand_more
                            </span>
                        </div>

                        <div class="relative">
                            <select
                                x-model="filterYear"
                                class="w-full appearance-none rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 pr-10 text-sm text-gray-700 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                            >
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach($yearOptions as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>

                            <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-[20px] text-gray-400">
                                expand_more
                            </span>
                        </div>

                        <button
                            type="button"
                            @click="resetFilter()"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                        >
                            <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                            Reset
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto rounded-3xl border border-gray-100 bg-white">
                        <table class="min-w-[850px] w-full divide-y divide-gray-100 text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-gray-500">
                                <tr>
                                    <th class="px-5 py-4 font-bold w-[280px]">Nama Kelas</th>
                                    <th class="px-5 py-4 font-bold text-center w-[150px]">Tingkat</th>
                                    <th class="px-5 py-4 font-bold w-[220px]">Tahun Ajaran</th>
                                    <th class="px-5 py-4 font-bold text-center w-[220px]">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($classes as $class)
                                    @php
                                        $searchText = strtolower(
                                            ($class->class_name ?? '') . ' ' .
                                            ($class->level ?? '') . ' ' .
                                            ($class->academic_year ?? '')
                                        );
                                    @endphp

                                    <tr
                                        class="transition hover:bg-emerald-50/40"
                                        x-show="matches(@js($searchText), @js((string) $class->level), @js($class->academic_year))"
                                    >
                                        <td class="px-5 py-4 align-middle">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                                    <span class="material-symbols-outlined text-[20px]">class</span>
                                                </div>

                                                <div>
                                                    <p class="font-bold text-gray-900">
                                                        {{ $class->class_name }}
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        Kelompok anggota siswa
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-center align-middle">
                                            <span class="inline-flex items-center justify-center rounded-full border border-emerald-100 bg-emerald-50 px-4 py-1.5 text-xs font-bold text-emerald-700">
                                                Kelas {{ $class->level }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 align-middle">
                                            <span class="text-sm font-semibold text-gray-700">
                                                {{ $class->academic_year }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 text-center align-middle">
                                            <div class="flex flex-wrap items-center justify-center gap-2">
                                                <a href="{{ route('classes.edit', $class->id) }}"
                                                   class="inline-flex items-center gap-1 rounded-full border border-teal-200 bg-white px-3 py-1.5 text-xs font-bold text-teal-700 transition hover:bg-teal-50">
                                                    <span class="material-symbols-outlined text-[15px]">edit</span>
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('classes.destroy', $class->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Hapus kelas ini? Pastikan kelas tidak sedang digunakan oleh anggota.')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1 rounded-full border border-red-200 bg-white px-3 py-1.5 text-xs font-bold text-red-600 transition hover:bg-red-50"
                                                    >
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
                                                <span class="material-symbols-outlined">school</span>
                                            </div>
                                            <p class="mt-4 text-sm font-semibold text-gray-700">
                                                Data kelas masih kosong.
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Klik tombol Tambah Kelas untuk membuat data kelas baru.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($classes, 'links'))
                        <div class="mt-6">
                            {{ $classes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div
            x-show="showCreateModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 overflow-y-auto px-4 py-6"
        >
            <div
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"
                @click="showCreateModal = false"
            ></div>

            <div class="relative z-10 flex min-h-full items-start justify-center py-6">
                <div
                    x-show="showCreateModal"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-3"
                    class="flex max-h-[88vh] w-full max-w-5xl flex-col overflow-hidden rounded-[2rem] border border-white/70 bg-white shadow-2xl"
                >
                    <div class="flex shrink-0 items-center justify-between border-b border-gray-100 bg-gradient-to-r from-emerald-700 to-teal-500 px-6 py-5 text-white">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-50">
                                Input Banyak Data
                            </p>
                            <h3 class="mt-1 text-lg font-bold">
                                Tambah Kelas Baru
                            </h3>
                            <p class="mt-1 text-xs text-emerald-50">
                                Tentukan jumlah entry, lalu isi data kelas per baris.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="showCreateModal = false"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/25"
                        >
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('classes.store') }}" class="flex min-h-0 flex-1 flex-col">
                        @csrf

                        <div class="flex-1 space-y-5 overflow-y-auto p-6">
                            @if($errors->any())
                                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
                                    <p class="text-sm font-bold">Data kelas belum bisa disimpan</p>
                                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-5">
                                <div class="grid gap-4 md:grid-cols-[1fr_180px_160px] md:items-end">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">
                                            Jumlah Entry Kelas
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            Pilih jumlah baris data yang ingin dibuat. Maksimal 20 kelas sekali simpan.
                                        </p>
                                    </div>

                                    <div>
                                        <label for="entry_count" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                            Jumlah Entry
                                        </label>

                                        <input
                                            id="entry_count"
                                            type="number"
                                            min="1"
                                            max="20"
                                            x-model.number="entryCount"
                                            class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                    </div>

                                    <button
                                        type="button"
                                        @click="generateRows()"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-800"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">table_rows</span>
                                        Buat Baris
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto rounded-3xl border border-gray-100">
                                <table class="min-w-[850px] w-full divide-y divide-gray-100 text-left text-sm">
                                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-gray-500">
                                        <tr>
                                            <th class="px-4 py-3 font-bold w-[70px]">No</th>
                                            <th class="px-4 py-3 font-bold">Nama Kelas</th>
                                            <th class="px-4 py-3 font-bold w-[180px]">Tingkat</th>
                                            <th class="px-4 py-3 font-bold w-[200px]">Tahun Ajaran</th>
                                            <th class="px-4 py-3 font-bold w-[90px] text-center">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <template x-for="(row, index) in rows" :key="index">
                                            <tr>
                                                <td class="px-4 py-4 align-middle">
                                                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-xs font-bold text-emerald-700">
                                                        <span x-text="index + 1"></span>
                                                    </div>
                                                </td>

                                                <td class="px-4 py-4 align-middle">
                                                    <input
                                                        type="text"
                                                        :name="`classes[${index}][class_name]`"
                                                        x-model="row.class_name"
                                                        required
                                                        placeholder="Contoh: VII A"
                                                        class="block w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                    >
                                                </td>

                                                <td class="px-4 py-4 align-middle">
                                                    <select
                                                        :name="`classes[${index}][level]`"
                                                        x-model="row.level"
                                                        required
                                                        class="block w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                    >
                                                        <option value="">Pilih</option>
                                                        <option value="7">Kelas 7</option>
                                                        <option value="8">Kelas 8</option>
                                                        <option value="9">Kelas 9</option>
                                                    </select>
                                                </td>

                                                <td class="px-4 py-4 align-middle">
                                                    <input
                                                        type="text"
                                                        :name="`classes[${index}][academic_year]`"
                                                        x-model="row.academic_year"
                                                        required
                                                        placeholder="2026/2027"
                                                        class="block w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                    >
                                                </td>

                                                <td class="px-4 py-4 text-center align-middle">
                                                    <button
                                                        type="button"
                                                        @click="removeRow(index)"
                                                        x-show="rows.length > 1"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100"
                                                    >
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="sticky bottom-0 flex shrink-0 flex-col-reverse gap-3 border-t border-gray-100 bg-white px-6 py-5 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                @click="showCreateModal = false"
                                class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800"
                            >
                                <span>Simpan Semua Kelas</span>
                                <span class="material-symbols-outlined text-[18px]">save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <script>
            function classPage(oldRows, hasErrors) {
                return {
                    search: '',
                    filterLevel: '',
                    filterYear: '',

                    showCreateModal: hasErrors,
                    entryCount: oldRows.length > 0 ? oldRows.length : 1,
                    rows: oldRows.length > 0 ? oldRows : [
                        {
                            class_name: '',
                            level: '',
                            academic_year: '{{ date('Y') . '/' . (date('Y') + 1) }}',
                        }
                    ],

                    matches(searchText, level, year) {
                        const keyword = this.search.toLowerCase().trim();

                        const matchSearch = keyword === '' || searchText.toLowerCase().includes(keyword);
                        const matchLevel = this.filterLevel === '' || level === this.filterLevel;
                        const matchYear = this.filterYear === '' || year === this.filterYear;

                        return matchSearch && matchLevel && matchYear;
                    },

                    resetFilter() {
                        this.search = '';
                        this.filterLevel = '';
                        this.filterYear = '';
                    },

                    openModal() {
                        this.showCreateModal = true;

                        if (!this.rows.length) {
                            this.generateRows();
                        }
                    },

                    generateRows() {
                        let count = parseInt(this.entryCount || 1);

                        if (count < 1) count = 1;
                        if (count > 20) count = 20;

                        this.entryCount = count;

                        this.rows = Array.from({ length: count }, () => ({
                            class_name: '',
                            level: '',
                            academic_year: '{{ date('Y') . '/' . (date('Y') + 1) }}',
                        }));
                    },

                    removeRow(index) {
                        this.rows.splice(index, 1);
                        this.entryCount = this.rows.length;
                    },
                };
            }
        </script>
    </div>
</x-app-layout>