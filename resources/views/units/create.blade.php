<x-layout>
    <!-- Card with Top Right Buttons -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4">
            <h2 class="text-lg font-medium text-gray-800">Add New Inventory Item</h2>
            <!-- Button Row (Right) -->
            <div class="flex gap-2 mt-4 sm:mt-0">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Table -->
        <div class="px-6 py-5 overflow-x-auto">
            <form action="{{ url('/units') }}" method="POST" class="space-y-6 grid grid-cols-3 gap-4">
                @csrf

                <div class="mb-1">
                    <x-input label="Model Name" size="lg" name="model_name" class="w-full" required />
                </div>

                <!-- Category -->
                <div class="mb-1">
                    <x-select label="Category" size="lg" name="unit_category_id" :options="['' => 'Select Category'] +
                        $category->mapWithKeys(fn($i) => [$i->id => $i->name])->toArray()" width="full"
                        required />
                </div>

                <div class="mb-1">
                    <x-input label="Control Number" size="lg" name="control_no" class="w-full" readonly required />
                </div>

                <div class="mb-1">
                    <x-input label="Serial" name="serial" size="lg" class="w-full" required />
                </div>

                <div class="mb-1">
                    <x-input label="Purchase Reference" size="lg" name="purchase_no" class="w-full" required />
                </div>

                <div class="mb-1">
                    <x-input label="Purchase Date" size="lg" name="purchase_date" type="date" class="w-full"
                        required />
                </div>

                <div class="mb-1">
                    <x-input label="Manufacturing Date" size="lg" name="manufacturing_date" type="date"
                        class="w-full" required />
                </div>

                <div class="mb-1">
                    <x-input label="Depreciation Date" size="lg" name="depreciation_date" type="date"
                        class="w-full" readonly />
                </div>

                <div class="mb-1">
                    <x-select label="Status" size="lg" name="status" :options="[
                        '' => 'Select Status',
                        'ACTIVE' => 'ACTIVE',
                        'DEFECTIVE' => 'DEFECTIVE',
                        'DISPOSED' => 'DISPOSED',
                    ]" width="full" required />
                </div>

                <div class="mb-1 col-span-3">
                    <x-input label="Remarks" size="lg" name="remarks" class="w-full" />
                </div>

                <!-- Form Actions -->
                <div class="mt-5 flex items-center justify-end gap-3 pt-6 col-span-3">
                    <x-button href="{{ route('units.index') }}" variant="gray" >
                        Cancel
                    </x-button>
                    <x-button type="submit" variant="success">
                        Add Item
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('#unit_category_id').on('change', function() {
            let category_id = $(this).val();
            $('#control_no').val('');
            $('#control_no').attr('placeholder', 'Loading...').prop('disabled', true);
            fetchControlNo(category_id).then(data => {
                if (data.error) {
                    $('#control_no').val('').attr('placeholder', 'Failed to load').prop('disabled', false);
                    return;
                }
                $('#control_no').val(
                    `${data.code}-${data.nextId}-${data.countIndex}${String((data.totalSameCategory ?? 0) + 1).padStart(4, '0')}`
                ).prop('disabled', false);
            });
            fetchDepDate();
        });

        $('#purchase_date').on('change', function() {
            fetchDepDate();
        });
    </script>

    <script>
        const $categoryData = @json($category);

        function fetchControlNo(category_id) {
            const baseUrl = "{{ url('/') }}";
            return fetch(`${baseUrl}/units/next-control/${category_id}`)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .catch(error => {
                    console.error(error);
                    return {
                        error: error.message
                    };
                });
        }

        function fetchDepDate() {
            const category_id = $('#unit_category_id').val();
            const purchase_date = $('#purchase_date').val();
            const category = $categoryData.find(cat => cat.id == category_id);
            if (!category || !purchase_date) {
                $('#depreciation_date').val('');
                return;
            }

            const purchase = new Date(purchase_date);
            if (isNaN(purchase)) {
                $('#depreciation_date').val('');
                return;
            }

            const years = parseInt(category.years_depreciation) || 0;
            const depreciation = new Date(purchase);
            depreciation.setFullYear(depreciation.getFullYear() + years);

            const yyyy = depreciation.getFullYear();
            const mm = String(depreciation.getMonth() + 1).padStart(2, '0');
            const dd = String(depreciation.getDate()).padStart(2, '0');
            const depreciationDateStr = `${yyyy}-${mm}-${dd}`;
            $('#depreciation_date').val(depreciationDateStr);
        }
    </script>

</x-layout>
