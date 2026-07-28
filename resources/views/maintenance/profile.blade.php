<x-layout>
    <!-- PROFILE HEADER -->

    <div class="mb-2 bg-white rounded-lg shadow-sm overflow-hidden px-6 py-4">

        <div class="m-6 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div
                    class="w-24 h-24 rounded-xl bg-gradient-to-tr from-[var(--accent-color)] to-[var(--accent-active-color)] text-white flex items-center justify-center font-bold text-4xl shadow-lg">
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('') }}
                </div>

                <div class="flex flex-col">
                    <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                    <h2 class="text-lg font-medium text-gray-600">{{ Auth::user()->email }}</h2>
                </div>
            </div>

            <!-- EDIT BUTTON -->
            <div>
                <x-button id="editBtn">Edit Information</x-button>
            </div>
        </div>
    </div>

    <!-- PROFILE FORM -->
    <div class="mb-2 bg-white rounded-lg shadow-sm overflow-hidden px-6 py-4">

        <form class="m-6" method="POST" action="{{ route('user.update', Auth::user()->id) }}">
            @csrf
            @method('PUT')

            <fieldset id="edit_profile" class="w-150" disabled>
                <x-input label="Full Name" name="name" size="lg" value="{{ Auth::user()->name }}"
                    class="mb-3" />

                <!-- FIXED NAME -->
                <x-input label="Email Address" name="email" value="{{ Auth::user()->email }}" class="mb-3" />

                <x-select label="Credential" name="credential">
                    <option value="" @selected(Auth::user()->credential == '')>Select Credential</option>
                    <option value="ADMIN" @selected(Auth::user()->credential == 'ADMIN')>ADMIN</option>
                    <option value="USER" @selected(Auth::user()->credential == 'USER')>USER</option>
                </x-select>

                <!-- PASSWORD FIELDS (HIDDEN INITIALLY) -->
                <div id="passwordFields" class="hidden">
                    <x-input label="Password" type="password" name="password" size="lg" class="mb-3" />

                    <x-input label="Confirm Password" type="password" name="password_confirmation" size="lg"
                        class="mb-3" />
                </div>
            </fieldset>

            <!-- ACTION BUTTONS -->
            <div id="actionButtons" class="hidden mt-4 flex gap-2">
                <x-button type="submit">Save</x-button>
                <x-button type="button" id="cancelBtn" bg="bg-[var(--primary-color)]"
                    border="border-[var(--text-muted-color)]" text="text-[var(--text-color)]">Cancel</x-button>
            </div>
        </form>
    </div>


    <script>
        $(document).ready(function() {

            $('#editBtn').click(function() {
                $('#edit_profile').prop('disabled', false);
                $('#passwordFields').removeClass('hidden');
                $('#actionButtons').removeClass('hidden');
                $(this).addClass('hidden'); // hide edit button
            });

            $('#cancelBtn').click(function() {
                $('#edit_profile').prop('disabled', true);
                $('#passwordFields').addClass('hidden');
                $('#actionButtons').addClass('hidden');
                $('#editBtn').removeClass('hidden');

                // reset form values
                $('form')[0].reset();
            });

        });
    </script>
</x-layout>
