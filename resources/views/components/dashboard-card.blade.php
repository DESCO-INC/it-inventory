@props([
    'title',
    'value',
    'icon' => 'heroicon-o-check-circle',
    'iconColor' => 'text-[#5dc0e9]/20',
])

<div
    {{ $attributes->merge([
        'class' => 'relative overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-3 transition hover:border-[var(--accent-color)]/40 hover:shadow-lg cursor-pointer'
    ]) }}>

    <x-dynamic-component
        :component="$icon"
        class="absolute -right-3 -bottom-3 w-20 h-20 {{ $iconColor }}"
    />

    <div class="relative z-10">
        <span class="text-sm text-[var(--text-color)]/60">
            {{ $title }}
        </span>

        <h2 class="mt-1 text-2xl font-bold text-[var(--text-color)]">
            {{ $value }}
        </h2>
    </div>
</div>