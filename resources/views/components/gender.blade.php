@props([
    'value' => null,
])

<span>
    @if ($value === 'male')
        {{ __('Laki-laki') }}
    @elseif ($value === 'female')
        {{ __('Perempuan') }}
    @endif
</span>
