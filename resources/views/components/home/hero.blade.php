{{-- Hero Section --}}
<section id="hero" class="bg-[linear-gradient(135deg,#ffddec,#daddff)] pt-20 pb-20 text-center text-gray-800">
  <div class="container mx-auto px-6 fade-in-up">
    <h1 class="text-4xl md:text-5xl lg:text-6xl italic font-bold mb-6 drop-shadow-sm">
      Buds Studio
    </h1>
    <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto mb-8 leading-relaxed">
      Discover our collection of premium press-on nails and phone straps. <br class="hidden md:block" />
      Express your style with our unique designs!
    </p>
    <a href="#products"
      class="inline-block bg-[#ffcfdf] text-white font-bold px-8 py-3 rounded-full transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 hover:bg-[#e55a87] hover:shadow-[0_5px_15px_rgba(255,107,157,0.4)]">
      Shop Now
    </a>
  </div>
</section>

<style>
  /* Animasi fade-in-up sederhana */
  .fade-in-up {
    animation: fadeInUp 1s ease-out;
  }

  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(20px);
    }

    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>