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