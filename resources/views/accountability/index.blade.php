<x-layout>
    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Accountability List</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">

                <!-- Search -->
                <form method="GET" class="mb-4 flex items-center gap-2">
                    <x-basic.input type="text" name="search" value="{{ $search }}" placeholder="Search" />
                    <x-basic.button variant="success">Search</x-basic.button>
                </form>

                <form method="GET" class="flex gap-2 mb-4">
                    {{-- Department filter --}}
                    <x-basic.select name="department" :options="$departments" :selected="$department" onchange="this.form.submit()">
                        <option value="">-- All Departments --</option>
                    </x-basic.select>
                </form>
            </div>

            <x-table.main class="">
                <thead class="bg-green-600 text-white">
                    <x-table.th>ID</x-table.th>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Department</x-table.th>
                    <x-table.th>Location</x-table.th>
                    <x-table.th>Item Control No.</x-table.th>
                    <x-table.th>Model Name</x-table.th>
                    <x-table.th>Date Received</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th>Action</x-table.th>
                </thead>
                <tbody>
                    @forelse ($accountability as $acc)
                        <tr>
                            @php
                                $status = match ($acc->inventory->status) {
                                    'ACTIVE' => 'active',
                                    'DEFECTIVE' => 'defective',
                                    'DISPOSED' => 'disposed',
                                    default => 'info',
                                };
                            @endphp
                            <x-table.td>{{ $acc->id }}</x-table.td>
                            <x-table.td>{{ $acc->name }}</x-table.td>
                            <x-table.td>{{ $acc->department }}</x-table.td>
                            <x-table.td>{{ $acc->location }}</x-table.td>
                            <x-table.td>{{ $acc->inventory->control_no ?? '-' }}</x-table.td>
                            <x-table.td>{{ $acc->inventory->model_name }}</x-table.td>
                            <x-table.td>{{ $acc->date_received }}</x-table.td>
                            <x-table.td class="text-center">
                                <x-basic.badge variant="{{ $status }}">
                                    {{ $acc->inventory->status }}
                                </x-basic.badge>
                            </x-table.td>
                            <x-table.td class="text-center">
                                <a href="{{ route('units.edit', $acc->inventory->id) }}"
                                    class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600 inline-block">
                                    Check
                                </a>
                            </x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td colspan="9" class="text-center text-gray-500">
                                No records found
                            </x-table.td>
                        </tr>
                    @endforelse
                </tbody>

            </x-table.main>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $accountability->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>
</x-layout>
