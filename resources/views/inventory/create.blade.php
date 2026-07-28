<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-color)]">Create Inventory</h1>
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('inventory.index')], ['label' => 'Create']]" />
        </div>
    </div>

    <div class="mb-2 bg-white rounded-lg shadow-sm overflow-hidden px-6 py-4">
        <form action="{{ url('/inventory') }}" method="POST" class="grid grid-cols-3 gap-4">
            @csrf

            <x-input label="Model Name" name="model_name" required />

            <x-select label="Category" name="unit_category_id" required>
                <option value="">Select Category</option>
                @foreach ($category as $cat)
                    <option value="{{ $cat->id }}" @selected(old('unit_category_id') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </x-select>

            <x-input label="Control Number" name="control_no" readonly />
            <x-input label="Serial" name="serial" required />

            <x-input label="Purchase Reference" name="purchase_no" />
            <x-input label="Purchase Date" name="purchase_date" type="date" />

            <x-input label="Manufacturing Date" name="manufacturing_date" type="date" />
            <x-input label="Depreciation Date" name="depreciation_date" type="date" />

            <x-select label="Status" name="status" required>
                <option value="">Select Status</option>
                <option value="ACTIVE" @selected(old('status') == 'ACTIVE')>ACTIVE</option>
                <option value="DEFECTIVE" @selected(old('status') == 'DEFECTIVE')>DEFECTIVE</option>
                <option value="DISPOSED" @selected(old('status') == 'DISPOSED')>DISPOSED</option>
            </x-select>

            {{-- Full-width Remarks --}}
            <x-input label="Remarks" name="remarks" class="col-span-2" />

            {{-- Full-width Submit Button --}}
            <div class="col-span-3 flex justify-end">
                <x-button type="submit" size="md">
                    Submit
                </x-button>
            </div>
        </form>
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
