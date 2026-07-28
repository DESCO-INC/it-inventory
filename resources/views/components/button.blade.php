@props([
    'type' => 'button',
    'bg' => 'bg-[var(--accent-color)]',
    'text' => 'text-white',
    'border' => 'border-transparent',
    'size' => 'md',
    'disabled' => false,
])

@php
    $sizes = [
        'xs' => 'px-1.5 py-0.5 text-[10px]',
        'sm' => 'px-2.5 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base',
    ];
@endphp


<button
    type="{{ $type }}"
    @disabled($disabled)
    {{
        $attributes->merge([
            'class' =>
                "inline-flex items-center justify-center gap-2
                rounded-lg
                font-medium
                border
                transition-all duration-200
                focus:outline-none
                focus:ring-2
                focus:ring-[var(--accent-color)]/30
                hover:-translate-y-0.5
                cursor-pointer
                disabled:opacity-50
                disabled:cursor-not-allowed
                {$sizes[$size]}
                {$bg}
                {$text}
                {$border}"
        ])
    }}
>
    {{ $slot }}
</button>