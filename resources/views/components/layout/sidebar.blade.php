<aside id="sidebar" class="w-60 bg-[var(--color-primary)] flex flex-col transition-all duration-300">

    <!-- Logo + Collapse Button -->
    <div id="sidebarLogo" class="h-16 flex justify-between items-center px-4 transition-all duration-300">
        <a href="{{ url('/') }}">
            <span class="text-2xl font-bold text-[var(--color-secondary)] flex-1"
                style="font-family: Verdana, sans-serif;">
                DESCO
            </span>
        </a>

        {{-- Collapse button when expanded --}}
        <button id="sidebarToggleBtn" class="p-1 rounded hover:bg-gray-200">
            <x-heroicon-o-chevron-double-left class="w-5 h-5 toggle-icon-left text-[var(--color-secondary)]" />
            <x-heroicon-o-chevron-double-right class="w-5 h-5 toggle-icon-right text-[var(--color-secondary)] hidden" />
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-2" id="sidebarMenu">
        <!-- Separator Header -->
        <div class="flex flex-col gap-1">
            <div class="sidebar-header px-2 text-xs font-semibold text-white/70 uppercase mb-1">
                Main Menu
            </div>
            <x-layout.sidebar-link route="units.index" label="Inventory List" icon="heroicon-s-computer-desktop" />
            <x-layout.sidebar-link route="software.index" label="Software List" icon="heroicon-s-cpu-chip" />
            <x-layout.sidebar-link route="accountability.index" label="Accountability List" icon="heroicon-s-user-group" />
        </div>

        <!-- Separator Header -->
        <div class="mt-4 flex flex-col gap-1">
            <div class="sidebar-header px-2 text-xs font-semibold text-white/70 uppercase mb-1">
                Maintenance
            </div>

            <!-- Dropdown Button -->
            <button id="maintenanceToggle"
                class="flex items-center justify-between px-2.5 py-1.5 text-sm rounded-md text-[var(--color-secondary)] hover:bg-[var(--color-secondary)] hover:text-[var(--color-primary)] transition">

                <div class="flex items-center">
                    <x-heroicon-s-wrench class="w-4 h-4 mr-2" />
                    <span class="sidebar-link-label">Maintenance</span>
                </div>

                <!-- Arrow -->
                <x-heroicon-s-chevron-down class="w-4 h-4 transition-transform duration-200" />
            </button>

            @php
                $isMaintenanceOpen = request()->routeIs('maintenance.*');
            @endphp

            <!-- Dropdown Items -->
            <div id="maintenanceMenu" class="{{ $isMaintenanceOpen ? '' : 'hidden' }} flex flex-col ml-4 gap-1">
                <x-layout.sidebar-link route="maintenance.users" label="User Maintenance" icon="heroicon-s-wrench" />
                <x-layout.sidebar-link route="#" label="Others" icon="heroicon-s-wrench" />
            </div>
        </div>
    </nav>

    <!-- Footer -->
    <div id="footer"
        class="px-4 py-2 border-t border-gray-200 text-sm text-[var(--color-secondary)] flex justify-center">
        © 2026 DESCO
    </div>
</aside>

<script>
    $(document).ready(function() {
        const $sidebar = $('#sidebar');
        const $toggleBtn = $('#sidebarToggleBtn'); // button next to logo
        const $menu = $('#sidebarMenu');
        const $logo = $('#sidebarLogo');
        const $footer = $('#footer');
        const $logoSpan = $logo.find('span');
        const $headers = $('.sidebar-header');

        // Store the full text in a data attribute once
        if (!$logoSpan.data('full')) {
            $logoSpan.attr('data-full', $logoSpan.text().trim());
        }

        $('#maintenanceToggle').on('click', function() {
            $('#maintenanceMenu').slideToggle(200);

            $('#maintenanceArrow').toggleClass('rotate-180');
        });

        // Collapse button click
        $toggleBtn.on('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        // Make the logo itself clickable when minimized
        $logo.on('click', function() {
            if ($sidebar.hasClass('w-25')) { // if minimized
                toggleSidebar();
            }
        });

        // Function to get initials
        function getInitials(text) {
            return text
                .split(' ')
                .map(word => word.charAt(0).toUpperCase())
                .join('');
        }

        function toggleSidebar() {
            // Toggle sidebar width
            $sidebar.toggleClass('w-60 w-25'); // adjust w-25 to your collapsed width

            // Hide/show labels
            $menu.find('.sidebar-link-label').toggleClass('hidden');
            $headers.toggleClass('hidden');

            // Shrink logo text
            $logoSpan.addClass('text-center');
            $footer.toggleClass('text-sm text-[8px]');

            // Swap logo text with initials when minimized
            if ($sidebar.hasClass('w-25')) { // collapsed
                $logoSpan.text(getInitials($logoSpan.data('full')));
            } else { // expanded
                $logoSpan.text($logoSpan.data('full'));
            }

            // Center logo when minimized
            $logo.toggleClass('justify-center');

            // Swap toggle icons
            $toggleBtn.find('.toggle-icon-left, .toggle-icon-right').toggleClass('hidden');
        }
    });
</script>
