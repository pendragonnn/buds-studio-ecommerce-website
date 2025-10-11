<!-- Auth Modal Overlay -->
<div x-show="$store.authModal.open"
     x-cloak
     x-data
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="$store.authModal.open = false"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    
    <!-- Modal Container -->
    <div x-show="$store.authModal.open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         @click.stop
         class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto overflow-hidden">
        
        <!-- Close Button -->
        <div class="relative">
            <button @click="$store.authModal.open = false" 
                    class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Header -->
        <div class="px-8 pt-8 pb-6 text-center">
            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2" 
                x-text="$store.authModal.tab === 'login' ? 'Welcome Back!' : 'Create Account'"></h2>
            <p class="text-gray-600" 
               x-text="$store.authModal.tab === 'login' ? 'Sign in to your account to continue' : 'Join us and start your journey'"></p>
        </div>

        <!-- Tab Switcher -->
        <div class="px-8 mb-6">
            <div class="flex bg-gray-100 rounded-xl p-1">
                <button @click="$store.authModal.tab = 'login'" 
                        :class="$store.authModal.tab === 'login' ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-600'"
                        class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all duration-200">
                    Sign In
                </button>
                <button @click="$store.authModal.tab = 'register'" 
                        :class="$store.authModal.tab === 'register' ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-600'"
                        class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all duration-200">
                    Sign Up
                </button>
            </div>
        </div>

        <!-- Forms Container -->
        <div class="px-8 pb-8 overflow-y-auto max-h-[45vh]">
            <!-- Login Form -->
            <div x-show="$store.authModal.tab === 'login'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-4">
                
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input id="login-email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="login-password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember" 
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm text-pink-600 hover:text-pink-800 font-semibold">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105">
                        Sign In
                    </button>
                </form>
            </div>

            <!-- Register Form -->
            <div x-show="$store.authModal.tab === 'register'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-4">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Full Name Field -->
                    <div>
                        <label for="register-name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>
                        <input id="register-name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               required 
                               autocomplete="name"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="register-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input id="register-email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label for="register-phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input id="register-phone" 
                               type="tel" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               required 
                               autocomplete="tel"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Enter your phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="register-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="register-password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Create a password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                               placeholder="Confirm your password">
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" 
                                   type="checkbox" 
                                   required
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                        </div>
                        <div class="ml-3">
                            <label for="terms" class="text-sm text-gray-600">
                                I agree to the 
                                <a href="#" class="text-pink-600 hover:text-pink-800 font-semibold">Terms of Service</a> 
                                and 
                                <a href="#" class="text-pink-600 hover:text-pink-800 font-semibold">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menangani error dan membuka modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada error, buka modal dengan tab yang sesuai
        @if ($errors->any())
            @if (request()->routeIs('login'))
                Alpine.store('authModal').open = true;
                Alpine.store('authModal').tab = 'login';
            @elseif (request()->routeIs('register'))
                Alpine.store('authModal').open = true;
                Alpine.store('authModal').tab = 'register';
            @endif
        @endif
    });
</script>