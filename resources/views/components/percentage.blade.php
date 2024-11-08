@props([
    'dividend' => null,
    'divisor' => null,
    'precision' => null,
])

@php
    $value = $dividend / $divisor;
    $precision = $precision ?? 2;
@endphp

<span>
    {{ number_format($value * 100, $precision) . '%' }}
</span>
