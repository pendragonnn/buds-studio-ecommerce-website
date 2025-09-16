<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Left side --}}
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (admin only for now) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->role->name === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    {{-- Guest: Show login button --}}
                    <a href="{{ route('login') }}" 
                       class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
                        {{ __('Login / Register') }}
                    </a>
                @else
                    {{-- If logged in --}}
                    <div class="flex items-center space-x-4">
                        {{-- Customer: Show cart icon --}}
                        @if(auth()->user()->role->name === 'customer')
                            <a href="#" class="relative">
                                <svg class="w-6 h-6 text-gray-700 hover:text-pink-500" fill="none" 
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
                                </svg>
                            </a>
                        @endif

                        {{-- User dropdown (profile photo) --}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <p>{{ auth()->user()->name }}</p>
                                <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none">
                                    <img class="h-8 w-8 rounded-full object-cover" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" 
                                         alt="{{ auth()->user()->name }}">
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                {{-- If admin: add Dashboard shortcut --}}
                                @if(auth()->user()->role->name === 'admin')
                                    <x-dropdown-link :href="route('admin.dashboard')">
                                        {{ __('Admin Dashboard') }}
                                    </x-dropdown-link>
                                @endif

                                <!-- Logout -->
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
</nav>
