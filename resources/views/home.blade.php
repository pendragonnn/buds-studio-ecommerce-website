<x-app-layout>
    {{-- Hero Section --}}
    <section id="hero" class="bg-pink-100 pt-32 pb-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Welcome to Buds Studio
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Discover our collection of premium press-on nails and phone staps. <br /> Express your style with our
                unique designs!
            </p>
            <a href="#products"
                class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg shadow-md transition">
                Shop Now
            </a>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="px-4 py-8 md:py-8 md:px-12 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Categories</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($categories as $category)
                    <div class="bg-white shadow-md rounded-3xl overflow-hidden hover:shadow-lg transition">
                        <img src="{{ $category->image_url ?? 'images/default-product.jpg' }}" alt="{{ $category->name }}"
                            class="w-full h-52 md:h-60 lg:h-80 object-cover">
                        <div class="p-8 flex flex-col justify-center items-center gap-5">
                            <h3 class="text-xl font-semibold text-gray-700">{{ $category->name }}</h3>
                            <p class="text-gray-500 text-center">{{ $category->description }}</p>
                            <a href="#products"
                                class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg shadow-md transition">View
                                Collection</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section id="products" class="px-4 py-8 md:py-8 md:px-12 bg-white">
        <div class="container mx-auto px-6 md:flex md:flex-col">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Products</h2>

            {{-- Product Filter Toggles --}}
            <div class="flex flex-row justify-center items-center gap-2 mb-10 bg-pink-700 p-2 rounded-3xl w-full md:w-fit md:self-center"
                id="filter-buttons">
                <button class="filter-btn py-3 px-6 rounded-2xl bg-pink-300 text-white font-semibold"
                    data-category="all">
                    All Products
                </button>
                @foreach($categories as $category)
                    <button
                        class="filter-btn py-3 px-6 rounded-2xl bg-pink-700 text-gray-200 hover:bg-pink-500 transition font-semibold"
                        data-category="{{ strtolower(str_replace(' ', '-', $category->name)) }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Product Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="product-list">
                @foreach($products as $product)
                    <div class="product-card relative shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition hidden"
                        data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">
                        {{-- Bagian Gambar --}}
                        <img src="{{ asset($product->image_url ?? 'images/default-product.jpg') }}"
                            alt="{{ $product->name }}" class="w-full h-[500px] object-cover">

                        {{-- Box Konten (Judul, Harga, Deskripsi, Tombol) --}}
                        <div class="absolute inset-x-0 bottom-0 bg-white rounded-t-2xl shadow-lg pt-6">
                            <div class="px-8 pb-4 flex flex-col justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h3>
                                    <p class="text-lg font-bold text-pink-500 mt-1">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>
                                </div>
                            </div>

                            {{-- Tombol Add to Cart --}}
                            @auth
                                @if(auth()->user()->role->name === 'customer')
                                    <div class="px-8 pb-8 pt-0">
                                        <button
                                            class="add-to-cart-btn bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg w-full transition">
                                            Add to Cart
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Load More Button --}}
            <div class="flex justify-center mt-10">
                <button id="load-more-btn"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full transition">
                    Lihat Lebih Banyak
                </button>
            </div>
        </div>
    </section>


    <!-- Custom Order Section -->
    <section id="custom-order"
        class="relative py-20 bg-gradient-to-br from-pink-50 via-rose-25 to-pink-100 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-200 rounded-full opacity-20 animate-pulse"></div>
            <div class="absolute top-1/2 -left-20 w-32 h-32 bg-rose-200 rounded-full opacity-15 animate-bounce"></div>
            <div class="absolute bottom-10 right-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-10"></div>
        </div>

        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                        </path>
                    </svg>
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-pink-700 bg-clip-text text-transparent mb-4">
                    Create Your Dream Design
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Transform your vision into reality with our personalized design service.
                    <span class="text-pink-600 font-semibold">Every detail matters</span> ✨
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Side - Content -->
                <div class="space-y-8">
                    <!-- Why Custom Order -->
                    <div
                        class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <span
                                class="w-8 h-8 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </span>
                            Why Choose Custom?
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Unique & Personal</h4>
                                    <p class="text-gray-600 text-sm">Express your personality with designs made just for
                                        you</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Perfect Gift</h4>
                                    <p class="text-gray-600 text-sm">Create meaningful gifts for your loved ones</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Quality Assured</h4>
                                    <p class="text-gray-600 text-sm">Handcrafted with premium materials and attention to
                                        detail</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Process Steps -->
                    <div class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <span
                                class="w-8 h-8 bg-gradient-to-r from-rose-400 to-pink-400 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                            How It Works
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    1</div>
                                <p class="text-gray-700">Share your ideas via WhatsApp</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    2</div>
                                <p class="text-gray-700">We discuss details & pricing</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    3</div>
                                <p class="text-gray-700">Your custom design is created</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    4</div>
                                <p class="text-gray-700">Delivered to your doorstep</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - CTA and Visual -->
                <div class="text-center lg:text-left">
                    <!-- Main Visual Element -->
                    <div class="relative mb-8">
                        <div
                            class="bg-gradient-to-r from-pink-400 via-rose-400 to-pink-500 rounded-3xl p-8 shadow-2xl transform rotate-1 hover:rotate-0 transition-transform duration-300">
                            <div class="bg-white rounded-2xl p-6 transform -rotate-1">
                                <div class="text-6xl mb-4">💅✨</div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Ready to Start?</h4>
                                <p class="text-gray-600 text-sm">Let's create something amazing together!</p>
                            </div>
                        </div>
                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-300 rounded-full animate-bounce"></div>
                        <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-pink-300 rounded-full animate-pulse"></div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="space-y-4">
                        <!-- Primary WhatsApp Button -->
                        <a href="https://wa.me/6281234567890?text=Hi%20Buds%20Studio!%20I'm%20interested%20in%20creating%20a%20custom%20design.%20Can%20we%20discuss%20the%20details?"
                            target="_blank"
                            class="group inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-lg">
                            <svg class="w-6 h-6 mr-3 group-hover:animate-bounce" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                            </svg>
                            Chat on WhatsApp
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>

                        <!-- Secondary Button -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                            <a href="#products"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-pink-300 text-pink-600 font-semibold rounded-xl hover:bg-pink-50 hover:border-pink-400 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                View Products
                            </a>

                            <a href="#contact"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-pink-300 text-pink-600 font-semibold rounded-xl hover:bg-pink-50 hover:border-pink-400 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Contact Info
                            </a>
                        </div>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Fast Response
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Free Consultation
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Quality Guaranteed
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section - Popular Custom Ideas -->
            <div class="mt-20">
                <h3 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-12">Popular Custom Ideas</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">💍</div>
                        <h4 class="font-bold text-gray-800 mb-2">Wedding Nails</h4>
                        <p class="text-gray-600 text-sm">Perfect for your special day</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🎉</div>
                        <h4 class="font-bold text-gray-800 mb-2">Party Themes</h4>
                        <p class="text-gray-600 text-sm">Match your celebration vibe</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🌸</div>
                        <h4 class="font-bold text-gray-800 mb-2">Seasonal Designs</h4>
                        <p class="text-gray-600 text-sm">Fresh looks for every season</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 text-center group">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">💝</div>
                        <h4 class="font-bold text-gray-800 mb-2">Gift Sets</h4>
                        <p class="text-gray-600 text-sm">Personalized gift packages</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Review Section</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>

    <body>

        <!-- Customer Review Section -->
        <section class="py-20 bg-gradient-to-br from-white via-pink-25 to-rose-50 relative overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-32 h-32 bg-pink-100 rounded-full opacity-30 animate-pulse"></div>
                <div class="absolute bottom-32 right-20 w-24 h-24 bg-rose-200 rounded-full opacity-20 animate-bounce">
                </div>
                <div class="absolute top-1/2 right-10 w-16 h-16 bg-pink-200 rounded-full opacity-25"></div>
                <div class="absolute bottom-20 left-1/4 w-20 h-20 bg-rose-100 rounded-full opacity-20"></div>
            </div>

            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h2
                        class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-pink-700 bg-clip-text text-transparent mb-4">
                        Our Customer Reviews
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        See what our amazing customers say about their
                        <span class="text-pink-600 font-semibold">beautiful experiences</span> with us ✨
                    </p>

                    <!-- Overall Rating Display -->
                    <div class="flex items-center justify-center mt-8 space-x-3">
                        <div class="flex space-x-1">
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-700">4.9</span>
                        <span class="text-gray-500">from 150+ reviews</span>
                    </div>
                </div>

                <!-- Reviews Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" x-data="reviewCarousel()">
                    <!-- Review Card 1 -->
                    <div class="group">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 h-full">
                            <!-- Stars -->
                            <div class="flex justify-center space-x-1 mb-6">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Quote Icon -->
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-full">
                                    <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <p class="text-gray-700 text-center leading-relaxed mb-8 italic">
                                "Perfect for my wedding! The bride nail set was exactly what I dreamed of. The attention
                                to detail is incredible and they stayed perfect throughout the entire ceremony and
                                reception. Thank you for making my special day even more beautiful!"
                            </p>

                            <!-- Customer Info -->
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mx-auto mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">J</span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">@JessicaW</h4>
                                <p class="text-pink-600 text-sm font-semibold">Verified Customer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 4 (Hidden on mobile, visible on lg) -->
                    <div class="group hidden lg:block">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 h-full">
                            <!-- Stars -->
                            <div class="flex justify-center space-x-1 mb-6">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Quote Icon -->
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-full">
                                    <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <p class="text-gray-700 text-center leading-relaxed mb-8 italic">
                                "Great value for money! I've been buying from different brands but Buds Studio has the
                                best quality-to-price ratio. The designs are trendy and unique. My friends always ask
                                where I get my nails done!"
                            </p>

                            <!-- Customer Info -->
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-rose-400 to-pink-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">L</span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">@LisaK</h4>
                                <p class="text-pink-600 text-sm font-semibold">Verified Customer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 5 (Hidden on mobile, visible on lg) -->
                    <div class="group hidden lg:block">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 h-full">
                            <!-- Stars -->
                            <div class="flex justify-center space-x-1 mb-6">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Quote Icon -->
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-full">
                                    <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <p class="text-gray-700 text-center leading-relaxed mb-8 italic">
                                "The custom phone straps are adorable! I ordered matching ones for me and my bestie. The
                                quality is amazing and they're so functional. Will definitely order more designs in the
                                future!"
                            </p>

                            <!-- Customer Info -->
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-400 rounded-full mx-auto mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">C</span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">@ChloeM</h4>
                                <p class="text-pink-600 text-sm font-semibold">Verified Customer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 6 (Hidden on mobile, visible on lg) -->
                    <div class="group hidden lg:block">
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 h-full">
                            <!-- Stars -->
                            <div class="flex justify-center space-x-1 mb-6">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Quote Icon -->
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-full">
                                    <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Review Text -->
                            <p class="text-gray-700 text-center leading-relaxed mb-8 italic">
                                "Ordered for my daughter's sweet 16 party and she absolutely loved them! The teenage
                                girls were all obsessed with the cute designs. Great quality and perfect for young
                                customers too!"
                            </p>

                            <!-- Customer Info -->
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-rose-400 to-pink-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">D</span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg">@DianaP</h4>
                                <p class="text-pink-600 text-sm font-semibold">Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- Contact Section --}}
        <section id="contact"
            class="relative py-20 bg-gradient-to-br from-pink-50 via-rose-25 to-white overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-10 right-20 w-32 h-32 bg-pink-200 rounded-full opacity-20 animate-pulse"></div>
                <div class="absolute bottom-20 left-10 w-24 h-24 bg-rose-200 rounded-full opacity-25 animate-bounce">
                </div>
                <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-pink-300 rounded-full opacity-15"></div>
                <div class="absolute bottom-32 right-1/3 w-20 h-20 bg-rose-100 rounded-full opacity-30"></div>
            </div>

            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h2
                        class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-600 via-rose-500 to-pink-700 bg-clip-text text-transparent mb-4">
                        Get in Touch
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        We'd love to hear from you! Whether you have questions, custom requests, or just want to say
                        hello
                        <span class="text-pink-600 font-semibold">we're here for you</span> 💕
                    </p>
                </div>

                <!-- Main Content Grid -->
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Left Side - Contact Information -->
                    <div class="space-y-8">
                        <!-- Quick Contact Cards -->
                        <div class="space-y-6">
                            <!-- WhatsApp Card -->
                            <div
                                class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300 group">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">WhatsApp</h3>
                                        <p class="text-gray-600 text-sm mb-3">Get instant response for custom orders and
                                            inquiries</p>
                                        <p class="text-lg font-semibold text-gray-800 mb-4">+62 812-3456-7890</p>
                                        <a href="https://wa.me/6281234567890?text=Hi%20Buds%20Studio!%20I%20have%20a%20question%20about%20your%20products."
                                            target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                            </svg>
                                            Chat Now
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Card -->
                            <div
                                class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100 hover:shadow-2xl transition-all duration-300 group">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r from-pink-400 to-rose-400 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">Email</h3>
                                        <p class="text-gray-600 text-sm mb-3">Send us detailed inquiries or business
                                            partnerships</p>
                                        <p class="text-lg font-semibold text-gray-800 mb-4">buds.studio@gmail.com</p>
                                        <a href="mailto:buds.studio@gmail.com?subject=Inquiry%20from%20Website&body=Hi%20Buds%20Studio,%0A%0AI%20have%20a%20question%20about..."
                                            class="inline-flex items-center px-4 py-2 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Send Email
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span
                                    class="w-8 h-8 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </span>
                                Follow Our Journey
                            </h3>

                            <p class="text-gray-600 mb-6">Stay updated with our latest designs and behind-the-scenes
                                content!</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Instagram -->
                                <a href="https://instagram.com/buds.studio" target="_blank"
                                    class="group flex items-center p-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-2xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    <div
                                        class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 group-hover:bg-opacity-30 transition-all">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.017 0C8.396 0 7.954.01 6.74.048 2.291.19.28 2.205.14 6.651c-.038 1.213-.048 1.657-.048 5.283s.01 4.07.048 5.284c.139 4.445 2.15 6.46 6.599 6.602 1.214.037 1.658.047 5.282.047s4.068-.01 5.282-.047c4.45-.142 6.46-2.157 6.602-6.602.037-1.214.047-1.657.047-5.284s-.01-4.07-.047-5.283C23.765 2.204 21.75.19 17.3.048 16.086.01 15.643 0 12.017 0zm0 2.17c3.557 0 3.97.01 5.37.05 3.37.15 4.926 1.706 5.077 5.078.04 1.4.05 1.812.05 5.369s-.01 3.97-.05 5.37c-.151 3.37-1.707 4.925-5.077 5.077-1.4.04-1.813.05-5.37.05s-3.97-.01-5.37-.05c-3.371-.152-4.927-1.707-5.078-5.077-.04-1.4-.05-1.813-.05-5.37s.01-3.97.05-5.37C4.717 3.847 6.273 2.291 9.646 2.14c1.4-.04 1.813-.05 5.37-.05zM5.838 12.017a6.179 6.179 0 1112.358 0 6.179 6.179 0 01-12.358 0zM12.017 16a3.823 3.823 0 110-7.646 3.823 3.823 0 010 7.646zm6.991-10.846a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Instagram</div>
                                        <div class="text-sm opacity-90">@buds.studio</div>
                                    </div>
                                </a>

                                <!-- Shopee -->
                                <a href="https://shopee.co.id/buds.studio" target="_blank"
                                    class="group flex items-center p-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    <div
                                        class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 group-hover:bg-opacity-30 transition-all">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M16.5 21.75h-9c-3.105 0-5.625-2.52-5.625-5.625v-8.25C1.875 4.77 4.395 2.25 7.5 2.25h9c3.105 0 5.625 2.52 5.625 5.625v8.25c0 3.105-2.52 5.625-5.625 5.625zM7.5 3.75C5.223 3.75 3.375 5.598 3.375 7.875v8.25c0 2.277 1.848 4.125 4.125 4.125h9c2.277 0 4.125-1.848 4.125-4.125v-8.25c0-2.277-1.848-4.125-4.125-4.125h-9z" />
                                            <path
                                                d="M12 18c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6zm0-10.5c-2.481 0-4.5 2.019-4.5 4.5s2.019 4.5 4.5 4.5 4.5-2.019 4.5-4.5-2.019-4.5-4.5-4.5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Shopee</div>
                                        <div class="text-sm opacity-90">buds.studio</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Operating Hours -->
                        <div class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-pink-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Response Time
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">WhatsApp</span>
                                    <span class="font-semibold text-gray-800">Within 1 hour</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-semibold text-gray-800">Within 24 hours</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Social Media</span>
                                    <span class="font-semibold text-gray-800">Within 2 hours</span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-pink-50 rounded-xl">
                                <p class="text-pink-700 text-sm font-semibold">📞 We're most active between 9 AM - 9 PM
                                    WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Contact Form -->
                    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-2xl border border-pink-100">
                        <div class="mb-8">
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Send us a Message</h3>
                            <p class="text-gray-600">Have a specific question? Fill out the form below and we'll get
                                back to you soon!</p>
                        </div>

                        <form class="space-y-6" x-data="contactForm()" @submit.prevent="submitForm">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Your Name *
                                </label>
                                <input type="text" id="name" x-model="form.name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Enter your full name">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" id="email" x-model="form.email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Enter your email">
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" x-model="form.phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                    placeholder="Enter your phone number">
                            </div>

                            <!-- Subject Field -->
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Subject *
                                </label>
                                <select id="subject" x-model="form.subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Select a topic</option>
                                    <option value="custom-order">Custom Order Inquiry</option>
                                    <option value="product-question">Product Question</option>
                                    <option value="shipping">Shipping & Delivery</option>
                                    <option value="partnership">Business Partnership</option>
                                    <option value="complaint">Complaint or Issue</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Message Field -->
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Message *
                                </label>
                                <textarea id="message" x-model="form.message" required rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 resize-none"
                                    placeholder="Tell us more about your inquiry..."></textarea>
                            </div>

                            <!-- Privacy Checkbox -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="privacy" type="checkbox" x-model="form.privacy" required
                                        class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                                </div>
                                <div class="ml-3">
                                    <label for="privacy" class="text-sm text-gray-600">
                                        I agree to the collection and processing of my personal data for communication
                                        purposes. *
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" :disabled="submitting"
                                :class="submitting ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 transform hover:scale-105'"
                                class="w-full text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center">
                                <span x-show="!submitting" class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Message
                                </span>
                                <span x-show="submitting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>

                            <!-- Success Message -->
                            <div x-show="showSuccess" x-transition
                                class="p-4 bg-green-100 border border-green-200 rounded-xl text-green-700 text-center">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="font-semibold">Message sent successfully!</p>
                                <p class="text-sm">We'll get back to you within 24 hours.</p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bottom Section - FAQ or Additional Info -->
                <div class="mt-20">
                    <div class="bg-white rounded-3xl p-8 shadow-xl border border-pink-100">
                        <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Frequently Asked Questions</h3>

                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-6" x-data="{ openFaq: null }">
                                <!-- FAQ 1 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 1 ? null : 1"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">How long does shipping take?</span>
                                        <svg :class="openFaq === 1 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 1" x-transition class="mt-2 text-gray-600">
                                        Regular shipping takes 3-5 business days within Indonesia. Express shipping is
                                        available for 1-2 days delivery.
                                    </div>
                                </div>

                                <!-- FAQ 2 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 2 ? null : 2"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">Do you accept custom designs?</span>
                                        <svg :class="openFaq === 2 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 2" x-transition class="mt-2 text-gray-600">
                                        Yes! We love creating custom designs. Just contact us via WhatsApp with your
                                        ideas and we'll discuss the details and pricing.
                                    </div>
                                </div>

                                <!-- FAQ 3 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 3 ? null : 3"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">What payment methods do you
                                            accept?</span>
                                        <svg :class="openFaq === 3 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 3" x-transition class="mt-2 text-gray-600">
                                        We accept bank transfers, e-wallets (OVO, GoPay, DANA), and payments through our
                                        Shopee store.
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6" x-data="{ openFaq: null }">
                                <!-- FAQ 4 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 4 ? null : 4"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">How long do press-on nails
                                            last?</span>
                                        <svg :class="openFaq === 4 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 4" x-transition class="mt-2 text-gray-600">
                                        With proper application and care, our press-on nails can last 1-2 weeks. We
                                        include application instructions with every order.
                                    </div>
                                </div>

                                <!-- FAQ 5 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 5 ? null : 5"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">Can I return or exchange
                                            products?</span>
                                        <svg :class="openFaq === 5 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 5" x-transition class="mt-2 text-gray-600">
                                        Due to hygiene reasons, we don't accept returns for nail products. However, if
                                        there's a quality issue, please contact us within 24 hours of delivery.
                                    </div>
                                </div>

                                <!-- FAQ 6 -->
                                <div class="border-b border-gray-200 pb-4">
                                    <button @click="openFaq = openFaq === 6 ? null : 6"
                                        class="w-full text-left flex justify-between items-center py-2">
                                        <span class="font-semibold text-gray-800">Do you ship internationally?</span>
                                        <svg :class="openFaq === 6 ? 'rotate-180' : ''"
                                            class="w-5 h-5 text-pink-500 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="openFaq === 6" x-transition class="mt-2 text-gray-600">
                                        Currently we only ship within Indonesia. International shipping may be available
                                        for larger orders - please contact us for details.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final CTA -->
                <div class="text-center mt-16">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Still have questions?</h3>
                    <p class="text-lg text-gray-600 mb-6">
                        Don't hesitate to reach out! We're here to help make your nail dreams come true ✨
                    </p>
                    <a href="https://wa.me/6281234567890?text=Hi%20Buds%20Studio!%20I%20have%20some%20questions%20about%20your%20products."
                        target="_blank"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                        </svg>
                        Chat with Us Now
                    </a>
                </div>
            </div>
        </section>

        @include('components.footer')

        {{-- Auth Modal --}}
        @include('components.auth-modal')

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const products = document.querySelectorAll('.product-card');
                const filterButtons = document.querySelectorAll('.filter-btn');
                const loadMoreBtn = document.getElementById('load-more-btn');
                let visibleCount = 6;
                let activeCategory = 'all';

                function showProducts(category) {
                    let shown = 0;
                    activeCategory = category;

                    products.forEach(product => {
                        const productCategory = product.getAttribute('data-category');
                        const match = (category === 'all' || productCategory === category);

                        if (match && shown < visibleCount) {
                            product.style.display = 'block';
                            shown++;
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    // Atur visibilitas tombol load more
                    const totalVisible = [...products].filter(p =>
                        category === 'all' || p.getAttribute('data-category') === category
                    ).length;

                    loadMoreBtn.style.display = (visibleCount >= totalVisible) ? 'none' : 'block';
                }

                function updateButtonStyles(category) {
                    filterButtons.forEach(btn => {
                        if (btn.getAttribute('data-category') === category) {
                            btn.classList.add('bg-pink-300', 'text-white');
                            btn.classList.remove('bg-pink-700', 'text-gray-200');
                        } else {
                            btn.classList.add('bg-pink-700', 'text-gray-200');
                            btn.classList.remove('bg-pink-300', 'text-white');
                        }
                    });
                }

                // Event filter
                filterButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        visibleCount = 6;
                        const category = btn.getAttribute('data-category');
                        showProducts(category);
                        updateButtonStyles(category);
                    });
                });

                // Event load more
                loadMoreBtn.addEventListener('click', () => {
                    visibleCount += 6;
                    showProducts(activeCategory);
                });

                // Init
                showProducts('all');
                updateButtonStyles('all');
            });

            function contactForm() {
                return {
                    form: {
                        name: '',
                        email: '',
                        phone: '',
                        subject: '',
                        message: '',
                        privacy: false
                    },
                    submitting: false,
                    showSuccess: false,

                    submitForm() {
                        this.submitting = true;

                        // Simulate form submission (replace with actual form handling)
                        setTimeout(() => {
                            this.submitting = false;
                            this.showSuccess = true;

                            // Reset form
                            this.form = {
                                name: '',
                                email: '',
                                phone: '',
                                subject: '',
                                message: '',
                                privacy: false
                            };

                            // Hide success message after 5 seconds
                            setTimeout(() => {
                                this.showSuccess = false;
                            }, 5000);
                        }, 2000);
                    }
                }
            }
        </script>

</x-app-layout>