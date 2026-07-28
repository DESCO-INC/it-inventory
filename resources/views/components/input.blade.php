@props([
    'id' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'label' => null,
])

<div>
    @if($label)
        <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"

        {{ $attributes->class([
            'w-full mt-1 rounded-lg border px-2 py-1.5 text-sm transition duration-200 focus:outline-none',
            'border-red-500 focus:border-red-500 focus:ring-red-500' => $errors->has($name),
            'border-gray-300 focus:border-[var(--accent-color)] focus:ring-[var(--accent-color)]' => ! $errors->has($name),
        ]) }}
    >

    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>