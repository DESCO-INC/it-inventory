<aside id="sidebar"
    class="flex flex-col w-64 h-full
           bg-[var(--sidebar-bg)]/95 backdrop-blur-md
           shadow-lg border-r border-white/10
           transition-all duration-300 overflow-y-auto">

    {{-- Header --}}
    <div id="sidebarHeader" class="flex items-center justify-between h-16 px-4 border-b border-white/10">

        <div class="flex items-center gap-3">

            <div
                class="flex items-center justify-center w-9 h-9 rounded-md bg-[var(--primary-color)] text-[var(--accent-color)] shadow">
                <x-heroicon-o-cpu-chip class="w-5 h-5" />
            </div>

            <h1 id="sidebarTitle"
                class="text-md font-semibold tracking-wide text-[var(--secondary-color)] t[ransition-all">
                {{ config('app.name') }}
            </h1>

        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-4 space-y-1" id="sidebarMenu">
        <!-- Separator Header -->
        <div class="flex flex-col gap-1">
            <div class="sidebar-header px-2 text-xs font-semibold text-white/70 uppercase mb-1">
                Main Menu
            </div>

            <x-layout.sidebar-link route="inventory.index" label="Inventory Dashboard"
                icon="heroicon-s-computer-desktop" />

            <x-layout.sidebar-link route="accountability.index" label="Accountability List" icon="heroicon-s-users" />

            <x-layout.sidebar-link route="software.index" label="Software List" icon="heroicon-s-cpu-chip" />
        </div>

        <div class="mt-4 flex flex-col gap-1">
            <div class="sidebar-header px-2 text-xs font-semibold text-white/70 uppercase mb-1">
                Maintenance
            </div>

            <button id="maintenanceToggle"
                class="flex items-center justify-between px-2.5 py-1.5 text-sm rounded-md text-[var(--primary-color)] hover:bg-[var(--sidebar-hover)] hover:text-[var(--primary-color)] transition">

                <div class="flex items-center">
                    <x-heroicon-s-wrench class="w-4 h-4 mr-2" />
                    <span class="sidebar-link-label">Maintenance</span>
                </div>

                <svg id="maintenanceArrow" class="w-4 h-4 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            @php
                $isMaintenanceOpen = request()->routeIs('maintenance.*', 'user.*', 'software.*', 'roles.*');
            @endphp

            <div id="maintenanceMenu" class="{{ $isMaintenanceOpen ? '' : 'hidden' }} flex flex-col ml-4 gap-1">
                <x-layout.sidebar-link route="#" label="Audit Trail" icon="heroicon-s-clock" />
                <x-layout.sidebar-link route="user.index" label="User Maintenance" icon="heroicon-s-users" />
                <x-layout.sidebar-link route="software.maintenance" label="Software Maintenance" icon="heroicon-s-wrench" />
            </div>
        </div>

        <!-- Separator Header -->
        <div class="flex flex-col gap-1">
            <div class="sidebar-header px-2 text-xs font-semibold text-white/70 uppercase mb-1">
                User
            </div>

            <x-layout.sidebar-link route="user.profile" label="Profile" icon="heroicon-s-user" />
        </div>
    </nav>

    <!-- Footer -->
    <div id="sidebarFooter" class="mt-auto p-4 border-t border-white/10">

        <div class="flex items-center justify-between gap-3">

            <div class="flex items-center gap-3 flex-1 min-w-0">

                <a href="{{ route('user.profile') }}"
                    class="w-9 h-9 shrink-0 flex items-center justify-center rounded-md
           bg-[var(--primary-color)]
           text-[var(--accent-color)]
           font-semibold
           hover:opacity-90 transition">

                    {{ collect(explode(' ', auth()->user()->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('') }}

                </a>

                <div class="sidebar-user-info flex flex-col min-w-0 flex-1">

                    <div class="text-sm text-[var(--secondary-color)] truncate">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="text-xs text-white/60 truncate">
                        {{ auth()->user()->email }}
                    </div>

                </div>

            </div>

            <x-button size="sm" bg="bg-[var(--danger-color)]" onclick="toggleModal('logout-modal')">
                Logout
            </x-button>
        </div>
    </div>
</aside>

<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6">

        <div class="flex items-center gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Logout
                </h2>
                <p class="text-sm text-gray-600">
                    Are you sure you want to logout from your account?
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf

            <div class="flex justify-end gap-3">
                <x-button size="md" bg="bg-[var(--primary-color)]" border="border-[var(--text-muted-color)]"
                    text="text-[var(--text-color)]" onclick="toggleModal('logout-modal')">
                    Cancel
                </x-button>

                <x-button type="submit" size="md" bg="bg-[var(--danger-color)]">
                    Logout
                </x-button>
            </div>
        </form>

    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    $(function() {

        $("#contractToggle").click(function() {
            $("#contractMenu").slideToggle(200);
            $("#contractArrow").toggleClass("rotate-180");
        });

        $("#maintenanceToggle").click(function() {
            $("#maintenanceMenu").slideToggle(200);
            $("#maintenanceArrow").toggleClass("rotate-180");
        });

    });
</script>
