<div {{ $attributes->merge(['class' => 'border border-gray-200 rounded']) }}>
    <table class="w-full table-fixed text-sm border-collapse">
        {{ $slot }}
    </table>
</div>
