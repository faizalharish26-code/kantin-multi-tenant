@props([
    'title' => 'Belum ada data',
    'description' => null,
])

<div {{ $attributes->class(['flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center']) }}>
    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-white text-2xl shadow-sm ring-1 ring-slate-200">
        ⌁
    </div>
    <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 max-w-md text-sm text-slate-500">{{ $description }}</p>
    @endif
    @if (isset($slot) && trim((string) $slot) !== '')
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
