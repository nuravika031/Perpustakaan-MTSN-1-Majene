<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Anggota
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Detail Anggota
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Lihat informasi lengkap anggota perpustakaan.
                </p>
            </div>

            <a href="{{ route('members.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-white px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    <div
        class="py-10 bg-gradient-to-br from-slate-50 via-emerald-50/40 to-sky-50/40 min-h-screen"
        x-data="{ showCardModal: false }"
        @keydown.escape.window="showCardModal = false"
    >
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
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
                                    account_circle
                                </span>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-50">
                                    Informasi Anggota
                                </p>
                                <h3 class="mt-2 max-w-2xl text-2xl font-bold leading-snug text-white">
                                    {{ $member->name }}
                                </h3>
                                <p class="mt-2 text-sm text-emerald-50">
                                    Kode Anggota:
                                    <span class="font-mono font-bold">{{ $member->member_code }}</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            @if($member->status === 'aktif')
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-2 text-sm font-bold text-white">
                                    <span class="material-symbols-outlined text-[18px]">block</span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-8">

                    <section class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5 md:p-6">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <span class="material-symbols-outlined text-[20px]">badge</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Identitas Anggota
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Data utama anggota yang digunakan pada proses peminjaman.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Kode Anggota
                                </p>
                                <p class="mt-2 font-mono text-sm font-bold text-gray-900">
                                    {{ $member->member_code }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    NIS / NIP
                                </p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">
                                    {{ $member->nis_nip }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    Nama Lengkap
                                </p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">
                                    {{ $member->name }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-white/70 bg-white p-5 shadow-sm">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-emerald-700">
                                    No. HP / WhatsApp
                                </p>
                                <p class="mt-2 text-sm font-semibold text-gray-900">
                                    {{ $member->phone ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-100 text-teal-700">
                                <span class="material-symbols-outlined text-[20px]">groups</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Informasi Keanggotaan
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Jenis anggota, kelas, jenis kelamin, dan status keanggotaan.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Jenis Anggota
                                </p>
                                <p class="mt-2 text-sm font-bold capitalize text-gray-900">
                                    {{ $member->member_type }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Jenis Kelamin
                                </p>
                                <p class="mt-2 text-sm font-bold capitalize text-gray-900">
                                    {{ $member->gender }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Kelas
                                </p>
                                <p class="mt-2 text-sm font-bold text-gray-900">
                                    {{ $member->studentClass->class_name ?? 'Guru/Staff' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-500">
                                    Status
                                </p>

                                <div class="mt-3">
                                    @if($member->status === 'aktif')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-bold text-gray-600">
                                            <span class="material-symbols-outlined text-[14px]">block</span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                        <div class="mb-5 flex items-start gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <span class="material-symbols-outlined text-[20px]">badge</span>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900">
                                    Kartu Anggota / Identitas
                                </h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    Kartu anggota dapat dilihat dalam pop up jika sudah diunggah.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-sm">
                                        <span class="material-symbols-outlined">image</span>
                                    </div>

                                    <div>
                                        <p class="text-sm font-bold text-gray-900">
                                            File Kartu Anggota
                                        </p>

                                        @if($member->card_image)
                                            <p class="mt-1 text-xs text-gray-500">
                                                Kartu anggota sudah tersedia dan dapat ditampilkan.
                                            </p>
                                        @else
                                            <p class="mt-1 text-xs text-gray-500">
                                                Belum ada kartu anggota yang diunggah.
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                @if($member->card_image)
                                    <button
                                        type="button"
                                        @click="showCardModal = true"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        Lihat Kartu
                                    </button>
                                @else
                                    <span class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-400">
                                        <span class="material-symbols-outlined text-[18px]">hide_image</span>
                                        Tidak Ada Kartu
                                    </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('members.edit', $member) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Edit Anggota
                        </a>

                        <form method="POST"
                              action="{{ route('members.destroy', $member) }}"
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-red-200 bg-white px-6 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50 sm:w-auto">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                Hapus Anggota
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($member->card_image)
            <div
                x-show="showCardModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6"
            >
                <div
                    class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"
                    @click="showCardModal = false"
                ></div>

                <div
                    x-show="showCardModal"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-3"
                    class="relative z-10 w-full max-w-3xl overflow-hidden rounded-[2rem] border border-white/70 bg-white shadow-2xl"
                >
                    <div class="flex items-center justify-between border-b border-gray-100 bg-gradient-to-r from-emerald-700 to-teal-500 px-6 py-5 text-white">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-50">
                                Kartu Anggota
                            </p>
                            <h3 class="mt-1 text-lg font-bold">
                                {{ $member->name }}
                            </h3>
                            <p class="mt-1 text-xs text-emerald-50">
                                {{ $member->member_code }} • {{ $member->nis_nip }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="showCardModal = false"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/25"
                        >
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>

                    <div class="bg-slate-50 p-5 md:p-6">
                        <div class="rounded-3xl border border-gray-100 bg-white p-4 shadow-sm">
                            <img
                                src="{{ asset('storage/' . $member->card_image) }}"
                                alt="Kartu Anggota {{ $member->name }}"
                                class="mx-auto max-h-[70vh] w-full rounded-2xl object-contain"
                            >
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button
                                type="button"
                                @click="showCardModal = false"
                                class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-600 transition hover:bg-gray-50"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
</x-app-layout>