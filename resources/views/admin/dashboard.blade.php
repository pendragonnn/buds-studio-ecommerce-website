<x-app-layout>
    {{-- resources/views/admin/dashboard.blade.php --}}
    <div class="min-h-screen bg-gray-100" x-data="{ 
        tab: new URLSearchParams(window.location.search).get('tab') || 'products',
        setTab(newTab) {
            this.tab = newTab;
            const url = new URL(window.location.href);
            url.searchParams.set('tab', newTab);
            window.history.pushState({}, '', url);
        }
     }">
        {{-- Main --}}
        <main class="max-w-6xl mx-auto px-6 py-8">
            {{-- Panel Header --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Buds Studio - Admin Panel</h2>
                <p class="text-gray-500">Manage your products and orders</p>
            </div>

            <div class="flex gap-2 my-4">
                <button @click="setTab('products')" :class="tab === 'products' 
            ? 'bg-[#BE3455] text-white shadow-sm' 
            : 'bg-white text-gray-600 border border-gray-300'"
                    class="px-5 py-2.5 rounded-full font-medium text-sm transition">
                    Products
                </button>

                <button @click="setTab('orders')" :class="tab === 'orders' 
            ? 'bg-[#BE3455] text-white shadow-sm' 
            : 'bg-white text-gray-600 border border-gray-300'"
                    class="px-5 py-2.5 rounded-full font-medium text-sm transition">
                    Orders
                </button>

                <button @click="setTab('users')" :class="tab === 'users' 
            ? 'bg-[#BE3455] text-white shadow-sm' 
            : 'bg-white text-gray-600 border border-gray-300'"
                    class="px-5 py-2.5 rounded-full font-medium text-sm transition">
                    Users
                </button>

                <button @click="setTab('ratings')" :class="tab === 'ratings' 
            ? 'bg-[#BE3455] text-white shadow-sm' 
            : 'bg-white text-gray-600 border border-gray-300'"
                    class="px-5 py-2.5 rounded-full font-medium text-sm transition">
                    Ratings
                </button>
            </div>

            {{-- Content --}}
            <div>
                {{-- Include per tab --}}
                <div x-show="tab === 'products'" x-transition>
                    @include('admin.tabs.products')
                </div>

                <div x-show="tab === 'orders'" x-transition>
                    @include('admin.tabs.orders')
                </div>
                <div x-show="tab === 'users'" x-transition>
                    @include('admin.tabs.users')
                </div>
                <div x-show="tab === 'ratings'" x-transition>
                    @include('admin.tabs.ratings')
                </div>
            </div>
        </main>
    </div>
</x-app-layout>