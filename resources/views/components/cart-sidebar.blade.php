{{-- Cart Sidebar --}}
<div x-data="{ 
    cartItems: JSON.parse(localStorage.getItem('buds_cart') || '[]'),
    init() {
        // Update setiap 100ms untuk detect perubahan localStorage
        setInterval(() => {
            const newItems = JSON.parse(localStorage.getItem('buds_cart') || '[]');
            if (JSON.stringify(this.cartItems) !== JSON.stringify(newItems)) {
                this.cartItems = newItems;
            }
        }, 100);
        
        // Listen storage event
        window.addEventListener('storage', (e) => {
            if (e.key === 'buds_cart') {
                this.cartItems = JSON.parse(e.newValue || '[]');
            }
        });
        
        // Listen custom event jika ada
        window.addEventListener('cartUpdated', () => {
            this.cartItems = JSON.parse(localStorage.getItem('buds_cart') || '[]');
        });
    }
}" x-show="$store.cart.open" x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed top-0 right-0 w-96 h-full bg-white shadow-2xl z-50 flex flex-col" x-cloak>

    <div class="flex justify-between items-center p-4 border-b">
        <h2 class="text-lg font-bold">Shopping Cart</h2>
        <button @click="$store.cart.open = false" class="text-gray-500 hover:text-gray-700">
            ✕
        </button>
    </div>

    {{-- isi cart --}}
    <div id="cart-items" class="flex-1 overflow-y-auto p-4"></div>

    <div x-show="cartItems.length > 0" class="border-t p-4">
        <p class="font-bold mb-2">Total: <span id="cart-total">Rp 0</span></p>
        <button @click="$store.cart.open = false; $store.checkout.open = true"
            class="w-full bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600">
            Checkout
        </button>
    </div>

    <div x-show="cartItems.length === 0" class="flex-1 flex flex-col items-center justify-center p-4 text-gray-500">
        <p>Your cart is empty.</p>
    </div>
</div>

<x-checkout-modal />