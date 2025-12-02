<div class="grid grid-cols-5 gap-4 mb-3">
    <x-dashboard-card title="Total Items" color="green" icon="heroicon-o-globe-asia-australia">
        {{ $totalItems }}
    </x-dashboard-card>

    <x-dashboard-card title="Active Items" color="blue" icon="heroicon-o-check-badge">
        {{ $statusCounts['active'] }}
    </x-dashboard-card>

    <x-dashboard-card title="Unassigned Items" color="blue" icon="heroicon-o-check-badge">
        {{ $statusCounts['active'] }}
    </x-dashboard-card>

    <x-dashboard-card title="Inactive Items" color="orange" icon="heroicon-o-x-circle">
        {{ $statusCounts['inactive'] }}
    </x-dashboard-card>

    <x-dashboard-card title="Disposed Items" color="red" icon="heroicon-o-trash">
        {{ $statusCounts['disposed'] }}
    </x-dashboard-card>
</div>
