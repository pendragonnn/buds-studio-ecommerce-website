<section class="py-20 bg-gradient-to-br from-purple-900 via-purple-900 to-purple-500 relative overflow-hidden">
  <!-- Decorative Background Elements -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-20 left-10 w-40 h-40 bg-pink-500 rounded-full opacity-10 animate-pulse"></div>
    <div class="absolute bottom-32 right-20 w-28 h-28 bg-rose-400 rounded-full opacity-15 animate-bounce"></div>
    <div class="absolute top-1/2 right-10 w-20 h-20 bg-pink-600 rounded-full opacity-10"></div>
    <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-rose-500 rounded-full opacity-10"></div>
  </div>

  <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <h2
        class="text-3xl font-bold bg-gradient-to-r from-pink-300 via-rose-200 to-pink-400 bg-clip-text text-transparent mb-4">
        Our Customer Reviews
      </h2>
      <p class="text-md text-pink-100 max-w-2xl mx-auto leading-relaxed">
        See what our amazing customers say about their
        <span class="text-white font-semibold">beautiful experiences</span> with us ✨
      </p>

      <!-- Overall Rating Display -->
      <div class="flex items-center justify-center mt-8 space-x-3">
        <div class="flex space-x-1">
          @for ($i = 1; $i <= 5; $i++)
            <svg
              class="w-8 h-8 {{ $i <= round($averageRating) ? 'text-white drop-shadow-[0_0_6px_rgba(255,255,255,0.7)]' : 'text-white/30' }}"
              fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          @endfor
        </div>

        <span class="text-2xl font-bold text-white">
          {{ number_format($averageRating, 1) }}
        </span>

        <span class="text-pink-200">
          from {{ $totalReviews }} reviews
        </span>
      </div>
    </div>

    <!-- Reviews Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
      @foreach($testimonies as $testimony)
        <div class="group">
          <div
            class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-[0_0_20px_rgba(255,100,150,0.7)] transform hover:-translate-y-2 transition-all duration-300 h-full">

            <!-- Stars -->
            <div class="flex justify-center space-x-1 mb-6">
              @for ($i = 1; $i <= 5; $i++)
                <svg
                  class="w-5 h-5 {{ $i <= $testimony->rating ? 'text-white drop-shadow-[0_0_6px_rgba(255,255,255,0.7)]' : 'text-white/30' }}"
                  fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              @endfor
            </div>

            <!-- Review Text -->
            <p class="text-pink-50 text-center leading-relaxed mb-8 italic">
              "{{ $testimony->comment }}"
            </p>

            <!-- Customer Info -->
            <div class="text-center">
              <div
                class="w-16 h-16 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full mx-auto mb-3 flex items-center justify-center shadow-[0_0_12px_rgba(255,100,150,0.6)]">
                <span class="text-white font-bold text-lg">
                  {{ strtoupper(substr($testimony->orderDetail->order->user->name, 0, 1)) }}
                </span>
              </div>
              <h4 class="font-bold text-white text-lg">
                {{ $testimony->orderDetail->order->user->name }}
              </h4>
              <p class="text-pink-200 text-sm font-semibold">Verified Customer</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>