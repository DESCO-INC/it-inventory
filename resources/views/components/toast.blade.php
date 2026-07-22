@props(['timeout' => 4000])

<div id="toast-container" class="fixed top-5 right-5 z-50 space-y-3 w-80"></div>

@if (session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast('success', @json(session('success')));
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast('error', @json(session('error')));
        });
    </script>
@endif

@if (session('info'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast('info', @json(session('info')));
        });
    </script>
@endif

@if (session('warning'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast('warning', @json(session('warning')));
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.showToast(
                'warning',
                @json($errors->first())
            );
        });
    </script>
@endif

<script>
    function showToast(type = 'info', message = '') {
        const container = document.getElementById('toast-container');

        const config = {
            success: {
                border: 'border-green-500',
                icon: `<x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />`
            },
            error: {
                border: 'border-red-500',
                icon: `<x-heroicon-o-x-circle class="w-5 h-5 text-red-600" />`
            },
            info: {
                border: 'border-blue-500',
                icon: `<x-heroicon-o-information-circle class="w-5 h-5 text-blue-600" />`
            },
            warning: {
                border: 'border-yellow-500',
                icon: `<x-heroicon-o-exclamation-triangle class="w-5 h-5 text-yellow-600" />`
            },
        };

        const selected = config[type] || config.info;

        const toast = document.createElement('div');

        toast.className = `
        flex items-start gap-3 p-4 rounded-lg
        bg-white text-black
        border-l-4 ${selected.border}
        shadow-lg
        transition-all duration-300
    `;

        toast.innerHTML = `
        <div class="mt-0.5">
            ${selected.icon}
        </div>

        <div class="flex-1 text-sm leading-snug">
            ${message}
        </div>

        <button class="text-gray-400 hover:text-black transition"
                onclick="this.parentElement.remove()">
            <x-heroicon-o-x-mark class="w-4 h-4" />
        </button>
    `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-5');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
</script>
