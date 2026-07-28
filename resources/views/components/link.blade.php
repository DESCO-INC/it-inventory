@props([
    'href' => '#',
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

<a
    href="{{ $disabled ? 'javascript:void(0)' : $href }}"
    @if($disabled) aria-disabled="true" @endif
    {{
        $attributes->merge([
            'class' => "
                inline-flex items-center justify-center gap-2
                rounded-lg
                font-medium
                border
                transition-all duration-200
                focus:outline-none
                focus:ring-2
                focus:ring-[var(--accent-color)]/30
                hover:-translate-y-0.5
                hover:shadow-sm
                active:translate-y-0
                active:scale-[0.98]
                no-underline
                select-none

                " . ($disabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'cursor-pointer') . "

                {$sizes[$size]}
                {$bg}
                {$text}
                {$border}
            "
        ])
    }}
>
    {{ $slot }}
</a>