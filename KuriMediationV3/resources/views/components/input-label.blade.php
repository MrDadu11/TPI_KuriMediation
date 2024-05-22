@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-base text-blue-800 ']) }}>
    {{ $value ?? $slot }}
</label>
