@props([
    'value' => null,
])

@php
    $cvariant = match ($value) {
        'admin' => 'bg-accent text-white',
        'published' => 'bg-accent text-white',
        'cancelled' => 'bg-zinc-100 text-red-600',
        'finished' => 'bg-zinc-100 text-green-600',
        'confirmed' => 'bg-accent text-white',
        'janji temu buka' => 'bg-accent text-white',
        'janji temu tutup' => 'bg-zinc-100 text-red-600',
        default => 'bg-zinc-100 text-primary',
    };
@endphp


<span {!! $attributes->merge([
    'class' => "px-3 py-1 rounded-full uppercase text-xs font-semibold {$cvariant}",
]) !!}>
    {{ \Illuminate\Support\Str::title($value) }}
</span>
