<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Manajemen Kelas</h2>
                <p class="mt-1 text-sm text-gray-500">Daftar kelas aktif untuk pengelompokan anggota perpustakaan.</p>
            </div>
            <a href="{{ route('classes.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-colors">
                Tambah Kelas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm border border-emerald-100">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6">
                    <h3 class="text-white text-lg font-semibold">Database Kelas</h3>
                    <p class="text-emerald-100 mt-1 text-sm">Kelola data tingkat dan tahun ajaran kelas.</p>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto rounded-3xl border border-emerald-100 bg-emerald-50 p-4">
                        <table class="min-w-full divide-y divide-emerald-200 text-left text-sm">
                            <thead class="rounded-3xl bg-white text-xs uppercase tracking-wider text-emerald-700">
                                <tr>
                                    <th class="px-6 py-3">Nama Kelas</th>
                                    <th class="px-6 py-3 text-center">Tingkat</th>
                                    <th class="px-6 py-3">Tahun Ajaran</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-100 bg-white">
                                @forelse($classes as $class)
                                    <tr class="hover:bg-emerald-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $class->class_name }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 bg-white border border-emerald-100 rounded-lg text-emerald-700 font-bold">
                                                {{ $class->level }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700">{{ $class->academic_year }}</td>
                                        <td class="px-6 py-4 text-center space-x-3">
    <a href="{{ route('classes.edit', $class->id) }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">
        Edit
    </a>
    
    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kelas ini? Anggota di kelas ini mungkin akan kehilangan referensi kelasnya.');">
        @csrf @method('DELETE')
        <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition-colors">Hapus</button>
    </form>
</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Data kelas masih kosong.</td>
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