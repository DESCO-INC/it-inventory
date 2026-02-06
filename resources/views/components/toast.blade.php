@props([
    'type' => 'default', // default, success, warning, info, error
    'message'
])

@php
    $colors = [
        'default' => ['bg' => 'bg-gray-100', 'border' => 'border-gray-300', 'text' => 'text-gray-700', 'icon' => 'text-gray-500'],
        'success' => ['bg' => 'bg-green-100', 'border' => 'border-green-400', 'text' => 'text-green-700', 'icon' => 'text-green-500'],
        'warning' => ['bg' => 'bg-yellow-100', 'border' => 'border-yellow-400', 'text' => 'text-yellow-700', 'icon' => 'text-yellow-500'],
        'info'    => ['bg' => 'bg-blue-100', 'border' => 'border-blue-400', 'text' => 'text-blue-700', 'icon' => 'text-blue-500'],
        'error'   => ['bg' => 'bg-red-100', 'border' => 'border-red-400', 'text' => 'text-red-700', 'icon' => 'text-red-500'],
    ];

    $color = $colors[$type] ?? $colors['default'];
    $toastId = 'toast-' . uniqid();
@endphp

<div id="{{ $toastId }}"
     class="fixed top-4 right-4 z-50 flex items-center w-full max-w-xs p-4 rounded-lg shadow-lg border {{ $color['border'] }} {{ $color['bg'] }}"
     role="alert">
    <svg class="flex-shrink-0 w-5 h-5 {{ $color['icon'] }}" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M16.707 5.293a1 1 0 01.083 1.32l-.083.094L9 14.414 4.707 10.12a1 1 0 011.32-1.497l.094.083L9 11.586l7.293-7.293a1 1 0 011.414 0z"
              clip-rule="evenodd" />
    </svg>
    <div class="ml-3 text-sm font-medium {{ $color['text'] }}">
        {{ $message }}
    </div>
    <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-600 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
            onclick="document.getElementById('{{ $toastId }}').remove()">
        ✖
    </button>
</div>

<script>
    setTimeout(() => {
        const toast = document.getElementById('{{ $toastId }}');
        if (toast) toast.remove();
    }, 4000);
</script>
