@php
    $classesData = $classes->groupBy('level')->map(function ($group) {
        return $group->map(function ($class) {
            return [
                'id' => $class->id,
                'class_name' => $class->class_name,
                'level' => $class->level,
                'academic_year' => $class->academic_year,
            ];
        })->values();
    });

    $currentLevel = old('level_selector', $member->studentClass->level ?? '');
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Manajemen Anggota
                </p>
                <h2 class="mt-1 text-xl font-bold text-gray-900">
                    Edit Anggota
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Perbarui informasi anggota sesuai data terbaru.
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
        x-data="memberEditForm()"
    >
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
                                    manage_accounts
                                </span>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold">
                                    Form Ubah Anggota
                                </h3>
                                <p class="mt-1 text-sm text-emerald-50">
                                    Edit profil anggota agar data perpustakaan tetap akurat.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/20 bg-white/15 px-4 py-3">
                            <p class="text-xs text-emerald-50">Anggota Saat Ini</p>
                            <p class="mt-1 max-w-[260px] truncate text-sm font-bold text-white">
                                {{ $member->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('members.update', $member) }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

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
                                        Perbarui kode anggota, nomor identitas, dan nama lengkap.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="member_code" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Kode Anggota <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="member_code"
                                        name="member_code"
                                        type="text"
                                        value="{{ old('member_code', $member->member_code) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >

                                    @error('member_code')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nis_nip" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        NIS / NIP <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="nis_nip"
                                        name="nis_nip"
                                        type="text"
                                        value="{{ old('nis_nip', $member->nis_nip) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >

                                    @error('nis_nip')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name', $member->name) }}"
                                        required
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >

                                    @error('name')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        No. HP / WhatsApp
                                    </label>

                                    <input
                                        id="phone"
                                        name="phone"
                                        type="text"
                                        value="{{ old('phone', $member->phone) }}"
                                        placeholder="Contoh: 08123456789"
                                        class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                    >

                                    @error('phone')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
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
                                        Jenis Anggota
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Tentukan jenis anggota dan jenis kelamin.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="member_type" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Jenis Anggota <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="member_type"
                                            name="member_type"
                                            x-model="memberType"
                                            @change="handleMemberTypeChange()"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Jenis Anggota</option>
                                            <option value="siswa">Siswa</option>
                                            <option value="guru">Guru</option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('member_type')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="gender" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="gender"
                                            name="gender"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" {{ old('gender', $member->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('gender', $member->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('gender')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section
                            x-show="memberType === 'siswa'"
                            x-transition
                            class="rounded-3xl border border-emerald-100 bg-emerald-50/50 p-5 md:p-6"
                            style="display: none;"
                        >
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <span class="material-symbols-outlined text-[20px]">school</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Data Kelas Siswa
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Bagian ini hanya berlaku untuk anggota siswa.
                                    </p>
                                </div>
                            </div>

                            <input type="hidden" name="level_selector" :value="selectedLevel">

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="level_selector" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Tingkat Kelas
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="level_selector"
                                            x-model="selectedLevel"
                                            @change="selectedClassId = ''"
                                            :required="memberType === 'siswa'"
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="">Pilih Tingkat</option>
                                            <template x-for="(group, level) in classesData" :key="level">
                                                <option :value="level" x-text="'Kelas ' + level"></option>
                                            </template>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label for="student_class_id" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Kelas
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="student_class_id"
                                            name="student_class_id"
                                            x-model="selectedClassId"
                                            :disabled="!selectedLevel"
                                            :required="memberType === 'siswa'"
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400"
                                        >
                                            <option value="">Pilih Kelas</option>
                                            <template x-for="cls in filteredClasses" :key="cls.id">
                                                <option :value="String(cls.id)" x-text="cls.class_name + ' - ' + cls.academic_year"></option>
                                            </template>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('student_class_id')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl border border-gray-100 bg-white p-5 md:p-6 shadow-sm">
                            <div class="mb-5 flex items-start gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                    <span class="material-symbols-outlined text-[20px]">settings</span>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-900">
                                        Status dan Kartu Anggota
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Tentukan status keanggotaan dan upload file baru jika ingin mengganti kartu anggota.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label for="status" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Status Keanggotaan <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative mt-2">
                                        <select
                                            id="status"
                                            name="status"
                                            required
                                            class="block w-full appearance-none rounded-2xl border border-emerald-200 bg-emerald-50/60 px-4 py-3 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                                        >
                                            <option value="aktif" {{ old('status', $member->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ old('status', $member->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>

                                        <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                            expand_more
                                        </span>
                                    </div>

                                    @error('status')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div
                                    x-data="{
                                        isDragging: false,
                                        fileName: '',
                                        previewUrl: '',

                                        handleFileSelect(event) {
                                            const file = event.target.files[0];

                                            if (!file) {
                                                return;
                                            }

                                            this.fileName = file.name;
                                            this.previewUrl = URL.createObjectURL(file);
                                        },

                                        handleDrop(event) {
                                            this.isDragging = false;

                                            const file = event.dataTransfer.files[0];

                                            if (!file) {
                                                return;
                                            }

                                            this.$refs.cardInput.files = event.dataTransfer.files;
                                            this.fileName = file.name;
                                            this.previewUrl = URL.createObjectURL(file);
                                        }
                                    }"
                                    class="md:col-span-2"
                                >
                                    <label for="card_image" class="block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">
                                        Upload Kartu Anggota / Identitas
                                    </label>

                                    @if($member->card_image)
                                        <div class="mt-2 rounded-3xl border border-emerald-100 bg-emerald-50/60 p-4">
                                            <p class="mb-3 text-xs font-bold uppercase tracking-[0.12em] text-emerald-700">
                                                Kartu Saat Ini
                                            </p>

                                            <img
                                                src="{{ asset('storage/' . $member->card_image) }}"
                                                alt="Kartu Anggota"
                                                class="max-h-56 rounded-2xl border border-white bg-white object-contain shadow-sm"
                                            >

                                            <p class="mt-3 text-xs text-gray-500">
                                                Upload file baru hanya jika ingin mengganti kartu anggota.
                                            </p>
                                        </div>
                                    @endif

                                    <div
                                        class="mt-4 cursor-pointer rounded-3xl border-2 border-dashed p-6 text-center transition"
                                        :class="isDragging ? 'border-emerald-500 bg-emerald-50' : 'border-emerald-200 bg-white'"
                                        @click="$refs.cardInput.click()"
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                    >
                                        <input
                                            x-ref="cardInput"
                                            id="card_image"
                                            name="card_image"
                                            type="file"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                            class="hidden"
                                            @change="handleFileSelect($event)"
                                        >

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                            <span class="material-symbols-outlined text-[32px]">cloud_upload</span>
                                        </div>

                                        <p class="mt-4 text-sm font-bold text-gray-900">
                                            Drag & drop kartu anggota di sini
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            atau klik area ini untuk memilih file baru.
                                        </p>

                                        <p class="mt-3 text-xs text-gray-400">
                                            Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                        </p>

                                        <template x-if="fileName">
                                            <div class="mt-5 rounded-2xl border border-emerald-100 bg-emerald-50 p-3 text-left">
                                                <p class="text-xs font-bold uppercase tracking-[0.12em] text-emerald-700">
                                                    File Baru Dipilih
                                                </p>
                                                <p class="mt-1 text-sm font-semibold text-gray-800" x-text="fileName"></p>
                                            </div>
                                        </template>

                                        <template x-if="previewUrl">
                                            <div class="mt-5 rounded-2xl border border-gray-100 bg-white p-3">
                                                <img
                                                    :src="previewUrl"
                                                    class="mx-auto max-h-56 rounded-xl object-contain"
                                                    alt="Preview kartu anggota"
                                                >
                                            </div>
                                        </template>
                                    </div>

                                    @error('card_image')
                                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('members.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                                <span>Perbarui Anggota</span>
                                <span class="material-symbols-outlined text-[18px]">save</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            function memberEditForm() {
                return {
                    memberType: @js(old('member_type', $member->member_type)),
                    selectedLevel: @js($currentLevel),
                    selectedClassId: @js((string) old('student_class_id', $member->student_class_id ?? '')),
                    classesData: @js($classesData),

                    get filteredClasses() {
                        if (!this.selectedLevel || !this.classesData[this.selectedLevel]) {
                            return [];
                        }

                        return this.classesData[this.selectedLevel];
                    },

                    handleMemberTypeChange() {
                        if (this.memberType === 'guru') {
                            this.selectedLevel = '';
                            this.selectedClassId = '';
                        }
                    },
                };
            }
        </script>
    </div>
</x-app-layout>