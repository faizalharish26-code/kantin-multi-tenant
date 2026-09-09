<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Kantin') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-stone-50 text-stone-900 antialiased">
        <div class="min-h-screen">
            <header class="sticky top-0 z-30 border-b border-stone-200 bg-white/90 backdrop-blur-sm">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 md:px-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 text-sm font-semibold tracking-wide text-stone-900 uppercase">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500 text-base font-bold text-white shadow-sm">K</span>
                        {{ config('app.name', 'Kantin') }}
                    </a>

                    <nav class="hidden items-center gap-6 text-sm text-stone-600 md:flex">
                        <a href="{{ url('/') }}" class="transition hover:text-stone-900">Beranda</a>
                        <a href="#" class="transition hover:text-stone-900">Menu</a>
                        <a href="#" class="transition hover:text-stone-900">Promo</a>
                        <a href="#" class="transition hover:text-stone-900">Tentang</a>
                    </nav>

                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('tenant.dashboard', ['tenant' => auth()->user()->tenant ?? 'demo']) }}" class="inline-flex items-center rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm font-medium text-stone-700 transition hover:border-stone-300 hover:text-stone-900">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm font-medium text-stone-700 transition hover:border-stone-300 hover:text-stone-900">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-6xl px-4 py-6 md:px-6 md:py-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
