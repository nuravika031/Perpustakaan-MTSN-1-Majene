<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-emerald-800 leading-tight">
            {{ __('Form Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        {{-- Logika Pilihan & Pencarian Anggota --}}
        searchMember: '',
        selectedMemberId: '{{ old('member_id', '') }}',
        selectedMemberText: '',
        showMemberDropdown: false,
        membersList: {{ $members->map(function($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'nis_nip' => $m->nis_nip,
                'class' => $m->studentClass ? $m->studentClass->class_name : 'Guru/Staff'
            ];
        })->toJson() }},

        {{-- Logika Pop-up Modal Anggota Baru --}}
        showModal: false,
        newNisNip: '',
        newName: '',
        newGender: '',
        newMemberType: '',
        newClassId: '',
        classesData: {{ $classes->toJson() }},
        modalErrorMessage: '',

        {{-- Fungsi Filter Pencarian: Murni muncul jika diketik, dibatasi maksimal 7 baris --}}
        get filteredMembers() {
            if (this.searchMember.trim() === '') return [];
            return this.membersList.filter(m => 
                m.name.toLowerCase().includes(this.searchMember.toLowerCase()) || 
                m.nis_nip.toLowerCase().includes(this.searchMember.toLowerCase())
            ).slice(0, 7);
        },

        {{-- Fungsi Pilih Anggota --}}
        selectMember(member) {
            this.selectedMemberId = member.id;
            this.selectedMemberText = `${member.nis_nip} - ${member.name} (${member.class})`;
            this.searchMember = '';
            this.showMemberDropdown = false;
        },

        {{-- Fungsi Kirim Data Anggota Kilat Lewat AJAX --}}
        async submitQuickMember() {
            this.modalErrorMessage = '';
            
            if(!this.newNisNip || !this.newName || !this.newGender || !this.newMemberType) {
                this.modalErrorMessage = 'Mohon lengkapi kolom wajib (*).';
                return;
            }
            if(this.newMemberType === 'siswa' && !this.newClassId) {
                this.modalErrorMessage = 'Siswa wajib memilih kelas.';
                return;
            }

            try {
                let response = await fetch('{{ route('members.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nis_nip: this.newNisNip,
                        name: this.newName,
                        gender: this.newGender,
                        member_type: this.newMemberType,
                        student_class_id: this.newClassId,
                        status: 'aktif'
                    })
                });

                let result = await response.json();

                if (response.ok && result.success) {
                    let newAddedMember = {
                        id: result.member.id,
                        name: result.member.name,
                        nis_nip: result.member.nis_nip,
                        class: result.class_name
                    };
                    this.membersList.push(newAddedMember);
                    this.selectMember(newAddedMember);

                    {{-- Reset Form Modal & Tutup --}}
                    this.newNisNip = ''; this.newName = ''; this.newGender = ''; this.newMemberType = ''; this.newClassId = '';
                    this.showModal = false;
                } else {
                    if (result.errors && result.errors.nis_nip) {
                        this.modalErrorMessage = 'Gagal: NIS / NIP ini sudah terdaftar di sistem!';
                    } else {
                        this.modalErrorMessage = result.message || 'Gagal menyimpan data anggota.';
                    }
                }
            } catch (error) {
                this.modalErrorMessage = 'Sistem mendeteksi galat respon. Periksa koneksi atau refresh halaman.';
            }
        }
    }">
        
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-emerald-100">
                
                <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-500 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add_shopping_cart</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Input Transaksi Sirkulasi</h3>
                            <p class="text-xs text-emerald-100">Validasi peminjaman buku perpustakaan secara terintegrasi</p>
                        </div>
                    </div>
                    <a href="{{ route('loans.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-full text-xs font-semibold transition-colors">
                        « Kembali
                    </a>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('loans.store') }}" class="space-y-8">
                        @csrf

                        <div class="space-y-3 relative">
                            <label class="flex items-center justify-between font-bold text-gray-700 text-sm">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">person</span>
                                    Pilih Anggota / Siswa
                                </span>
                                <button type="button" @click="showModal = true" class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-xl flex items-center gap-1 hover:bg-emerald-100 transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">person_add</span>
                                    Anggota Baru? (Daftar Kilat)
                                </button>
                            </label>

                            <input type="hidden" name="member_id" :value="selectedMemberId" required>

                            <div x-show="selectedMemberId" class="flex items-center justify-between p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-900 font-semibold text-sm">
                                <span x-text="selectedMemberText"></span>
                                <button type="button" @click="selectedMemberId = ''; selectedMemberText = ''; searchMember = '';" class="text-red-500 hover:text-red-700 font-bold text-xs bg-white w-6 h-6 rounded-full flex items-center justify-center shadow-sm">✕</button>
                            </div>

                            <div x-show="!selectedMemberId" class="relative" @click.away="showMemberDropdown = false">
                                <input type="text" 
                                       x-model="searchMember" 
                                       @focus="showMemberDropdown = true"
                                       @input="showMemberDropdown = true"
                                       placeholder="Ketik Nama atau Nomor NIS / NIP untuk mencari..." 
                                       class="w-full rounded-2xl border border-emerald-200 bg-emerald-50/50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all">
                                
                                <div x-show="showMemberDropdown && filteredMembers.length > 0" 
                                     class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl max-h-60 overflow-y-auto divide-y divide-gray-50"
                                     x-transition>
                                    <template x-for="member in filteredMembers" :key="member.id">
                                        <button type="button" 
                                                @click="selectMember(member)" 
                                                class="w-full text-left px-5 py-3 text-sm hover:bg-emerald-50/70 transition-colors flex justify-between items-center">
                                            <div>
                                                <span class="font-bold text-gray-900" x-text="member.name"></span>
                                                <p class="text-xs text-gray-500 mt-0.5" x-text="'ID/NIS: ' + member.nis_nip"></p>
                                            </div>
                                            <span class="text-xs font-bold px-2.5 py-1 bg-gray-100 rounded-lg text-gray-600" x-text="member.class"></span>
                                        </button>
                                    </template>
                                </div>

                                <div x-show="showMemberDropdown && searchMember.length > 0 && filteredMembers.length === 0" class="absolute z-50 w-full mt-2 bg-white border p-4 text-center text-sm text-gray-500 rounded-2xl shadow-xl">
                                    Anggota tidak ditemukan. Silakan klik tombol <strong class="text-emerald-700">Daftar Kilat</strong> di atas.
                                </div>
                            </div>
                            @error('member_id')<p class="text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                        </div>

                        <hr class="border-gray-100">

                        <div class="space-y-4">
                            <label class="flex items-center gap-2 font-bold text-gray-700 text-sm">
                                <span class="material-symbols-outlined text-emerald-600">menu_book</span>
                                Pilih Buku yang Dipinjam (Maksimal 3)
                            </label>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <select name="book_item_ids[]" required class="w-full rounded-2xl border-emerald-200 bg-emerald-50/50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                                    <option value="">-- Pilih Buku 1 (Wajib) --</option>
                                    @foreach($bookItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_code }} - {{ $item->book->title }} ({{ $item->condition }})</option>
                                    @endforeach
                                </select>

                                <select name="book_item_ids[]" class="w-full rounded-2xl border-emerald-200 bg-emerald-50/50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                                    <option value="">-- Pilih Buku 2 (Opsional) --</option>
                                    @foreach($bookItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_code }} - {{ $item->book->title }}</option>
                                    @endforeach
                                </select>

                                <select name="book_item_ids[]" class="w-full rounded-2xl border-emerald-200 bg-emerald-50/50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                                    <option value="">-- Pilih Buku 3 (Opsional) --</option>
                                    @foreach($bookItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->item_code }} - {{ $item->book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-600">Tanggal Pinjam</label>
                                <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" readonly 
                                       class="w-full bg-gray-50 border-gray-200 rounded-2xl text-gray-500 text-sm px-4 py-3 cursor-not-allowed focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-emerald-700">Batas Waktu Pengembalian</label>
                                <input type="date" name="due_date" 
                                       value="{{ old('due_date', date('Y-m-d', strtotime('+3 days'))) }}" 
                                       min="{{ date('Y-m-d') }}" required 
                                       class="w-full bg-emerald-50 border-emerald-300 rounded-2xl text-emerald-800 font-bold text-sm px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all cursor-pointer shadow-sm">
                                @error('due_date')<p class="text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-4 px-6 rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 flex items-center justify-center gap-2 text-sm">
                                <span>Proses Validasi Transaksi</span>
                                <span class="material-symbols-outlined text-[18px]">send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showModal" 
             class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             style="display: none;">
            
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs" @click="showModal = false"></div>

            <div class="relative w-full max-w-lg p-4 mx-auto bg-white rounded-3xl shadow-2xl border border-gray-100 z-50"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                <div class="p-6 space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-emerald-600">person_add</span>
                            Registrasi Anggota Kilat
                        </h3>
                        <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
                    </div>

                    <div x-show="modalErrorMessage" class="p-3 bg-red-50 text-red-700 text-xs rounded-xl border border-red-100 font-medium" x-text="modalErrorMessage" x-transition></div>

                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="block font-semibold text-gray-700">NIS / NIP *</label>
                            <input type="text" x-model="newNisNip" placeholder="Masukkan nomor identitas unik..." class="mt-1.5 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5">
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700">Nama Lengkap *</label>
                            <input type="text" x-model="newName" placeholder="Nama lengkap sesuai berkas..." class="mt-1.5 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-700">Jenis Kelamin *</label>
                                <select x-model="newGender" class="mt-1.5 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5">
                                    <option value="">-- Pilih --</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-semibold text-gray-700">Tipe Anggota *</label>
                                <select x-model="newMemberType" @change="if(newMemberType === 'guru') newClassId = ''" class="mt-1.5 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5">
                                    <option value="">-- Pilih --</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                </select>
                            </div>
                        </div>

                        <div x-show="newMemberType === 'siswa'" x-transition>
                            <label class="block font-semibold text-gray-700">Kelas Siswa *</label>
                            <select x-model="newClassId" class="mt-1.5 block w-full rounded-xl border-emerald-200 bg-emerald-50/50 px-4 py-2.5">
                                <option value="">-- Pilih Kelas --</option>
                                <template x-for="cls in classesData" :key="cls.id">
                                    <option :value="cls.id" x-text="cls.class_name + ' (' + cls.academic_year + ')'"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 text-xs">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-full font-semibold text-gray-500 hover:text-gray-700">Batal</button>
                        <button type="button" @click="submitQuickMember()" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full font-bold shadow-md shadow-emerald-50 transition-colors">Daftarkan Anggota</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>