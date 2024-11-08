<select {!! $attributes->merge([
    'class' => 'form-select w-full px-4 py-2 frame focus:border-accent focus:ring-accent rounded-md text-sm',
]) !!}>
    {{ $slot }}
</select>
