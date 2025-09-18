<section id="products" class="px-4 py-8 md:py-8 md:px-12 bg-white">
  <div class="container mx-auto px-6 md:flex md:flex-col">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Products</h2>

    {{-- Product Filter Toggles --}}
    <div
      class="flex flex-row justify-center items-center gap-2 mb-10 bg-pink-700 p-2 rounded-3xl w-full md:w-fit md:self-center"
      id="filter-buttons">
      <button class="filter-btn py-3 px-6 rounded-2xl bg-pink-300 text-white font-semibold" data-category="all">
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
          <img src="{{ asset($product->image_url ?? 'images/default-product.jpg') }}" alt="{{ $product->name }}"
            class="w-full h-[500px] object-cover">

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