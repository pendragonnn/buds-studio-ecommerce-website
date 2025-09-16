<x-app-layout>
    {{-- Hero Section --}}
    <section id="hero" class="bg-pink-100 pt-32 pb-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Welcome to Buds Studio
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Handcrafted press-on nails & stylish phone straps, made with love ✨
            </p>
            <a href="#products" 
               class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg shadow-md transition">
                Shop Now
            </a>
        </div>
    </section>

    {{-- Products Section --}}
    <section id="products" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Products</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($products as $product)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                        <img src="{{ asset($product->image_url ?? 'images/default-product.jpg') }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover">
                        <div class="p-4 flex flex-col justify-center items-center gap-3">
                            <h3 class="text-xl font-semibold text-gray-700">{{ $product->name }}</h3>
                            <p class="text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <p class="text-pink-600 font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            @auth
                                @if(auth()->user()->role->name === 'customer')
                                    <button class="mt-4 bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg w-full">
                                        Add to Cart
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Custom Order Section --}}
    <section id="custom-order" class="py-16 bg-pink-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Want Something Custom?</h2>
            <p class="text-gray-600 mb-6">
                At Buds Studio, you can request personalized designs that fit your style.  
                Perfect gift ideas or just something special for yourself 💝
            </p>
            <a href="#contact" 
               class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg shadow-md transition">
                Contact Us
            </a>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Get in Touch</h2>
            
            <div class="max-w-xl mx-auto text-center">
                <p class="text-gray-600 mb-4">
                    Have questions or want to make a custom request? Reach us anytime!
                </p>
                <p class="text-gray-800 font-semibold">📧 buds.studio@gmail.com</p>
                <p class="text-gray-800 font-semibold">📱 +62 812-3456-7890</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <a href="#" class="text-pink-500 hover:text-pink-600">Instagram</a>
                    <a href="#" class="text-pink-500 hover:text-pink-600">Shopee</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
