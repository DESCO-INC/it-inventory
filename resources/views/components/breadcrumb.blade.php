@props([
    'items' => [],
])

<nav class="flex items-center gap-2 text-sm text-[var(--text-color)]/50 mb-3">

    @foreach ($items as $item)

        @if (!$loop->first)
            <x-heroicon-o-chevron-right class="w-4 h-4 shrink-0" />
        @endif

        @if (isset($item['url']) && !$loop->last)
            <a
                href="{{ $item['url'] }}"
                class="hover:text-[var(--accent-color)] transition">
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-[var(--text-color)]">
                {{ $item['label'] }}
            </span>
        @endif

    @endforeach

</nav>