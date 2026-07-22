<x-layout>

    <main class="max-w-7xl mx-auto py-2">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Software License Dashboard
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Monitor software license usage, expiration dates, compliance, and overall licensing status.
            </p>
        </div>

        {{-- Dashboard Cards --}}
        <div class="grid grid-cols-4 gap-4 mb-5">
            <x-dashboard-card title="Active Items" :value="1" icon="heroicon-o-check-circle"
                iconColor="text-[#5dc0e9]/20" data-search="ACTIVE" />

            <x-dashboard-card title="Defective Items" :value="1" icon="heroicon-o-exclamation-triangle"
                iconColor="text-[#e7a770]/20" data-search="DEFECTIVE" />

            <x-dashboard-card title="Disposed Items" :value="1" icon="heroicon-o-archive-box"
                iconColor="text-[#ead653]/20" data-search="DISPOSED" />

            <x-dashboard-card title="Items with Returned Status" :value="1" icon="heroicon-o-receipt-refund"
                iconColor="text-red-500/20" data-status="RETURNED" />
        </div>
    </main>
</x-layout>
