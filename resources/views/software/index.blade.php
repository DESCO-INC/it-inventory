<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Software Inventory</h1>
            <p class="text-sm text-[var(--text-muted-color)]">
                Manage software assets, license information, installation records, and expiration dates.
            </p>
        </div>
    </div>

    {{-- CARD --}}
    <div class="mb-2 bg-white rounded-lg shadow-sm overflow-hidden px-6 py-4">
        <div class="overflow-x-auto">

            {{-- SEARCH --}}
            <div class="flex justify-between">
                <form method="GET" class="mb-4 flex items-center gap-2">
                    <input name="search" id="search" type="text"
                        class="border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700"
                        placeholder="Search Here" value="{{ request('search') }}" />

                    <x-button type="submit" size="sm">Search</x-button>
                    @if (request('search'))
                        <x-link size="sm" bg="bg-[var(--primary-color)]" border="border-[var(--text-muted-color)]"
                            text="text-[var(--text-color)]" href="{{ url()->current() }}">
                            Clear
                        </x-link>
                    @endif
                </form>

                <h2 class="text-sm font-semibold text-[var(--text-muted-color)] leading-none">
                    Accountability List
                </h2>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                    <thead class="bg-[var(--table-header-bg)] text-[var(--table-header-text)]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">Application</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Supplier</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Date Installed</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Expiration</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Inventory Control #</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Installed By</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Remarks</th>
                            <th class="px-4 py-3 text-center text-sm font-medium w-15">Options</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($softwares as $software)
                            @php
                                $variant = match ($software->status) {
                                    'NO EXPIRY' => 'bg-gray-500/15 text-gray-400',
                                    'EXPIRED' => 'bg-red-500/15 text-red-400',
                                    'EXPIRING' => 'bg-yellow-500/15 text-yellow-400',
                                    'ACTIVE' => 'bg-green-500/15 text-green-400',
                                    default => 'bg-gray-500/15 text-gray-400',
                                };
                            @endphp

                            <tr class="hover:bg-[var(--table-row-hover)]">
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->software->name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->software->supplier }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->date_installed }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->date_expired }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->inventory->control_no }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->installed_by }}</td>
                                <td class="px-4 py-3 text-xs text-gray-800">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $variant }}">
                                        {{ $software->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-800">{{ $software->remarks }}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-1">
                                    <x-link size="sm" href="{{ route('inventory.edit', $software->inventory->id) }}">
                                        Manage
                                    </x-link>
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
    </div>


</x-layout>
