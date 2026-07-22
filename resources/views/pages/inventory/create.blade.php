<x-layout>

    <main class="max-w-7xl mx-auto py-2">
        
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('units.index')],
            ['label' => 'Create'],
        ]" />

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--text-color)]">
                Create Inventory
            </h1>
            <p class="mt-2 text-[var(--text-color)]/60">
                Add a new inventory item to the system.
            </p>
        </div>


        <div
            class="relative overflow-hidden rounded-xl border border-[var(--secondary-border-color)] bg-[var(--secondary-color)]/40 p-5">

            <form action="{{ url('/units') }}" method="POST" class="grid grid-cols-3 gap-4">
                @csrf

                <x-input label="Model Name" name="model_name" required />

                <x-select label="Category" name="unit_category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}" @selected(old('id') == $cat->id)>
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

                <x-input label="Remarks" name="remarks" wrapperClass="col-span-3" />

                <div class="col-span-3 flex justify-end">
                    <button type="submit"
                        class="hidden md:inline-flex items-center justify-center px-3 py-2 rounded-lg
                   border border-[var(--secondary-border-color)]
                   bg-[var(--accent-color)] text-[var(--primary-color)] text-sm">
                        Submit
                    </button>
                </div>
            </form>
        </div>

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.showToast(
                        'warning',
                        @json($errors->first())
                    );
                });
            </script>
        @endif
    </main>

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
