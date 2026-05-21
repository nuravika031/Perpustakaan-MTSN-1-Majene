<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">Tambah Kelas Baru</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 p-5 border border-red-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        <h3 class="text-sm font-bold text-red-800">Gagal menyimpan data kelas!</h3>
                    </div>
                    <ul class="mt-2 ml-8 list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-3xl border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-white text-center">
                    <h3 class="font-bold text-lg">Input Kelas Baru</h3>
                </div>
                
                <form method="POST" action="{{ route('classes.store') }}" class="p-8 space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nama Kelas</label>
                        <input name="class_name" type="text" value="{{ old('class_name') }}" placeholder="Contoh: VII-C" required 
                            class="mt-2 block w-full rounded-2xl border-emerald-200 bg-emerald-50 px-4 py-3 focus:ring-emerald-500 transition-all {{ $errors->has('class_name') ? 'border-red-400 focus:ring-red-500' : '' }}" />
                        
                        @error('class_name')
                            <p class="mt-2 text-sm text-red-600 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">warning</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Tingkat (Level)</label>
                            <select name="level" required class="mt-2 block w-full rounded-2xl border-emerald-200 bg-emerald-50 px-4 py-3 focus:ring-emerald-500 transition-all">
                                <option value="7" {{ old('level') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ old('level') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ old('level') == '9' ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Tahun Ajaran</label>
                            <input name="academic_year" type="text" value="{{ old('academic_year', '2025/2026') }}" required class="mt-2 block w-full rounded-2xl border-emerald-200 bg-emerald-50 px-4 py-3 focus:ring-emerald-500 transition-all" />
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 text-sm">
                        <a href="{{ route('members.create') }}" class="px-6 py-3 font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                        <button type="submit" class="bg-emerald-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-700 transition-all">Simpan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>