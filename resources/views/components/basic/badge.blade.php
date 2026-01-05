@props([
    'variant' => 'info', // default variant
])

@php
// Define allowed variants
$allowedVariants = ['info', 'success', 'error', 'warning', 'active', 'unassigned', 'defective', 'disposed'];

// Validate the variant
$variant = in_array($variant, $allowedVariants) ? $variant : 'info';

// Map variants to Tailwind classes
$colors = [
    'info'    => 'bg-blue-100 text-blue-600',
    'success' => 'bg-green-100 text-green-600',
    'error'   => 'bg-red-100 text-red-600',
    'warning' => 'bg-yellow-100 text-yellow-600',
    'active' => 'bg-blue-200 text-blue-600',
    'unassigned' => 'bg-orange-200 text-orange-400',
    'defective' => 'bg-yellow-200 text-yellow-600',
    'disposed' => 'bg-red-200 text-red-600',
];

$colorClass = $colors[$variant];
@endphp

<span {{ $attributes->merge([
    'class' => "$colorClass text-[10px] font-semibold px-1.5 py-0.5 rounded-full inline-block"
]) }}>
    {{ $slot }}
</span>
