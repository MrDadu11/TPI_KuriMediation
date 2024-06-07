@props(['active'])

@php
$classes = ($active ?? false)
            // focused
            ? 'inline-flex items-center bg-blue-800 p-2 border border-gray-400 text-md font-bold leading-5 text-white hover:border-black focus:border-gray-300 focus:text-white focus:bg-blue-800 focus:border-blue-800 transition duration-150 ease-in-out'
            // not focused
            : 'inline-flex items-center bg-gray-100 p-2 border border-transparent text-md font-bold leading-5 text-blue-800 hover:text-white hover:bg-blue-800 focus:outline-none focus:text-white focus:bg-blue-800 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
