<x-app-layout>
    {{-- resources/views/admin/dashboard.blade.php --}}
    <div class="min-h-screen bg-gray-100" x-data="{ tab: 'products' }">
        {{-- Main --}}
        <main class="max-w-6xl mx-auto px-6 py-8">
            {{-- Panel Header --}}
            <div class="bg-white shadow rounded-xl p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Admin Dashboard</h2>
                <p class="text-gray-500">Manage your products and orders</p>

                {{-- Tabs --}}
                <div class="flex gap-3 mt-4">
                    <button @click="tab = 'products'"
                        :class="tab === 'products' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-lg font-medium">
                        Products
                    </button>
                    <button @click="tab = 'orders'"
                        :class="tab === 'orders' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-lg font-medium">
                        Orders
                    </button>
                    <button @click="tab = 'users'"
                        :class="tab === 'users' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-lg font-medium">
                        Users
                    </button>
                    <button @click="tab = 'ratings'"
                        :class="tab === 'ratings' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-lg font-medium">
                        Ratings
                    </button>
                </div>
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