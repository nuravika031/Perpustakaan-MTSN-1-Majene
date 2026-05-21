<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-emerald-800 leading-tight">Master Data Kelas DDC</h2>
                <p class="text-sm text-gray-500 mt-1">Standar klasifikasi internasional untuk menentukan posisi buku di rak.</p>
            </div>
            </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold w-24">Kode</th>
                                <th class="px-6 py-4 font-semibold w-1/4">Nama Klasifikasi</th>
                                <th class="px-6 py-4 font-semibold">Deskripsi / Ruang Lingkup</th>
                                <th class="px-6 py-4 font-semibold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($ddcClasses as $ddc)
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl bg-gray-100 text-gray-800 font-bold font-mono text-sm border border-gray-200">
                                            {{ $ddc->code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-emerald-800">{{ $ddc->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $ddc->description ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('ddc.edit', $ddc->id) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-semibold text-sm transition-colors bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-xl">
                                            <span class="material-symbols-outlined text-[16px]">edit</span> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>