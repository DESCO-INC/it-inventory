<td {{ $attributes->merge([
    'class' => "px-4 py-3 text-xs text-gray-800 truncate overflow-hidden whitespace-nowrap max-w-[150px]"
]) }}>
    {{ $slot }}
</td>
