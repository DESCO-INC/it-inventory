@props([
    'options' => [],     // ['value' => 'Label']
    'selected' => null,  // selected value
])

<select
    {{ $attributes->merge([
        'class' => 'border border-green-500 rounded px-2 py-1 text-sm w-full sm:w-64 focus:ring focus:ring-blue-300 focus:border-blue-500'
    ]) }}
>
    {{ $slot }}

    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @selected($value == $selected)>
            {{ $label }}
        </option>
    @endforeach
</select>
