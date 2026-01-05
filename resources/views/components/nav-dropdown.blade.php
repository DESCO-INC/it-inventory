@props([
    'active' => false,
    'label' => '',
    'items' => [], // array of ['label' => '', 'url' => '']
])

<div class="relative inline-block text-left">
    <!-- Dropdown toggle -->
    <button type="button"
        @class([
            'flex items-center gap-1 px-4 py-2 rounded-md font-semibold transition',
            'text-white bg-green-700' => $active,
            'text-white hover:bg-green-700' => !$active,
        ])
        onclick="this.nextElementSibling.classList.toggle('hidden')"
        aria-expanded="false"
    >
        {{ $label }}
        <svg class="w-4 h-4 inline ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown items -->
    <div class="hidden absolute top-full right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden z-50">
        @foreach ($items as $item)
            <a href="{{ url($item['url']) }}"
                @class([
                    'block w-full text-left px-4 py-2 text-sm transition',
                    'text-gray-700 hover:bg-green-50 hover:text-green-600',
                    'font-semibold' => request()->is(ltrim($item['url'], '/')),
                ])
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</div>
