@props([
    'route' => null,
    'label',
    'icon' => null,
    'id' => null,
])

@php
    $href = $route ? ($route === '#' ? '#' : route($route)) : '#';

    // Active if the current route name matches
    $active = $route && request()->routeIs($route);
@endphp

<a href="{{ $href }}" id="{{ $id ?? '' }}"
    class="flex items-center px-2.5 py-1.5 text-sm rounded-md transition-colors duration-200
    {{ $active
        ? 'bg-[var(--sidebar-active)] text-[var(--primary-color)]'
        : 'text-[var(--primary-color)] hover:bg-[var(--sidebar-hover)] hover:text-[var(--primary-color)]' }}">

    @if ($icon)
        <x-dynamic-component :component="$icon" class="w-4 h-4 mr-2" />
    @else
        {{ $slot }}
    @endif

    <span class="sidebar-link-label">{{ $label }}</span>
</a>