@props(['active'])

@php
$classes = ($active ?? false)
            // focused
            ? 'inline-flex items-center rounded-xl bg-white p-2 border border-gray-400 rounded-lg text-sm font-medium leading-5 text-black hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
            // not focused
            : 'inline-flex items-center rounded-xl bg-gray-100 p-2 border border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-800 hover:border-gray-300 hover:bg-white focus:outline-none focus:border-slate-gray-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
