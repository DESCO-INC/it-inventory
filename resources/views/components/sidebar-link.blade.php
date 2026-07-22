@props([
    'href',
    'icon' => null,
    'active' => false,
    'open' => true,
])

<a href="{{ $href }}"
    class="flex items-center px-3 py-1.5 rounded-md text-sm transition
           {{ $active ? 'bg-[var(--accent-hover-color)]' : 'hover:bg-[var(--accent-hover-color)]' }}
           {{ $open ? '' : 'justify-center' }}">

    @if($icon)
        <x-dynamic-component
            :component="$icon"
            class="w-4 h-4" />
    @endif

    @if($open)
        <span class="ml-2">
            {{ $slot }}
        </span>
    @endif
</a>