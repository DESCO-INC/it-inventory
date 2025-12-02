<x-layout>
    <h1 class="text-xl font-semibold text-white mb-5">Add New Item</h1>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Table -->
        <div class="px-6 py-5 overflow-x-auto">
            <form action="{{ url('/units') }}" method="POST" class="space-y-6 grid grid-cols-3 gap-4">
                @csrf

                <div class="mb-2">
                    <x-form-label for="model_name">Model Name</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="model_name" name="model_name"/>
                        <x-form-error name='model_name'/>
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-2">
                    <x-form-label for="unit_category_id">Category</x-form-label>
                    <select name="unit_category_id" id="unit_category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-focus:ring-green-500 focus:border-green-500 outline-none" required>
                        <option value="">Select Category</option>
                        @foreach ($category as $categories)
                            <option 
                                value="{{ $categories->id }}" 
                                data-code="{{ $categories->code }}" 
                                data-countIndex="{{ $categories->count_index }}"
                                data-depreciation="{{ $categories->years_depreciation }}"
                                >
                                {{ $categories->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-form-error name='unit_category_id'></x-form-error>
                </div>

                <div class="mb-2">
                    <x-form-label for="control_no" class="cursor-default">
                        Control Number
                    </x-form-label>

                    <div class="relative">
                        <input 
                            id="control_no" 
                            name="control_no" 
                            placeholder="Select category to auto-generate"
                            class="w-full pr-8 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                            readonly
                        />

                        <!-- Icon with tooltip -->
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 group">
                            <x-heroicon-o-information-circle 
                                class="w-4 h-4 text-gray-400 cursor-pointer hover:text-green-500"
                            />
                            <!-- Tooltip balloon -->
                            <div class="absolute right-0 mt-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded-md px-2 py-1 whitespace-nowrap z-10 shadow-md">
                                This is an auto-generated control number.
                            </div>
                        </div>
                    </div>

                    <x-form-error name="control_no" />
                </div>



                <div class="mb-2">
                    <x-form-label for="serial">Serial</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="serial" name="serial"/>
                        <x-form-error name='serial'/>
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label for="purchase_no">Purchase Reference</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="purchase_no" name="purchase_no"/>
                        <x-form-error name='purchase_no'/>
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label for="purchase_date">Purchase Date</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="purchase_date" name="purchase_date"/>
                        <x-form-error name='purchase_date'/>
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label for="manufacturing_date">Manufacturing Date</x-form-label>
                    <div class="mt-2">
                        <x-form-input type="date" id="manufacturing_date" name="manufacturing_date"/>
                        <x-form-error name='manufacturing_date'/>
                    </div>
                </div>

                <div class="mb-2">
                    <x-form-label for="depreciation_date">
                        Depreciation Date
                    </x-form-label>

                    <div class="relative mt-2">
                        <input 
                            type="date" 
                            id="depreciation_date" 
                            name="depreciation_date" 
                            readonly
                            class="w-full pr-8 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                        />

                        <!-- Icon with tooltip -->
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 group">
                            <x-heroicon-o-information-circle 
                                class="w-4 h-4 text-gray-400 cursor-pointer hover:text-green-500"
                            />
                            <!-- Tooltip balloon -->
                            <div class="absolute right-0 mt-1 hidden group-hover:block bg-gray-800 text-white text-xs rounded-md px-2 py-1 whitespace-nowrap z-10 shadow-md">
                                This is the computed depreciation start date.
                            </div>
                        </div>
                    </div>

                    <x-form-error name="depreciation_date" />
                </div>


                <div class="mb-2">
                    <x-form-label for="status">Status</x-form-label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-focus:ring-green-500 focus:border-green-500 outline-none" required>
                        <option value="">Select Status</option>
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                        <option value="DISPOSED">DISPOSED</option>
                    </select>
                    <x-form-error name='status'></x-form-error>
                </div>

                <div class="mb-2 col-span-3">
                    <x-form-label for="remarks">Remarks</x-form-label>
                    <div class="mt-2">
                        <x-form-input id="remarks" name="remarks"/>
                        <x-form-error name='remarks'/>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end gap-3 pt-6 col-span-3">
                    <a href="{{ route('units.index') }}" 
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('unit_category_id');
            const controlInput = document.getElementById('control_no');
            const purchaseDateInput = document.getElementById('purchase_date');
            const depreciationDateInput = document.getElementById('depreciation_date');

            // When category changes
            categorySelect.addEventListener('change', async function () {
                const categoryId = categorySelect.value;
                controlInput.placeholder = 'Loading...';
                // Recalculate depreciation if a purchase date already exists
                if (purchaseDateInput.value) {
                    fillDepreciationDate();
                }

                if (!categoryId) {
                    controlInput.value = '';
                    return;
                }

                try {
                    const baseUrl = "{{ url('/') }}"; 
                    const response = await fetch(`${baseUrl}/units/next-control/${categoryId}`);
                    const data = await response.json();

                    // Example format: LGU-11-20004
                    const controlNumber = `${data.code}-${data.nextId}-${data.countIndex}${String(data.totalSameCategory + 1).padStart(4, '0')}`;
                    controlInput.value = controlNumber;
                } catch (error) {
                    console.error('Error fetching next control number:', error);
                    controlInput.value = '';
                }
            });

            // When purchase date changes
            purchaseDateInput.addEventListener('change', fillDepreciationDate);

            // Function to calculate depreciation date
            function fillDepreciationDate() {
                const purchaseDateValue = purchaseDateInput.value;
                if (!purchaseDateValue) {
                    depreciationDateInput.value = '';
                    console.log("No purchase date selected");
                    return;
                }

                const purchaseDate = new Date(purchaseDateValue);
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                if (!selectedOption) {
                    depreciationDateInput.value = '';
                    return;
                }

                const yearsDepreciation = parseInt(selectedOption.getAttribute('data-depreciation')) || 0;
                if (yearsDepreciation > 0) {
                    const depreciationDate = new Date(purchaseDate);
                    depreciationDate.setFullYear(depreciationDate.getFullYear() + yearsDepreciation);
                    depreciationDateInput.value = depreciationDate.toISOString().split('T')[0];
                } else {
                    depreciationDateInput.value = '';
                }
            }
        });
    </script>

</x-layout>