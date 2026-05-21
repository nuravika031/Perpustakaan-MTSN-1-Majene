<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - SIM Perpustakaan MTsN 1 Majene</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body class="min-h-screen bg-slate-100">

    @php
        $schoolLogo = asset('images/Logo-Header-Web-Sekolah.png');
    @endphp

    <div class="min-h-screen flex items-center justify-center px-4 py-10 bg-gradient-to-br from-slate-100 via-emerald-50/40 to-sky-50/30">
        <div class="w-full max-w-md">

            <div class="overflow-hidden rounded-[28px] border border-emerald-100 bg-white shadow-[0_20px_50px_rgba(15,23,42,0.08)]">

                {{-- Header --}}
                <div class="border-b border-emerald-100 bg-gradient-to-r from-emerald-600 to-teal-500 px-8 py-8 text-center text-white">
                    <div class="mx-auto flex h-35 w-35 items-center justify-center rounded-3xl bg-white/15 p-4 backdrop-blur-sm">
                        <img
                            src="{{ $schoolLogo }}"
                            alt="Logo Sekolah"
                            class="max-h-full max-w-full object-contain"
                        >
                    </div>

                    <h1 class="mt-5 text-2xl font-bold">
                        SIM Perpustakaan
                    </h1>

                    <p class="mt-1 text-lg font-semibold text-emerald-50">
                        MTsN 1 Majene
                    </p>

                    <p class="mt-3 text-sm text-emerald-50">
                        Silakan masuk untuk mengakses sistem perpustakaan.
                    </p>
                </div>

                {{-- Form --}}
                <div class="px-8 py-8">
                    @if (session('status'))
                        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Username / Email --}}
                        <div>
                            <label for="login" class="mb-2 block text-sm font-semibold text-gray-800">
                                Username / Email
                            </label>

                            <div class="relative">
                                <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                    person
                                </span>

                                <input
                                    id="login"
                                    type="text"
                                    name="login"
                                    value="{{ old('login') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Masukkan username atau email"
                                    class="block w-full rounded-2xl border border-emerald-200 bg-white px-12 py-3.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                >
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-gray-800">
                                Password
                            </label>

                            <div class="relative">
                                <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600">
                                    lock
                                </span>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                    class="block w-full rounded-2xl border border-gray-200 bg-white px-12 py-3.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                                >
                            </div>
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between gap-3">
                            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-600">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                >
                                <span>Ingat Saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-sm font-medium text-emerald-700 transition hover:text-emerald-800">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-700 px-5 py-3.5 text-sm font-bold text-white shadow-md transition hover:bg-emerald-800"
                        >
                            <span>Masuk Sistem</span>
                            <span class="material-symbols-outlined text-[18px]">login</span>
                        </button>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-center">
                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }} MTsN 1 Majene. Hak Cipta Dilindungi.
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>