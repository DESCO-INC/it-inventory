@php
    // Determine which type exists in the session
    $sessionTypes = ['success', 'error', 'info', 'warning', 'default'];
    $type = 'default';
    $message = null;

    foreach ($sessionTypes as $t) {
        if (session()->has($t)) {
            $type = $t;
            $message = session($t);
            break;
        }
    }

    // Updated design colors (like your target UI)
    $colors = [
        'default' => ['bg' => 'bg-gray-100', 'border' => 'border-gray-300', 'text' => 'text-gray-700', 'icon' => 'text-gray-500'],
        'success' => ['bg' => 'bg-green-100', 'border' => 'border-green-400', 'text' => 'text-green-700', 'icon' => 'text-green-500'],
        'info'    => ['bg' => 'bg-blue-100', 'border' => 'border-blue-400', 'text' => 'text-blue-700', 'icon' => 'text-blue-500'],
        'warning' => ['bg' => 'bg-yellow-100', 'border' => 'border-yellow-400', 'text' => 'text-yellow-700', 'icon' => 'text-yellow-500'],
        'error'   => ['bg' => 'bg-red-100', 'border' => 'border-red-400', 'text' => 'text-red-700', 'icon' => 'text-red-500'],
    ];

    $color = $colors[$type] ?? $colors['default'];
@endphp

@if($message)
<div
    class="toast fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 rounded-lg shadow-lg border {{ $color['bg'] }} {{ $color['border'] }}"
>
    {{-- Icon --}}
    <div class="flex-shrink-0 {{ $color['icon'] }}">
        @if($type === 'success') ✅ @endif
        @if($type === 'info') ℹ️ @endif
        @if($type === 'warning') ⚠️ @endif
        @if($type === 'error') ❌ @endif
    </div>

    {{-- Message --}}
    <div class="ml-3 text-sm font-medium {{ $color['text'] }}">
        {{ $message }}
    </div>

    {{-- Close --}}
    <button class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-200 toast-close">
        ✖
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.querySelector('.toast');
        const closeBtn = document.querySelector('.toast-close');

        // Auto-hide
        setTimeout(() => {
            toast?.remove();
        }, 4000);

        // Manual close
        closeBtn?.addEventListener('click', () => {
            toast?.remove();
        });
    });
</script>
@endif