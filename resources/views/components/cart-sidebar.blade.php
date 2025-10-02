{{-- Cart Sidebar --}}
<div x-data="{ 
    userId: document.body.dataset.userId || 'guest',
    cartItems: [],
    init() {
        this.loadCart();

        // Update setiap 100ms untuk detect perubahan localStorage
        setInterval(() => {
            this.loadCart();
        }, 100);

        // Listen storage event
        window.addEventListener('storage', (e) => {
            if (e.key === this.cartKey()) {
                this.loadCart();
            }
        });

        // Listen custom event jika ada
        window.addEventListener('cartUpdated', () => {
            this.loadCart();
        });
    },
    cartKey() {
        return `buds_cart_${this.userId}`;
    },
    loadCart() {
        this.cartItems = JSON.parse(localStorage.getItem(this.cartKey()) || '[]');
    }
}" x-show="$store.cart.open" x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed top-0 right-0 w-96 h-full bg-white shadow-2xl z-[1000] flex flex-col" x-cloak>

    <div class="bg-gradient-to-r from-pink-400 to-rose-400 flex justify-between items-center p-4 border-b">
        <h2 class="text-xl font-extrabold text-white">Shopping Cart</h2>
        <button @click="$store.cart.open = false" class="text-white font-bold hover:text-gray-100 transition-colors">
            ✕
        </button>
    </div>

    {{-- isi cart --}}
    <div id="cart-items" class="flex-1 overflow-y-auto p-4"></div>

    <p x-show="cartItems.length > 0" class="font-bold mb-4 w-80 text-center bg-gray-100 p-2 mx-auto rounded-xl">Total: <span id="cart-total">Rp 0</span></p>

    <button x-show="cartItems.length > 0" @click="$store.cart.open = false; $store.checkout.open = true"
        class="w-80 mb-3 mx-auto bg-[#ffcfdf] text-white font-bold px-8 py-3 rounded-full transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 hover:bg-[#e55a87] hover:shadow-[0_5px_15px_rgba(255,107,157,0.4)]">
        Checkout
    </button>

    {{-- Enhanced Empty Cart State --}}
    <div x-show="cartItems.length === 0" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="flex-1 flex flex-col items-center justify-center p-8 text-center">
        
        {{-- Decorative Background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
            <div class="absolute top-10 right-10 w-32 h-32 bg-pink-300 rounded-full"></div>
            <div class="absolute bottom-20 left-10 w-24 h-24 bg-rose-300 rounded-full"></div>
        </div>

        {{-- Animated Shopping Bag Icon --}}
        <div class="relative mb-6 animate-bounce">
            <div class="absolute inset-0 bg-pink-200 rounded-full blur-xl opacity-50"></div>
            <div class="relative bg-gradient-to-br from-pink-100 to-rose-100 p-8 rounded-full">
                <svg class="w-20 h-20 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>

        {{-- Text Content --}}
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Your Cart is Empty</h3>
        <p class="text-gray-500 mb-6 max-w-xs">
            Looks like you haven't added anything to your cart yet. Start shopping to fill it up!
        </p>

        {{-- Decorative Divider --}}
        <div class="flex items-center gap-2 mb-6 w-full max-w-xs">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-pink-300 to-transparent"></div>
            <span class="text-pink-400 text-xl">✨</span>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-pink-300 to-transparent"></div>
        </div>

        {{-- CTA Button --}}
        <a href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}"
            @click="$store.cart.open = false"
            class="group relative bg-gradient-to-r from-pink-400 to-rose-400 text-white font-bold px-8 py-3 mb-32 rounded-full transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-[0_10px_25px_rgba(255,107,157,0.4)] overflow-hidden">
            <span class="relative z-10 flex items-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Start Shopping
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-rose-400 to-pink-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </a>
    </div>
</div>

<x-checkout-modal />

<style>
    @keyframes gentle-bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-bounce {
        animation: gentle-bounce 2s ease-in-out infinite;
    }
</style>