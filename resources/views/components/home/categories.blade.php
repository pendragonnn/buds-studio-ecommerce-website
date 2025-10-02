{{-- Categories Section --}}
<section class="py-20 px-6 md:px-12 bg-white">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-14">
      Our Categories
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      @foreach($categories as $category)
        <div
          class="bg-white rounded-[15px] overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.1)] transition-transform duration-300 hover:-translate-y-2">
          
          {{-- Category image / gradient --}}
          <div class="h-52 md:h-60 lg:h-72 bg-cover bg-center"
               style="background-image: url('{{ asset($category->image_url ?? 'images/default-product.jpg') }}')">
          </div>

          {{-- Content --}}
          <div class="p-8 text-center flex flex-col items-center gap-5">
            <h3 class="text-2xl font-semibold text-gray-800">{{ $category->name }}</h3>
            <p class="text-gray-600">{{ $category->description }}</p>
            <a href="#products"
               class="inline-block bg-[#ffcfdf] text-white font-bold px-8 py-3 rounded-full transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 hover:bg-[#e55a87] hover:shadow-[0_5px_15px_rgba(255,107,157,0.4)]">
              View Collection
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
