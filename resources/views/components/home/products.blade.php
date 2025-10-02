<section id="products" class="px-4 py-8 md:py-8 md:px-12 bg-white">
  <div class="container mx-auto px-6 md:flex md:flex-col">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Products</h2>

    {{-- Product Filter Toggles --}}
    <div
      class="flex flex-row justify-center items-center gap-2 mb-10 bg-[linear-gradient(135deg,#ffddec,#daddff)] p-2 rounded-3xl w-full md:w-fit md:self-center"
      id="filter-buttons">
      <button class="filter-btn py-3 px-6 rounded-2xl bg-pink-300 text-white font-semibold" data-category="all">
        All Products
      </button>
      @foreach($categories as $category)
        <button
          class="filter-btn py-3 px-6 rounded-2xl bg-white/20 border border-white text-slate-500 hover:bg-pink-200 transition font-semibold"
          data-category="{{ strtolower(str_replace(' ', '-', $category->name)) }}">
          {{ $category->name }}
        </button>
      @endforeach
    </div>

    {{-- Product Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="product-list">
      @foreach($products as $product)
        <div
          class="bg-white rounded-[15px] shadow-[0_5px_20px_rgba(0,0,0,0.1)] overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_15px_40px_rgba(0,0,0,0.15)] product-card hidden"
          data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">

          {{-- Gambar --}}
          <div class="relative h-56 bg-gray-100">
            <img src="{{ asset($product->image_url ?? 'images/default-product.jpg') }}" alt="{{ $product->name }}"
              class="w-full h-full object-cover">
            {{-- Badge contoh --}}
            @if($product->is_new)
              <span
                class="absolute top-3 left-3 bg-[#ffcfdf] text-white px-3 py-1 rounded-full text-xs font-bold">New</span>
            @elseif($product->is_popular)
              <span
                class="absolute top-3 left-3 bg-[#ffcfdf] text-white px-3 py-1 rounded-full text-xs font-bold">Popular</span>
            @endif
          </div>

          {{-- Konten --}}
          <div class="p-6 flex flex-col items-start gap-3">
            <h3 class="text-lg font-bold text-gray-800">{{ $product->name }}</h3>
            <div class="text-xl font-bold text-[#ffcfdf]">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <p class="text-gray-600 text-sm">{{ $product->description }}</p>

            {{-- Rating & Sold --}}
            <div class="flex items-center gap-1 text-sm text-gray-600">
              @php
                $rating = round($product->avg_rating ?? 0, 1);
                $sold = $product->total_sold ?? 0;
              @endphp
              <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 
                1 0 00.95.69h3.462c.969 0 1.371 1.24.588 
                1.81l-2.8 2.034a1 1 0 
                00-.364 1.118l1.07 3.292c.3.921-.755 
                1.688-1.54 1.118l-2.8-2.034a1 1 0 
                00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 
                1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 
                1 0 00.951-.69l1.07-3.292z" />
              </svg>
              <span class="font-semibold">{{ $rating }}</span>
              <span class="text-gray-500">• {{ $sold }} terjual</span>
            </div>

            {{-- Add to Cart / Out of Stock --}}
            @auth
              @if(auth()->user()->role->name === 'customer')
                @if($product->stock > 0)
                  <button
                    class="mt-3 w-full bg-[#ffcfdf] text-white font-bold px-6 py-2 rounded-full transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#e55a87] hover:shadow-[0_5px_15px_rgba(255,107,157,0.4)] add-to-cart-btn"
                    data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock }}"
                    data-image="{{ asset($product->image_url ?? 'images/default-product.jpg') }}">
                    Add to Cart
                  </button>
                @else
                  <p class="mt-3 text-red-500 font-semibold">Out of Stock</p>
                @endif
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
          // Tombol yang AKTIF (Dipilih):
          // Mengambil gaya dari tombol 'All Products' (background solid, text putih)
          btn.classList.add('bg-pink-300', 'text-white');
          btn.classList.remove('bg-white/20', 'border', 'border-white', 'text-slate-500', 'hover:bg-pink-200');

        } else {
          // Tombol yang TIDAK AKTIF (Lainnya):
          // Mengambil gaya dari tombol kategori lainnya (background transparan, border, text abu-abu)
          btn.classList.add('bg-white/20', 'border', 'border-white', 'text-slate-500', 'hover:bg-pink-200');
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