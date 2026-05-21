<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-blue-800 leading-tight">Kelola Akun Staf (Sistem)</h2>
                <p class="text-sm text-gray-500 mt-1">Hanya Orang IT yang dapat menambah, melihat, atau menghapus akses pengguna sistem.</p>
            </div>
            <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-full shadow-md transition-colors flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                Buat Akun Staf
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined">error</span>
                    <p class="font-medium text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Nama Pengguna</th>
                                <th class="px-6 py-4 font-semibold">Alamat Email</th>
                                <th class="px-6 py-4 font-semibold">Peran (Role)</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->role_id == 1)
                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Pustakawan</span>
                                        @elseif($user->role_id == 2)
                                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-bold">Kepala Sekolah</span>
                                        @elseif($user->role_id == 3)
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">IT Admin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akses akun ini secara permanen?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">Cabut Akses (Hapus)</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Akun Anda</span>
                                        @endif
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