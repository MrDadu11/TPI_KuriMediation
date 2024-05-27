@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-base text-blue-800 ']) }}>
    {{ $value ?? $slot }}
</label>
