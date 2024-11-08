@props([
    'value' => null,
])

@php
    \Carbon\Carbon::setLocale('id'); // Mengatur locale ke bahasa Indonesia
    $date = \Carbon\Carbon::parse($value);
@endphp

<time datetime="{{ $date->toDateTimeString() }}">
    {{ $date->translatedFormat('l, d F Y') }}
</time>
