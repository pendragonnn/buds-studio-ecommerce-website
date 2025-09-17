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
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
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
    </script>

</x-app-layout>