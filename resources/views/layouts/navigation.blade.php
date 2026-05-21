<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-emerald-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                        <x-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')">
                            {{ __('Sirkulasi') }}
                        </x-nav-link>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out h-16 {{ request()->routeIs('books.*', 'book_items.*', 'categories.*', 'ddc.*') ? 'border-emerald-500 text-gray-900 focus:border-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                                        <div>Koleksi Buku</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('books.index')">{{ __('Judul Buku') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('book_items.index')">{{ __('Stok Fisik Buku') }}</x-dropdown-link>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <x-dropdown-link :href="route('categories.index')" class="text-gray-500">{{ __('Pengaturan Kategori') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('ddc.index')" class="text-gray-500">{{ __('Pengaturan Klasifikasi (DDC)') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out h-16 {{ request()->routeIs('members.*', 'classes.*') ? 'border-emerald-500 text-gray-900 focus:border-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                                        <div>Pengguna</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('members.index')">{{ __('Daftar Anggota') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('classes.index')">{{ __('Pengaturan Kelas') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    @if(Auth::user()->role_id == 3)
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out h-16 {{ request()->routeIs('users.*') ? 'border-blue-500 text-gray-900 focus:border-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                                        <div>Manajemen IT</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('users.index')">{{ __('Kelola Akun Staf') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                <x-responsive-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')">
                    {{ __('Sirkulasi') }}
                </x-responsive-nav-link>
                
                <div class="px-4 py-2 mt-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Koleksi Buku</div>
                <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')" class="pl-8 border-l-2">{{ __('Judul Buku') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('book_items.index')" :active="request()->routeIs('book_items.*')" class="pl-8 border-l-2">{{ __('Stok Fisik Buku') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="pl-8 border-l-2 text-gray-500">{{ __('Pengaturan Kategori') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ddc.index')" :active="request()->routeIs('ddc.*')" class="pl-8 border-l-2 text-gray-500">{{ __('Pengaturan Klasifikasi (DDC)') }}</x-responsive-nav-link>

                <div class="px-4 py-2 mt-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</div>
                <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')" class="pl-8 border-l-2">{{ __('Daftar Anggota') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')" class="pl-8 border-l-2 text-gray-500">{{ __('Pengaturan Kelas') }}</x-responsive-nav-link>
            @endif

            @if(Auth::user()->role_id == 3)
                <div class="px-4 py-2 mt-2 text-xs font-semibold text-blue-500 uppercase tracking-wider">Manajemen IT</div>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="pl-8 border-l-2 border-blue-500 text-blue-600">
                    {{ __('Kelola Akun Staf') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>