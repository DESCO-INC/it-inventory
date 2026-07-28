<x-layout>
    <div class="w-full h-full min-h-screen flex">

        {{-- LEFT: Brand panel --}}
        <div
            class="hidden lg:flex lg:w-[45%] relative flex-col justify-between overflow-hidden bg-[var(--sidebar-bg)] text-[var(--sidebar-text)] p-12">

            {{-- subtle decorative logo --}}
            <div class="pointer-events-none absolute -right-16 -bottom-16 opacity-10">
                <x-heroicon-s-cpu-chip class="w-100 h-100 text-white" />
            </div>

            <div class="relative z-10">
                <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-[var(--accent-color)] shadow mb-8">
                    <x-heroicon-o-cpu-chip class="w-5 h-5 text-white" />
                </div>

                <p class="text-xs font-bold tracking-widest uppercase text-white/50 mb-2">
                    DESCO
                </p>
                <h1 class="text-3xl font-extrabold leading-tight mb-3">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <p class="text-sm leading-relaxed text-white/65 max-w-sm">
                    Centralize and manage your organization's IT assets, software licenses, hardware inventory, and
                    equipment lifecycle in one secure platform.
                </p>
            </div>

            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-white/60">
                    <p>
                        &copy; {{ date('Y') }} DESCO IT Department. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Form panel --}}
        <div class="flex-1 flex items-center justify-center p-6">
            <div
                class="relative flex flex-col w-full max-w-96 bg-[var(--secondary-color)] border border-[var(--secondary-border-color)] rounded-lg shadow-xl">

                <div class="p-6">
                    {{-- Mobile-only compact logo (brand panel is hidden below lg) --}}
                    <div class="flex flex-col items-center lg:hidden mb-2">
                        <div
                            class="flex items-center justify-center w-9 h-9 rounded-md bg-[var(--accent-color)] shadow">
                            <x-heroicon-o-user-group class="w-5 h-5 text-white" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-xs font-bold tracking-widest uppercase text-[var(--accent-active-color)] mb-1">
                            Welcome back
                        </p>
                        <p class="text-2xl font-bold text-[var(--heading-color)]">
                            Sign in to your account
                        </p>
                        <p class="text-sm text-[var(--text-muted-color)] mt-1">
                            Enter your credentials to access {{ config('app.name', 'Laravel') }}.
                        </p>
                    </div>

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        <div class="mb-3">
                            <x-input label="Email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email" class="w-full" />
                        </div>

                        <div class="mb-4">
                            <x-input label="Password" type="password" name="password" placeholder="Enter your password"
                                class="w-full" />
                        </div>

                        <x-button type="submit" class="w-full">
                            Sign in
                        </x-button>
                    </form>

                    <p class="text-center text-xs text-[var(--text-muted-color)] mt-5">
                        Having trouble signing in? Contact your system administrator.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
