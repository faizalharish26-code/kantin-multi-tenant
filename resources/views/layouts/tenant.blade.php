<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Tenant Dashboard' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900 antialiased">
        <div class="min-h-screen">
            <div class="flex min-h-screen">
                <aside class="hidden w-72 shrink-0 border-r border-slate-200 bg-slate-900 text-slate-100 lg:flex lg:flex-col">
                    <div class="flex items-center gap-3 border-b border-slate-700 px-6 py-5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 font-bold text-slate-950">K</div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tenant</p>
                            <h1 class="text-lg font-semibold text-white">Kantin Hub</h1>
                        </div>
                    </div>

                    <nav class="flex-1 space-y-2 px-4 py-6">
                        <a href="#" class="flex items-center gap-3 rounded-xl bg-slate-800 px-3 py-2.5 text-sm font-medium text-white">Dashboard</a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Pesanan</a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Menu</a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Karyawan</a>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-slate-800 hover:text-white">Laporan</a>
                    </nav>

                    <div class="border-t border-slate-700 px-4 py-4">
                        <div class="rounded-xl bg-slate-800 px-3 py-2 text-sm text-slate-200">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Akun</p>
                            <p class="mt-1 font-medium text-white">{{ auth()->user()->name ?? 'Admin Tenant' }}</p>
                        </div>
                    </div>
                </aside>

                <div class="flex-1">
                    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur-sm">
                        <div class="flex items-center justify-between px-4 py-3 md:px-6">
                            <div class="flex items-center gap-3">
                                <button class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 lg:hidden">
                                    ☰
                                </button>
                                <div>
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Tenant</p>
                                    <h2 class="text-lg font-semibold text-slate-900">{{ $title ?? 'Dashboard' }}</h2>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700">Notifikasi</button>
                                <button class="rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white shadow-sm">+ Pesanan</button>
                            </div>
                        </div>
                    </header>

                    <main class="p-4 md:p-6">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
