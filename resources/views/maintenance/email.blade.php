<x-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 text-white">
        <div>
            <h1 class="text-2xl font-bold">Email Alert Settings</h1>
            <p class="text-sm text-white/80">Customize how your system emails look and who receives them.</p>
        </div>

        <div class="flex gap-2">
            <x-button size="md" variant="inverted" href="{{ route('units.index') }}">
                Back
            </x-button>
        </div>
    </div>

    <x-card class="mb-2 bg-white border border-green-100 w-200">
        <form action="" method="POST" class="grid grid-cols-2 gap-4">
            @csrf

            <div class="col-span-2">
                <x-input label="Title" name="title" placeholder="IT Inventory System Notification" class="w-full"
                    required />
            </div>

            <div class="col-span-2">
                <x-input label="Greetings" name="greetings" placeholder="Hello IT Department" class="w-full" required />
            </div>

            <div class="col-span-2">
                <x-textarea label="Message" name="message" class="w-full" rows="4" required />
            </div>

            <div class="col-span-2 relative">

                {{-- Label (match x-input style) --}}
                <label class="mb-1 font-semibold text-gray-500 text-sm block">
                    Recipients
                </label>

                {{-- Pillbox (styled like your input component) --}}
                <div id="pillbox"
                    class="flex flex-wrap items-center gap-2 w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus-within:ring-1 focus-within:ring-[var(--color-accent)] focus-within:border-[var(--color-accent)] transition-colors duration-200 cursor-text bg-white">

                    <input type="text" id="pill-input"
                        class="flex-1 outline-none border-0 p-0 text-sm focus:ring-0 focus:border-0 bg-transparent"
                        placeholder="Search or type email...">
                </div>

                {{-- Dropdown (styled like input dropdown) --}}
                <div id="dropdown"
                    class="fixed z-50 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-48 overflow-y-auto">

                    @foreach ($users as $user)
                        <div class="dropdown-item px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                            data-email="{{ $user->email }}" data-name="{{ $user->name }}">
                            {{ $user->name }} <span class="text-gray-400">({{ $user->email }})</span>
                        </div>
                    @endforeach

                </div>

                {{-- Hidden input --}}
                <input type="hidden" name="recipients" id="recipients">
            </div>

            <div class="col-span-2 flex justify-end">
                <x-button type="submit">
                    Save Settings
                </x-button>
            </div>
        </form>
    </x-card>

    <script>
        $(document).ready(function() {
            let emails = [];

            function renderPills() {
                $('#pillbox .pill').remove();

                emails.forEach((item, index) => {
                    $('#pill-input').before(`
                <span class="pill bg-blue-100 text-blue-700 px-2 py-1 rounded flex items-center gap-1">
                    ${item.email}
                    <button type="button" class="remove text-xs" data-index="${index}">&times;</button>
                </span>
            `);
                });

                $('#recipients').val(emails.map(e => e.email).join(','));
            }

            function positionDropdown() {
                let input = $('#pillbox');
                let offset = input.offset();

                $('#dropdown').css({
                    position: 'fixed',
                    top: offset.top + input.outerHeight(),
                    left: offset.left,
                    width: input.outerWidth(),
                    zIndex: 9999
                });
            }

            function addEmail(email, name = email) {
                email = email.trim();
                if (!email) return;

                // prevent duplicates
                if (emails.some(e => e.email === email)) return;

                emails.push({
                    email,
                    name
                });
                renderPills();
            }

            // Focus → show dropdown
            $('#pill-input').on('focus', function() {
                positionDropdown();
                $('#dropdown').removeClass('hidden');
            });

            // Typing → filter dropdown
            $('#pill-input').on('keyup', function() {
                let value = $(this).val().toLowerCase();

                $('#dropdown .dropdown-item').each(function() {
                    let text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(value));
                });
            });

            // Click user from dropdown (event delegation FIXED)
            $('#dropdown').on('click', '.dropdown-item', function() {
                let email = $(this).data('email');
                let name = $(this).data('name');

                addEmail(email, name);

                $('#pill-input').val('');
                $('#dropdown').addClass('hidden');
            });

            // Remove pill
            $('#pillbox').on('click', '.remove', function() {
                let index = $(this).data('index');
                emails.splice(index, 1);
                renderPills();
            });

            // Click outside → close dropdown
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#pillbox, #dropdown').length) {
                    $('#dropdown').addClass('hidden');
                }
            });

            // Enter or comma → add manual email
            $('#pill-input').on('keypress', function(e) {
                if (e.which === 13 || e.which === 44) {
                    e.preventDefault();

                    let value = $(this).val().trim();

                    if (value) {
                        addEmail(value);
                        $(this).val('');
                    }
                }
            });

            // reposition on scroll/resize (important for fixed dropdown)
            $(window).on('scroll resize', function() {
                if (!$('#dropdown').hasClass('hidden')) {
                    positionDropdown();
                }
            });
        });
    </script>
</x-layout>
