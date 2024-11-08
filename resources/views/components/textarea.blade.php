@props(['disabled' => false, 'value' => null])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full px-4 py-2 bg-zinc-50 frame focus:border-accent focus:ring-accent rounded-md text-sm',
]) !!}>{!! $value ?? '' !!}</textarea>
