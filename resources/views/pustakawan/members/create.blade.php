<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Tambah Anggota Baru</h2>
                <p class="mt-1 text-sm text-gray-500">Masukkan data anggota untuk menambah koleksi pengguna perpustakaan.</p>
            </div>
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-white border border-emerald-200 text-emerald-700 rounded-full shadow-sm hover:bg-emerald-50 transition-colors font-semibold">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-3xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-white">
                    <h3 class="text-lg font-semibold">Form Tambah Anggota</h3>
                    <p class="text-emerald-100 text-sm mt-1">Pastikan semua data terisi sesuai dengan dokumen identitas resmi.</p>
                </div>
                
                <div class="p-8">
                    <form method="POST" action="{{ route('members.store') }}" class="space-y-6"
                          x-data="{ 
                              memberType: '{{ old('member_type', '') }}',
                              selectedLevel: '{{ old('level_selector', '') }}',
                              classesData: {{ $classes->groupBy('level')->toJson() }},
                              
                              // Fungsi untuk mereset pilihan rombel jika tingkat diubah
                              resetClass() {
                                  document.getElementById('student_class_id').value = '';
                              }
                          }">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="nis_nip" class="block text-sm font-semibold text-gray-700">NIS / NIP</label>
                                <input id="nis_nip" name="nis_nip" type="text" value="{{ old('nis_nip') }}" required placeholder="Masukkan nomor identitas..." class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all" />
                                @error('nis_nip')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="Nama sesuai identitas..." class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all" />
                                @error('name')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="member_type" class="block text-sm font-semibold text-gray-700">Siswa/Guru</label>
                                <div class="relative mt-2">
                                    <select id="member_type" name="member_type" x-model="memberType" @change="if(memberType === 'guru') { selectedLevel = ''; document.getElementById('student_class_id').value = ''; }" required class="appearance-none block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 pr-10 text-gray-900 shadow-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="siswa">Siswa</option>
                                        <option value="guru">Guru</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('member_type')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                                <div class="relative mt-2">
                                    <select id="gender" name="gender" required class="appearance-none block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 pr-10 text-gray-900 shadow-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('gender')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700">No. HP / WhatsApp (Opsional)</label>
                                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="mt-2 block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all" />
                                @error('phone')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700">Status Keanggotaan</label>
                                <div class="relative mt-2">
                                    <select id="status" name="status" required class="appearance-none block w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 pr-10 text-gray-900 shadow-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all">
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('status')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2 rounded-2xl bg-emerald-50/50 p-5 border border-emerald-100" 
                             x-show="memberType === 'siswa'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             style="display: none;">
                            
                            <div>
                                <label for="level_selector" class="block text-sm font-semibold text-gray-700">Tingkat Kelas</label>
                                <div class="relative mt-2">
                                    <input type="hidden" name="level_selector" :value="selectedLevel">
                                    
                                    <select id="level_selector" x-model="selectedLevel" @change="resetClass()" class="appearance-none block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-gray-900 shadow-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all">
                                        <option value="">-- Pilih Tingkat --</option>
                                        <template x-for="(group, level) in classesData" :key="level">
                                            <option :value="level" x-text="'Kelas ' + level"></option>
                                        </template>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="student_class_id" class="block text-sm font-semibold text-gray-700">Jenis Kelas</label>
                                <div class="relative mt-2">
                                    <select id="student_class_id" name="student_class_id" :disabled="!selectedLevel" class="appearance-none block w-full rounded-2xl border border-emerald-200 bg-white px-4 py-3 pr-10 text-gray-900 shadow-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all disabled:opacity-50 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                        <option value="">-- Pilih Rombel --</option>
                                        <template x-if="selectedLevel && classesData[selectedLevel]">
                                            <template x-for="cls in classesData[selectedLevel]" :key="cls.id">
                                                <option :value="cls.id" x-text="cls.class_name" :selected="cls.id == '{{ old('student_class_id') }}'"></option>
                                            </template>
                                        </template>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-emerald-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('student_class_id')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-emerald-50 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('members.index') }}" class="inline-flex justify-center rounded-full border border-emerald-200 bg-white px-8 py-3 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition-colors">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-8 py-3 text-sm font-semibold text-white shadow-lg hover:bg-emerald-700 transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                <span>Simpan Anggota</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>