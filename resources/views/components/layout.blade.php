<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light-mode');
        }
    </script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans overflow-x-hidden"
    style="background-color: var(--primary-color); color: var(--text-color);">
    <div class="flex min-h-screen">

        {{-- OVERLAY --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden">
        </div>

        {{-- SIDEBAR --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-72 md:w-64
                   bg-[var(--secondary-color)]/90 backdrop-blur-md
                   transform -translate-x-full md:translate-x-0
                   transition-transform duration-300 ease-in-out">

            <x-sidebar />
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-h-screen w-full md:pl-64">
            <x-toast />
            {{-- TOP BAR --}}
            <div class="md:hidden h-16 flex items-center px-4 border-b border-white/10">

                {{-- HAMBURGER --}}
                <button id="sidebarToggle"
                    class="md:hidden flex items-center justify-center w-8 h-8 rounded-md bg-[var(--accent-color)]">
                    <x-heroicon-o-bars-3 class="w-5 h-5 text-[var(--primary-color)]" />
                </button>

                <div class="ml-3 text-white font-semibold">
                    {{ config('app.name') }}
                </div>

            </div>

            <main class="flex-1 overflow-auto px-4 py-8">
                {{$slot}}
            </main>

        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">

        <div
            class="w-full max-w-md p-6 rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)] text-center">

            <h2 class="text-lg font-semibold mb-2 text-[var(--text-color)]">Confirm Logout?</h2>
            <p class="text-[var(--text-color)]/60 text-sm mb-6">Are you sure you want to logout from your account?</p>

            <div class="flex gap-3 justify-center">

                <button onclick="closeLogoutModal()"
                    class="px-4 py-2 text-sm rounded-lg
                       bg-[var(--primary-color)]
                       text-[var(--text-color)]
                       hover:bg-[var(--accent-hover-color)]
                       transition">
                    Cancel
                </button>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf

                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-lg
                           bg-red-500 text-white
                           hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </div>

    {{-- Sidebar transform into mobile mode --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        toggle.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        // optional: close when clicking a sidebar link (mobile UX)
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });
    </script>

    {{-- Logout Modal --}}
    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');

            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Close when clicking backdrop
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>

    {{-- Change UI theme --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const toggleBtn = document.getElementById('themeToggle');
            const iconSun = document.getElementById('iconSun');
            const iconMoon = document.getElementById('iconMoon');

            function updateThemeUI() {
                const isLight = document.documentElement.classList.contains('light-mode');

                if (isLight) {
                    iconSun.classList.remove('hidden');
                    iconMoon.classList.add('hidden');
                } else {
                    iconSun.classList.add('hidden');
                    iconMoon.classList.remove('hidden');
                }
            }

            // initial UI state
            updateThemeUI();

            toggleBtn?.addEventListener('click', () => {

                document.documentElement.classList.toggle('light-mode');

                const isLight =
                    document.documentElement.classList.contains('light-mode');

                localStorage.setItem('theme', isLight ? 'light' : 'dark');

                updateThemeUI();
            });

        });
    </script>

    {{-- Disable Button after submiting --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButtons = form.querySelectorAll(
                        'button[type="submit"], input[type="submit"]');

                    submitButtons.forEach(button => {
                        button.disabled = true;
                        button.textContent = 'Submitting...'; 
                        button.classList.add('opacity-50',
                            'cursor-not-allowed');
                    });
                });
            });
        });
    </script>

</body>

</html>
