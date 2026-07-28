@props([
    'id' => null,
    'name',
    'label' => null,
    'value' => null,
])

<div>
    @if($label)
        <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $id ?? $name }}"
        name="{{ $name }}"

        {{ $attributes->class([
            'w-full mt-1 rounded-lg border px-2 py-1.5 text-sm transition duration-200 focus:outline-none',
            'border-red-500 focus:border-red-500 focus:ring-red-500' => $errors->has($name),
            'border-gray-300 focus:border-[var(--accent-color)] focus:ring-[var(--accent-color)]' => ! $errors->has($name),
        ]) }}
    >
        @php
            $selected = old($name, $value);
        @endphp

        @foreach ($slot as $option)
            @if ($option instanceof \Illuminate\View\ComponentSlot)
                {!! $option !!}
            @else
                {!! str_replace(
                    'value="'.$selected.'"',
                    'value="'.$selected.'" selected',
                    $option
                ) !!}
            @endif
        @endforeach

        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>