@props([
    'label' => null,
    'type' => 'text',
    'name' => null,
    'placeholder' => null,
])

<label {{ $attributes->only('class') }} class="block space-y-2 {{ $attributes->get('class') }}">
    @if ($label)
        <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->except(['class', 'label', 'type', 'name', 'placeholder']) }}
        class="block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-100"
    >
</label>
