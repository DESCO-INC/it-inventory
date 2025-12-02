<div>
    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Filter / Search</h2>
            <!-- Button Row (Right) --><!-- Filters & Search -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <!-- Workbase Filter -->
                <div>
                    <select wire:model.live="selectedDept"
                        class="border border-green-500 rounded px-2 py-1 text-sm focus:ring focus:ring-green-300">
                        <option value="">All Department</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <input type="text" wire:model.live="search" placeholder="Search by Name or Emp Number"
                        class="border border-green-500 rounded px-2 py-1 text-sm w-full sm:w-48 focus:ring focus:ring-blue-300 focus:border-blue-500" />
                </div>
                <button wire:click="exportAccountability" wire:loading.attr="disabled"
                    wire:target="exportAccountability"
                    class="bg-blue-500 text-white text-xs px-3 py-2 rounded hover:bg-blue-600 flex items-center gap-2">

                    <!-- Loading state -->
                    <span wire:loading wire:target="exportAccountability" class="flex items-center gap-2">
                        <x-dynamic-component :component="'heroicon-o-arrow-path'" class="w-4 h-4 inline-block animate-spin text-white" />
                        Exporting Data, please wait...
                    </span>

                    <!-- Normal state -->
                    <span wire:loading.remove wire:target="exportAccountability">
                        Export Data
                    </span>
                </button>


            </div>

        </div>
    </div>
    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">
            <!-- Table -->
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Id</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Department</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Location</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Item Control No.</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Model Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Date Received</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($accountability as $acc)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-600">{{ $acc->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->department }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->location }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->Inventory->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->Inventory->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $acc->date_received }}</td>
                                @php
                                    $statusColors = [
                                        'ACTIVE' => ['text' => '#166534', 'bg' => '#bbf7d0'],
                                        'INACTIVE' => ['text' => '#991b1b', 'bg' => '#fecaca'],
                                        'DISPOSED' => ['text' => '#78350f', 'bg' => '#fef3c7'],
                                    ];
                                    $colors = $statusColors[$acc->Inventory->status] ?? [
                                        'text' => '#1f2937',
                                        'bg' => '#e5e7eb',
                                    ];
                                @endphp
                                <td class="px-4 py-4 flex justify-center items-center">
                                    <span class="inline-block px-2 py-1 text-[10px] font-semibold rounded-full"
                                        style="color: {{ $colors['text'] }}; background-color: {{ $colors['bg'] }};">
                                        {{ $acc->Inventory->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $accountability->links() }}
            </div>
        </div>
    </div>
</div>
