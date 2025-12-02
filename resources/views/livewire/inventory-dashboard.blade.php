<div class="grid grid-cols-4 grid-rows-2 gap-2 mb-3">

    <!-- TOTAL ITEMS (2 columns x 2 rows) -->
    <div class="col-span-2 row-span-2 relative overflow-hidden bg-[#a4f5a6] rounded-xl shadow-sm border border-[#a4f5a6] p-10 hover:shadow-md transition-all duration-200">

        <!-- Background Icon -->
        <div class="absolute right-0 top-0 translate-x-5 -translate-y-5 opacity-[0.5] pointer-events-none">
            <x-heroicon-o-rectangle-stack class="w-72 h-72 text-[#00c950]" />
        </div>

        <div class="relative flex flex-col h-full justify-center">
            <p class="text-xl font-semibold text-gray-600 uppercase tracking-wide">Total Inventory Items</p>
            <p class="mt-1 text-6xl font-extrabold text-gray-900">{{ $totalItems }}</p>
        </div>

    </div>

    <!-- Active Items -->
    <div class="relative bg-[#a6d8f5] rounded-xl shadow-sm border border-[#a6d8f5] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden">
        <!-- Background Icon -->
        <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
            <x-heroicon-o-check-badge class="w-20 h-20 text-[#00a3d9]" />
        </div>

        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Active Items</p>
        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['active'] }}</p>
    </div>

    <!-- Unassigned Items -->
    <div class="relative bg-[#f5cda6] rounded-xl shadow-sm border border-[#f5cda6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden">
        <!-- Background Icon -->
        <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
            <x-heroicon-o-user-group class="w-20 h-20 text-[#d9823b]" />
        </div>

        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Unassigned Items</p>
        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['unassigned'] }}</p>
    </div>

    <!-- Inactive Items -->
    <div class="relative bg-[#f5f5a6] rounded-xl shadow-sm border border-[#f5f5a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden">
        <!-- Background Icon -->
        <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
            <x-heroicon-o-x-circle class="w-20 h-20 text-[#e0b800]" />
        </div>

        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Inactive Items</p>
        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['inactive'] }}</p>
    </div>

    <!-- Disposed Items -->
    <div class="relative bg-[#f5a6a6] rounded-xl shadow-sm border border-[#f5a6a6] p-4 hover:shadow-md transition-all duration-200 flex flex-col justify-center overflow-hidden">
        <!-- Background Icon -->
        <div class="absolute right-0 top-0 translate-x-3 -translate-y-3 opacity-[0.5] pointer-events-none">
            <x-heroicon-o-trash class="w-20 h-20 text-[#d93030]" />
        </div>

        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Disposed Items</p>
        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusCounts['disposed'] }}</p>
    </div>

</div>
