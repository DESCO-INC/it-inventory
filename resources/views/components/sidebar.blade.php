<aside
    class="flex flex-col w-full h-full
              bg-[var(--secondary-color)]/95 backdrop-blur-md
              shadow-lg border-r border-[var(--secondary-border-color)]
              overflow-y-auto">

    {{-- Logo --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-[var(--secondary-border-color)]">

        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-8 h-8 rounded-md bg-[var(--accent-color)] shadow-sm">
                <x-heroicon-o-cpu-chip class="w-5 h-5 text-[var(--primary-color)]" />
            </div>

            <h1 class="text-md font-semibold tracking-wide text-[var(--text-color)]">
                {{ config('app.name') }}
            </h1>
        </div>

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

    {{-- Menu --}}
    <nav class="flex-1 px-4 py-4 space-y-1">

        <div class="mb-2 text-xs tracking-wider text-zinc-500">
            Menu
        </div>

        <x-sidebar-link href="{{ route('units.index') }}" icon="heroicon-o-computer-desktop" :active="request()->routeIs('units.index')">
            Inventory Dashboard
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('accountability.index') }}" icon="heroicon-o-users" :active="request()->routeIs('accountability.index')">
            Accountability Dashboard
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('software.index') }}" icon="heroicon-o-credit-card" :active="request()->routeIs('software.index')">
            License Dashboard
        </x-sidebar-link>

        <div class="mb-2 text-xs tracking-wider text-zinc-500">
            Maintenance
        </div>

        <x-sidebar-link href="{{ route('maintenance.users') }}" icon="heroicon-o-user-group" :active="request()->routeIs('maintenance.users')">
            User Maintenance
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('maintenance.softwares') }}" icon="heroicon-o-command-line" :active="request()->routeIs('maintenance.softwares')">
            Software Maintenance
        </x-sidebar-link>

    </nav>

    {{-- User --}}
    <div class="mt-auto p-4 border-t border-[var(--secondary-border-color)]">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3 flex-1 min-w-0">

                <div
                    class="w-9 h-9 shrink-0 flex items-center justify-center rounded-md
               bg-[var(--accent-color)]
               text-[var(--primary-color)]
               font-semibold">
                    {{ collect(explode(' ', auth()->user()->name ?? 'Guest'))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('') }}
                </div>

                <div class="flex flex-col min-w-0 flex-1">

                    <div class="text-sm text-[var(--text-color)] truncate">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </div>

                    <div class="text-xs text-zinc-500 truncate">
                        {{ auth()->user()->email ?? 'Not login yet' }}
                    </div>

                </div>

            </div>

            <button onclick="openLogoutModal()"
                class="text-[10px] text-white bg-red-500 px-2 py-1 rounded
                       hover:bg-red-600 cursor-pointer transition">
                Logout
            </button>

        </div>

    </div>

</aside>
