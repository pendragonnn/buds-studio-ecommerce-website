@props(['active', 'href'])

@php
    $activeClasses = 'text-white inline-flex items-center px-1 py-1 border-b-2 border-pink-300 text-md font-medium leading-5 text-gray-900 focus:outline-none focus:border-pink-700 transition duration-150 ease-in-out';
    $defaultClasses = 'inline-flex items-center px-1 py-1 border-b-2 border-transparent text-md font-medium leading-5 text-gray-500 hover:text-[#ffd700] hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

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