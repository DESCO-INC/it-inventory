<x-layout>
    <x-card class="mb-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-medium text-gray-800">Software Inventory</h2>
        </div>
    </x-card>

    <x-card class="mb-2">
        <div class="overflow-x-auto">
            <form method="GET" class="mb-4 flex items-center gap-2">
                <input name="search" id="search" type="text"
                    class="border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:ring-2 focus:ring-green-500 focus:border-green-500 min-w-[150px]"
                    placeholder="Search Here" value="{{ request('search') }}" />

                <button class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600" type="submit">
                    Search
                </button>
            </form>
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">Application</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Supplier</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date Installed</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Expiration</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Inventory Control #</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Model</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Installed By</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($softwares as $software)
                            <tr>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->software->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->software->supplier }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->date_installed }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->date_expired }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->inventory->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->inventory->model_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->installed_by }}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-button size="xs" variant="info"
                                        href="{{ route('units.edit', $software->inventory->id) }}">
                                        Manage
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-2 text-center text-gray-500">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $softwares->appends(['search' => $search])->links() }}
            </div>
        </div>
    </x-card>
</x-layout>
