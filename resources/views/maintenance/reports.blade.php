<x-layout>
    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Reports</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-5 overflow-x-auto">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">

                <h2 class="text-lg font-medium text-gray-800 mb-4">Inventory Reports</h2>
            </div>

            <div class="grid grid-cols-4 gap-4">

                <div class="col-span-4 flex gap-4">
                    <!-- Left Card -->
                    <div
                        class="flex-1 relative bg-[#a6d8f5] rounded-xl shadow-sm border border-[#a6d8f5] p-4 transition-all duration-200 flex flex-col justify-center overflow-hidden">
                        <div
                            class="absolute right-0 top-0 -translate-x-4 -translate-y-1 opacity-50 pointer-events-none">
                            <x-heroicon-s-arrow-down-on-square-stack class="w-13 h-13 text-[#00a3d9]" />
                        </div>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Item Masterlist</p>
                    </div>

                    <!-- Right Card -->
                    <div
                        class="flex-[2] relative bg-white rounded-xl shadow-sm border border-[#a6d8f5] p-4 transition-all duration-200 flex items-center overflow-hidden">
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">
                            Total Item/s : <span>{{$count}}</span>
                        </p>

                        <x-basic.button variant="info" class="ml-auto">
                            Download
                        </x-basic.button>
                    </div>
                </div>

                <div class="col-span-4 flex gap-4">
                    <!-- Left Card -->
                    <div
                        class="flex-1 relative bg-[#f5a6a6] rounded-xl shadow-sm border border-[#f5a6a6] p-4 transition-all duration-200 flex flex-col justify-center overflow-hidden">
                        <div
                            class="absolute right-0 top-0 -translate-x-4 -translate-y-1 opacity-50 pointer-events-none">
                            <x-heroicon-s-arrow-down-on-square-stack class="w-13 h-13 text-[#a87272]" />
                        </div>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Disposed Item List</p>
                    </div>

                    <!-- Right Card -->
                    <div class="flex-[2] relative bg-white rounded-xl shadow-sm border border-[#f5a6a6] p-4 transition-all duration-200 flex items-center overflow-hidden">
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">
                            Date From : 
                        </p>
                        <x-basic.input type="date" class="w-10" name="datefrom"/>
                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">
                            Total Item/s : <span>{{$count}}</span>
                        </p>

                        <x-basic.button variant="error" class="ml-auto">
                            Download
                        </x-basic.button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-layout>
