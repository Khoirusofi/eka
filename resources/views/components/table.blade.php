@props([
    'variant' => 'primary',
])

@php
    $cvariant = match ($variant) {
        'primary' => 'bg-primary text-white',
        'accent' => 'bg-accent text-white',
    };
@endphp

<style>
    .no-scrollbar::-webkit-scrollbar {
        width: 0.4rem;
        background: #ffffff;
        width: 4px;
        height: 4px;
    }

    .no-scrollbar::-webkit-scrollbar-thumb {
        background: #365949;
        border-radius: 0.3rem;
    }
</style>

<div class="w-full no-scrollbar overflow-x-auto rounded-lg frame ">
    <table class="w-full text-sm table-auto  [&_:is(th, td)]:px-8 [&_:is(th, td)]:py-2">
        <thead class="{{ $cvariant }}">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>
