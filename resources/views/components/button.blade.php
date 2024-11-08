@props([
    'size' => 'md',
    'type' => 'button',
    'variant' => 'primary',
    'label' => null,
])

@php
    $cvariant = match ($variant) {
        'primary' => 'text-white bg-primary hover:bg-primary/90 focus:bg-primary/90 border-transparent',
        'accent' => 'text-white bg-accent hover:bg-accent/90 focus:bg-accent/90 border-transparent',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:bg-red-700 border-transparent',
        'link' => 'text-primary hover:underline focus:underline border-transparent',
        'outline' => 'text-accent hover:bg-accent/90 hover:text-white focus:bg-accent/90 focus:text-white',
    };

    $csize = match ($size) {
        'sm' => 'px-4 py-1.5',
        'md' => 'px-6 py-2',
        'lg' => 'px-8 py-3',
        'icon' => 'size-8 relative [&>svg]:icon',
    };
@endphp

<button
    {{ $attributes->merge([
        'type' => $type,
        'title' => $label,
        'class' => "inline-flex justify-center items-center text-sm font-medium gap-x-2 {$csize} {$cvariant} border rounded-full focus:outline-none transition ease-in-out duration-150 whitespace-nowrap tracking-wide [&>i]:icon",
    ]) }}>
    {{ $slot }}

    @if ($size === 'icon')
        <span class="sr-only">{{ $label }}</span>
    @endif
</button>
