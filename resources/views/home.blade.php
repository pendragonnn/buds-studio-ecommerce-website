<x-app-layout>
    {{-- Hero Section --}}
    <x-home.hero />

    {{-- Categories Section --}}
    <x-home.categories :categories="$categories" />

    {{-- Products Section --}}
    <x-home.products :products="$products" :categories="$categories" />

    <!-- Custom Order Section -->
    <x-home.custom-order />

    <!-- Customer Review Section -->
    <x-home.customer-review />

    {{-- Contact Section --}}
    <x-home.contact />
    
    {{-- Footer --}}
    @include('components.footer')

    {{-- Auth Modal --}}
    @include('components.auth-modal')
</x-app-layout>