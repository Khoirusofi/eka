@props(['value'])

@if ($value)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
        @foreach ((array) $value as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
