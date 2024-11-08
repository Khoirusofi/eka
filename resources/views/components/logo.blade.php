@props([
    'variant' => 'color',
    'size' => 'md',
])

@php
    $csize = match ($size) {
        'sm' => 'h-8',
        'md' => 'h-10',
        'lg' => 'h-14',
    };

    $svariant = match ($variant) {
        'color' => 'images/logo/logo.png',
        'black' => 'images/logo/logo.png',
        'navy' => 'images/logo/logo.png',
        'pink' => 'images/logo/logo.png',
        'white' => 'images/logo/logo.png',
    };

    $textsize = match ($size) {
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
    };

    $textcolor = match ($variant) {
        'color' => 'text-primary first:text-accent',
        'black' => 'text-zinc-900',
        'navy' => 'text-primary',
        'pink' => 'text-accent',
        'white' => 'text-zinc-50',
    };
@endphp

<div class="flex items-center gap-2">
    <img src="{{ asset($svariant) }}" alt="Logo" class="{{ $csize }} object-contain">
    <span class="{{ $textsize }} {{ $textcolor }} font-bold uppercase">
        {{ config('app.name', 'Laravel') }}
    </span>
</div>
