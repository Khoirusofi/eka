@props([
    'value' => '',
    'size' => 'md',
    'expand' => false,
])

@php
    $sclass = match ($size) {
        'sm' => 'size-8',
        'md' => 'size-10',
        'lg' => 'size-12',
    };
@endphp

<div {!! $attributes->merge(['class' => 'flex items-center space-x-2 rounded-full']) !!}>
    <img class="rounded-full {{ $sclass }}"
        src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($value) . '&background=f1f1f1&format=svg&bold=true&color=0f4069' }}"
        alt="{{ $value }}">

    @if ($expand)
        <span class="font-medium text-primary whitespace-nowrap">
            {{ $value }}
        </span>
    @endif
</div>
