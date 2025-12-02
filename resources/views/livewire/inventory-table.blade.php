<div>
    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">
            
            <input type="text" wire:model.live="search" placeholder="Search by Name or Emp Number"
                class="border border-green-500 rounded px-2 py-1 text-sm w-full sm:w-48
               focus:ring focus:ring-blue-300 focus:border-blue-500 mb-5"/>
            <!-- Table -->
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Id</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Control No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Unit</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Model</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Serial No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Purchase Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Depreciation</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inventory as $item)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-600">{{ $item->id }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->unit_category->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->serial }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->purchase_date }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $item->depreciation_date }}</td>
                                @php
                                    $statusColors = [
                                        'ACTIVE' => ['text' => '#166534', 'bg' => '#bbf7d0'],
                                        'INACTIVE' => ['text' => '#991b1b', 'bg' => '#fecaca'],
                                        'DISPOSED' => ['text' => '#78350f', 'bg' => '#fef3c7'],
                                    ];
                                    $colors = $statusColors[$item->status] ?? [
                                        'text' => '#1f2937',
                                        'bg' => '#e5e7eb',
                                    ];
                                @endphp
                                <td class="px-4 py-4 flex justify-center items-center">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full"
                                        style="color: {{ $colors['text'] }}; background-color: {{ $colors['bg'] }};">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('units.edit', $item->id) }}"
                                        class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">
                                        Manage
                                    </a>
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
                {{ $inventory->links() }}
            </div>
        </div>
    </div>



</div>
