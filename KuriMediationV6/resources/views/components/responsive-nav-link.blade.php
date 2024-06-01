@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-transparent text-start text-2xl font-bold text-white bg-blue-800 hover:bg-blue-800 hover:text-white focus:outline-none focus:text-gray-200 focus:bg-blue-600 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-transparent text-start text-2xl font-bold text-blue-800 bg-white hover:bg-blue-800 hover:text-white focus:outline-none focus:text-gray-200 focus:bg-blue-600 transition duration-150 ease-in-out'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
