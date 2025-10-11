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
    <x-home.customer-review :testimonies="$testimonies" :averageRating="$averageRating" :totalReviews="$totalReviews" />

    {{-- Contact Section --}}
    <x-home.contact />

    {{-- Footer --}}
    @include('components.footer')

    {{-- Auth Modal --}}
    @include('components.auth-modal')

    <!-- Floating WhatsApp Button -->
    @auth
        @if(auth()->user()->role->name === 'customer')
            {{-- Tombol WhatsApp untuk Customer --}}
            <a href="https://wa.me/6281809740724?text=Hello%20Buds%20Studio!%20I%20want%20to%20ask%20about%20your%20products%20%F0%9F%92%95"
                target="_blank" class="fixed bottom-6 right-6 z-50 group">
                @include('components.whatsapp-button')
            </a>
        @endif
    @endauth

    @guest
        {{-- Tombol WhatsApp untuk Guest --}}
        <a href="https://wa.me/6281809740724?text=Hello%20Buds%20Studio!%20I%20want%20to%20ask%20about%20your%20products%20%F0%9F%92%95"
            target="_blank" class="fixed bottom-6 right-6 z-50 group">
            @include('components.whatsapp-button')
        </a>
    @endguest

</x-app-layout>