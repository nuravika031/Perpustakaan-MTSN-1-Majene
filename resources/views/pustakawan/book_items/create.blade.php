<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Koleksi
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Tambah Eksemplar Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Buat satu atau banyak eksemplar buku dengan kode otomatis yang tetap bisa disesuaikan.
                </p>
            </div>

            <a href="{{ route('book_items.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/40 py-10"
        x-data="bookItemCreate(
            @js($booksData),
            @js(old('book_id', '')),
            @js(old('items', [])),
            @js(old('classification_code', '')),
            @js(old('author_code', '')),
            @js(old('title_code', ''))
        )"
        x-init="init()"
    >
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow-sm">
                    <div class="font-bold mb-2">Data eksemplar belum bisa disimpan:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl">
                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-700 to-teal-500 p-6 text-white">
                    <div class="absolute -right-16 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-20 bottom-0 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

                    <div class="relative flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white shadow-sm">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                                inventory_2
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold">
                                Form Tambah Eksemplar
                            </h3>
                            <p class="mt-1 text-sm text-emerald-50">
                                Pilih buku induk, sistem akan mengisi DDC, inisial penulis, inisial judul, dan nomor copy secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('book_items.store') }}" class="space-y-8 p-6 md:p-8">
                    @csrf

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
                                    Setelah memilih buku, informasi klasifikasi dan kode dasar akan otomatis terisi.
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
                                    x-model="selectedBookId"
                                    @change="handleBookChange()"
                                    required
                                    class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                                    <option value="">Pilih Judul Buku</option>

                                    @forelse($books as $book)
                                        <option value="{{ $book->id }}">
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

                    <section class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm md:p-6">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700">
                                <span class="material-symbols-outlined text-[20px]">qr_code_2</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Format Kode Otomatis
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Komponen kode otomatis dapat diedit jika perlu penyesuaian dengan label buku fisik.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-5">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    DDC Class <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="classification_code"
                                    x-model="ddcCode"
                                    required
                                    placeholder="004"
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 font-mono text-sm font-bold text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Inisial Penulis <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="author_code"
                                    x-model="authorInitial"
                                    required
                                    placeholder="Mar"
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 font-mono text-sm font-bold text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Inisial Judul <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="title_code"
                                    x-model="titleInitial"
                                    required
                                    placeholder="i"
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 font-mono text-sm font-bold text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Copy Awal
                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    x-model.number="startIndex"
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                    Copy Akhir
                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    x-model.number="endIndex"
                                    class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                >
                            </div>
                        </div>

                        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                @click="generateRows()"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-800"
                            >
                                <span class="material-symbols-outlined text-[18px]">table_rows</span>
                                Buat Eksemplar
                            </button>

                            <button
                                type="button"
                                @click="applyCodeToAllRows()"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white px-5 py-3 text-sm font-bold text-emerald-700 transition hover:bg-emerald-50"
                            >
                                <span class="material-symbols-outlined text-[18px]">sync</span>
                                Terapkan Kode
                            </button>
                        </div>

                        <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                            <p class="text-xs leading-5 text-amber-700">
                                Contoh kode:
                                <span class="font-mono font-bold" x-text="buildCode(startIndex || 1)"></span>.
                                Setiap baris tetap bisa diubah manual, termasuk status dan kondisi fisiknya.
                            </p>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm md:p-6">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <span class="material-symbols-outlined text-[20px]">fact_check</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Daftar Eksemplar yang Akan Disimpan
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Nomor copy, kode, status, dan kondisi dapat diedit per baris sebelum disimpan.
                                </p>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-3xl border border-gray-100">
                            <table class="min-w-[1000px] w-full divide-y divide-gray-100 text-left text-sm">
                                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-gray-500">
                                    <tr>
                                        <th class="w-[70px] px-4 py-3 font-bold">No</th>
                                        <th class="w-[140px] px-4 py-3 font-bold">Nomor Copy</th>
                                        <th class="px-4 py-3 font-bold">Kode Eksemplar</th>
                                        <th class="w-[180px] px-4 py-3 font-bold">Status</th>
                                        <th class="w-[210px] px-4 py-3 font-bold">Kondisi</th>
                                        <th class="w-[90px] px-4 py-3 text-center font-bold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td class="px-4 py-4 align-middle">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-xs font-bold text-emerald-700">
                                                    <span x-text="index + 1"></span>
                                                </div>
                                            </td>

                                            <td class="px-4 py-4 align-middle">
                                                <input
                                                    type="number"
                                                    min="1"
                                                    :name="`items[${index}][copy_number]`"
                                                    x-model.number="item.copy_number"
                                                    @change="regenerateRowCode(item)"
                                                    required
                                                    class="block w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                >
                                            </td>

                                            <td class="px-4 py-4 align-middle">
                                                <input
                                                    type="text"
                                                    :name="`items[${index}][item_code]`"
                                                    x-model="item.item_code"
                                                    required
                                                    class="block w-full rounded-2xl border border-gray-200 px-4 py-3 font-mono text-sm font-bold text-gray-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                >
                                            </td>

                                            <td class="px-4 py-4 align-middle">
                                                <select
                                                    :name="`items[${index}][status]`"
                                                    x-model="item.status"
                                                    required
                                                    class="block w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                >
                                                    <option value="tersedia">Tersedia</option>
                                                    <option value="dipinjam">Dipinjam</option>
                                                    <option value="rusak">Rusak</option>
                                                    <option value="hilang">Hilang</option>
                                                    <option value="nonaktif">Nonaktif</option>
                                                </select>
                                            </td>

                                            <td class="px-4 py-4 align-middle">
                                                <select
                                                    :name="`items[${index}][condition]`"
                                                    x-model="item.condition"
                                                    required
                                                    class="block w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                                >
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak ringan">Rusak Ringan</option>
                                                    <option value="rusak berat">Rusak Berat</option>
                                                    <option value="hilang">Hilang</option>
                                                </select>
                                            </td>

                                            <td class="px-4 py-4 text-center align-middle">
                                                <button
                                                    type="button"
                                                    @click="removeRow(index)"
                                                    x-show="items.length > 1"
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
                    </section>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('book_items.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800"
                        >
                            <span>Simpan Eksemplar</span>
                            <span class="material-symbols-outlined text-[18px]">save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function bookItemCreate(
                booksData,
                oldBookId,
                oldItems,
                oldClassificationCode = '',
                oldAuthorCode = '',
                oldTitleCode = ''
            ) {
                return {
                    booksData,
                    selectedBookId: oldBookId ? String(oldBookId) : '',
                    selectedBook: null,

                    ddcCode: oldClassificationCode || '',
                    authorInitial: oldAuthorCode || '',
                    titleInitial: oldTitleCode || '',

                    startIndex: 1,
                    endIndex: 1,

                    defaultStatus: 'tersedia',
                    defaultCondition: 'baik',

                    items: oldItems && oldItems.length > 0 ? oldItems.map((item, index) => ({
                        copy_number: item.copy_number || index + 1,
                        item_code: item.item_code || '',
                        status: item.status || 'tersedia',
                        condition: item.condition || 'baik',
                    })) : [],

                    init() {
                        if (this.selectedBookId) {
                            this.handleBookChange(false);
                        }

                        if (oldClassificationCode) {
                            this.ddcCode = oldClassificationCode;
                        }

                        if (oldAuthorCode) {
                            this.authorInitial = oldAuthorCode;
                        }

                        if (oldTitleCode) {
                            this.titleInitial = oldTitleCode;
                        }

                        if (this.items.length === 0) {
                            this.items = [
                                {
                                    copy_number: this.startIndex,
                                    item_code: this.buildCode(this.startIndex),
                                    status: this.defaultStatus,
                                    condition: this.defaultCondition,
                                }
                            ];
                        }
                    },

                    getBookById(id) {
                        return this.booksData.find(book => String(book.id) === String(id)) || null;
                    },

                    handleBookChange(regenerate = true) {
                        this.selectedBook = this.getBookById(this.selectedBookId);

                        if (!this.selectedBook) {
                            this.ddcCode = '';
                            this.authorInitial = '';
                            this.titleInitial = '';
                            this.startIndex = 1;
                            this.endIndex = 1;
                            return;
                        }

                        this.ddcCode = this.selectedBook.ddc_code || '';
                        this.authorInitial = this.selectedBook.author_initial || '';
                        this.titleInitial = this.selectedBook.title_initial || '';

                        this.startIndex = this.selectedBook.next_index || 1;
                        this.endIndex = this.selectedBook.next_index || 1;

                        if (regenerate) {
                            this.generateRows();
                        }
                    },

                    padNumber(number) {
                        return String(parseInt(number || 1)).padStart(3, '0');
                    },

                    buildCode(copyNumber) {
                        const ddc = this.ddcCode || '000';
                        const author = this.authorInitial || 'Pen';
                        const title = this.titleInitial || 'b';

                        return `${ddc}-${author}-${title}-${this.padNumber(copyNumber)}`;
                    },

                    generateRows() {
                        let start = parseInt(this.startIndex || 1);
                        let end = parseInt(this.endIndex || start);

                        if (start < 1) {
                            start = 1;
                        }

                        if (end < start) {
                            end = start;
                        }

                        const total = end - start + 1;

                        if (total > 200) {
                            end = start + 199;
                            this.endIndex = end;
                        }

                        this.startIndex = start;
                        this.endIndex = end;

                        this.items = [];

                        for (let i = start; i <= end; i++) {
                            this.items.push({
                                copy_number: i,
                                item_code: this.buildCode(i),
                                status: this.defaultStatus,
                                condition: this.defaultCondition,
                            });
                        }
                    },

                    regenerateRowCode(item) {
                        item.item_code = this.buildCode(item.copy_number);
                    },

                    applyCodeToAllRows() {
                        this.items = this.items.map(item => ({
                            ...item,
                            item_code: this.buildCode(item.copy_number),
                        }));
                    },

                    removeRow(index) {
                        this.items.splice(index, 1);
                    },
                };
            }
        </script>
    </div>
</x-app-layout>