@props(['active', 'href'])

@php
    $activeClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-pink-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-pink-700 transition duration-150 ease-in-out';
    $defaultClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    // Ambil ID dari href, contoh: dari '#products' menjadi 'products'
    $linkId = ($href === route('home')) ? 'hero' : substr($href, 1);
@endphp

<a {{ $attributes->merge(['class' => '']) }}
    x-bind:class="{
        '{{ $activeClasses }}': activeSection === '{{ $linkId }}',
        '{{ $defaultClasses }}': activeSection !== '{{ $linkId }}'
    }"
    href="{{ $href }}">
    {{ $slot }}
</a>