@props([
    'level' => 'h2',
])

@php
    $cspacer = match ($level) {
        'h1' => 'space-y-4',
        'h2' => 'space-y-2',
        'h3' => 'space-y-2',
        'h4' => 'space-y-2',
        'h5' => 'space-y-2',
    };
@endphp

<header {!! $attributes->merge([
    'class' => "{$cspacer}",
]) !!}>
    @if ($level === 'h1')
        <h1 class="text-5xl font-bold text-primary ">
            {{ $title }}
        </h1>
    @elseif ($level === 'h2')
        <h2 class="text-2xl font-bold text-primary ">
            {{ $title }}
        </h2>
    @elseif ($level === 'h3')
        <h3 class="text-xl font-bold text-primary ">
            {{ $title }}
        </h3>
    @elseif ($level === 'h4')
        <h4 class="font-sans font-medium tracking-normal text-primary ">
            {{ $title }}
        </h4>
    @endif

    <p class="text-zinc-600">
        {{ $description }}
    </p>

    {{ $slot }}
</header>
