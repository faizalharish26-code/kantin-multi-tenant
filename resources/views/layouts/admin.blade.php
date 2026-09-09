<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Panel' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900 antialiased">
        <div class="min-h-screen">
            <div class="flex min-h-screen flex-col">
                <header class="border-b border-slate-200 bg-white/90 backdrop-blur-sm">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-600 text-sm font-bold text-white">A</div>
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Admin</p>
                                <h1 class="text-lg font-semibold text-slate-900">Kantin Control</h1>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700">Filter</button>
                            <button class="rounded-xl bg-sky-600 px-3 py-2 text-sm font-medium text-white shadow-sm">+ Tambah</button>
                        </div>
                    </div>
                </header>

                <div class="mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-6 md:px-6">
                    <nav class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                        <a href="#" class="rounded-full bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm">Overview</a>
                        <a href="#" class="rounded-full px-3 py-1.5 hover:text-slate-900">Tenant</a>
                        <a href="#" class="rounded-full px-3 py-1.5 hover:text-slate-900">Transaksi</a>
                        <a href="#" class="rounded-full px-3 py-1.5 hover:text-slate-900">Laporan</a>
                    </nav>

                    <main class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
