@php
    $hasBg = str_contains($attributes->get('class'), 'bg-');
@endphp

<div {{ $attributes->merge([
    'class' => 'rounded-lg shadow-sm overflow-hidden px-6 py-4 ' . ($hasBg ? '' : 'bg-white')
]) }}>
    {{ $slot }}
</div>