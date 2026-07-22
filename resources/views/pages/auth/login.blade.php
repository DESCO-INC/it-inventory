<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light-mode');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans" style="background-color: var(--primary-color); color: var(--text-color);">
    <x-toast />
    <div class="fixed top-6 right-6 z-50">
        <button id="themeToggle"
            class="flex items-center justify-center w-9 h-9 rounded-md
           bg-[var(--secondary-color)]
           border border-[var(--secondary-border-color)]
           hover:bg-[var(--accent-hover-color)]
           transition">

            {{-- Sun (Light Mode Icon) --}}
            <x-heroicon-o-sun id="iconSun" class="w-5 h-5 text--[var(--text-color)] hidden" />

            {{-- Moon (Dark Mode Icon) --}}
            <x-heroicon-o-moon id="iconMoon" class="w-5 h-5 text-zinc-300 hidden" />

        </button>
    </div>
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-center min-h-[70vh]">
            <div class="w-full max-w-md">
                <div
                    class="p-8 rounded-2xl bg-[var(--secondary-color)] border border-[var(--secondary-border-color)] shadow-xl">
                    <!-- Header -->
                    <div class="mb-6 flex flex-col items-center justify-center ">
                        <div
                            class="w-12 h-12 rounded-md bg-[var(--accent-color)] flex items-center justify-center mb-3">
                            <x-heroicon-o-cpu-chip class="w-5 h-5 text-[var(--primary-color)]" />
                        </div>

                        <h1 class="text-2xl text-center font-semibold text-[var(--text-color)] normal-case">
                            {{ config('app.name') }}
                        </h1>

                        <p class="mt-2 text-sm text-zinc-500">
                            Enter your email and password below to log in
                        </p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('auth.login') }}" class="">
                        @csrf

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

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="block mb-2 text-sm font-medium text-[var(--text-color)]">
                                Email
                            </label>
                            <input id="email" name="email" type="email" placeholder="name@example.com"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-2 rounded-lg bg-[var(--primary-color)] border border-[var(--secondary-border-color)] text-[var(--text-color)] focus:outline-none">
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-[var(--text-color)]">
                                Password
                            </label>

                            <input id="password" name="password" type="password" required placeholder="••••••••"
                                class="w-full px-4 py-2 rounded-lg bg-[var(--primary-color)] border border-[var(--secondary-border-color)] text-[var(--text-color)] focus:outline-none">
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full py-3 mb-2 rounded-lg bg-[var(--accent-color)] text-[var(--primary-color)] font-medium hover:bg-gray-100 transition">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>



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
</body>

</html>
