<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/hris-logo.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
</head>

<body class="relative min-h-screen overflow-hidden">

    {{-- Background Image --}}
    <div class="fixed inset-0 -z-20">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-sm scale-105"
            style="background-image: url('{{ asset('images/background.jpg') }}');">
        </div>
    </div>

    {{-- Soft White Overlay --}}
    <div
        class="fixed inset-0 -z-10
           bg-gradient-to-br
           from-[rgba(255,255,255,0.55)]
           via-[rgba(248,250,252,0.50)]
           to-[rgba(241,245,249,0.60)]">
    </div>

    <div class="flex h-screen overflow-hidden relative z-10">
        {{-- Sidebar --}}
        @auth
            <x-layout.sidebar />
        @endauth

        <!-- ================= Main Area ================= -->
        <div class="flex-1 flex flex-col">
            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto {{ auth()->check() ? 'p-8' : '' }}">
                {{ $slot }}
            </main>
        </div>

        {{-- Toast Notification --}}
        <x-layout.toast />
    </div>

    @stack('scripts')
</body>

</html>
