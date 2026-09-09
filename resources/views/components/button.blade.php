@props([
    'variant' => 'primary',
    'size' => 'md',
    'as' => 'button',
])

@php
    $classes = [
        'inline-flex items-center justify-center rounded-xl font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        'primary' => 'bg-amber-500 text-white shadow-sm hover:bg-amber-600 focus:ring-amber-500',
        'secondary' => 'border border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:text-slate-900 focus:ring-slate-400',
        'danger' => 'bg-rose-500 text-white hover:bg-rose-600 focus:ring-rose-500',
        'ghost' => 'bg-transparent text-slate-700 hover:bg-slate-100 focus:ring-slate-400',
    ][$variant] ?? 'bg-amber-500 text-white';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ][$size] ?? 'px-4 py-2 text-sm';
@endphp

<{{ $as }} {{ $attributes->class([$classes, $sizes]) }}>
    {{ $slot }}
</{{ $as }}>
