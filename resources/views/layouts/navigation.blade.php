<nav x-data="{
         open: false,
         activeSection: '',
     }" x-init="
         const observer = new IntersectionObserver((entries) => {
             entries.forEach(entry => {
                 if (entry.isIntersecting) {
                     activeSection = entry.target.id;
                 }
             });
         }, {
             rootMargin: '-50% 0px -50% 0px'
         });

         document.querySelectorAll('section[id]').forEach(section => {
             observer.observe(section);
         });
     " class="bg-white border-b border-gray-100 shadow sticky top-0 w-full z-50">

    {{-- Kode untuk mobile hamburger menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            {{-- Logo --}}
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-1">
                    <x-application-logo class="block h-12 w-auto fill-current text-pink-500" />
                    <span class="font-bold text-xl text-[#e38593]">Buds Studio</span>
                </a>
            </div>

            {{-- Hamburger menu for mobile --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Center menu (desktop) --}}
            @if(auth()->guest() || auth()->user()->role->name === 'customer')
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <x-nav-link href="#hero">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link href="#products">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link href="#custom-order">
                        {{ __('Custom Order') }}
                    </x-nav-link>
                    <x-nav-link href="#contact">
                        {{ __('Contact') }}
                    </x-nav-link>

                    {{-- Only Admin: Dashboard link --}}
                    @auth
                        @if(auth()->user()->role->name === 'admin')
                            <x-nav-link :href="route('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            @elseif(auth()->user()->role->name === 'admin')
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        Admin Dashboard
                    </h1>
                </div>
            @endif

            {{-- Right side (desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @guest
                    {{-- Guest: Show login button --}}
                    <button @click="$store.authModal.open = true; $store.authModal.tab = 'login'"
                        class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition duration-200">
                        {{ __('Login / Register') }}
                    </button>
                @else
                    {{-- If logged in --}}
                    <div class="flex items-center space-x-4">
                        {{-- Customer: Show cart icon --}}
                        @if(auth()->user()->role->name === 'customer')
                            <button @click="$store.cart.open = true" class="relative">
                                <svg class="w-7 h-7 text-gray-700 hover:text-pink-500" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                                </svg>
                                {{-- badge jumlah item --}}
                                <span id="cart-count"
                                    class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    0
                                </span>
                            </button>
                        @endif

                        {{-- User dropdown (profile photo) --}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                        alt="{{ auth()->user()->name }}">
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                {{-- Admin shortcut --}}
                                @if(auth()->user()->role->name === 'admin')
                                    <x-dropdown-link :href="route('admin.dashboard')">
                                        {{ __('Admin Dashboard') }}
                                    </x-dropdown-link>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="sm:hidden h-[100dvh] fixed inset-x-0 bottom-0 top-20 bg-white border-t border-gray-100 shadow-lg p-4 overflow-y-auto">

        @if(auth()->guest() || auth()->user()->role->name === 'customer')
            <div class="space-y-1">
                <a href="#hero" @click="open = false"
                    class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                    Home
                </a>
                <a href="#products" @click="open = false"
                    class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                    Products
                </a>
                <a href="#custom-order" @click="open = false"
                    class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                    Custom Order
                </a>
                <a href="#contact" @click="open = false"
                    class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                    Contact
                </a>

                {{-- Customer: Cart --}}
                @auth
                    @if(auth()->user()->role->name === 'customer')
                        <button @click="$store.cart.open = true; open = false"
                            class="w-full flex items-center justify-between px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                            <span>Cart</span>
                            <span id="cart-count-mobile"
                                class="ml-2 bg-pink-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center">
                                0
                            </span>
                        </button>
                    @endif
                @endauth
            </div>
        @elseif(auth()->user()->role->name === 'admin')
            <div class="space-y-1">
                <h1 class="px-4 py-2 text-base font-semibold text-gray-800">
                    Admin Dashboard
                </h1>
                <a href="{{ route('admin.dashboard') }}" @click="open = false"
                    class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-lg">
                    Dashboard
                </a>
            </div>
        @endif

        <div class="mt-4 border-t border-gray-200 pt-4">
            @guest
                <button @click="$store.authModal.open = true; $store.authModal.tab = 'login'; open = false"
                    class="w-full bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition duration-200">
                    {{ __('Login / Register') }}
                </button>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        @click="open = false" class="block w-full text-center text-gray-700 hover:text-gray-900 transition">
                        {{ __('Log Out') }}
                    </a>
                </form>
            @endguest
        </div>
    </div>
</nav>

{{-- Cart Sidebar --}}
<x-cart-sidebar />