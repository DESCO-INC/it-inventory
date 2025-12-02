<!-- resources/views/components/dashboard-card.blade.php -->
@props([
    'title',
    'icon' => null,
    'color' => 'green',
])

@php
    $colorClasses = [
        'green' => 'text-green-600 border-green-200 bg-green-50',
        'blue' => 'text-blue-600 border-blue-200 bg-blue-50',
        'purple' => 'text-purple-600 border-purple-200 bg-purple-50',
        'orange' => 'text-orange-600 border-orange-200 bg-orange-50',
        'red' => 'text-red-600 border-red-200 bg-red-50',
    ];
@endphp

<div {{ $attributes->merge([
    'class' => 'col-span-1 bg-white rounded-lg shadow-md border border-green-500 p-6 hover:shadow-lg transition-shadow duration-200'
]) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $slot }}</p>
        </div>
        
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center {{ $colorClasses[$color] ?? $colorClasses['green'] }}">
                @if ($icon)
                    <x-dynamic-component :component="$icon" class="w-6 h-6" />
                @endif
            </div>
        </div>
    </div>
</div>
