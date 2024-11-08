@props(['for', 'value'])

<label {{ $attributes->merge([
    'for' => $for,
    'class' => 'block text-sm text-primary mb-1',
]) }}>
    {{ $value }}
</label>
