@props([
    'label' => null,
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'wrapperClass' => '',
])

@php
    $id = $id ?? $name;
@endphp

<div class="{{ $wrapperClass }}">
    @if ($label)
        <label
            for="{{ $id }}"
            class="block mb-2 text-sm font-medium text-[var(--text-color)]">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg bg-[var(--primary-color)] border border-[var(--secondary-border-color)] text-[var(--text-color)] placeholder:text-[var(--text-color)]/40 focus:outline-none focus:ring-2 focus:ring-[var(--accent-color)] focus:border-transparent',
        ]) }}
    >

    @error($name)
        <p class="mt-1 text-sm text-red-400">
            {{ $message }}
        </p>
    @enderror
</div>