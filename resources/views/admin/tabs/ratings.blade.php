<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-lg font-semibold mb-6 text-left">Customer Ratings</h3>

  {{-- Summary Cards (Ratings) --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    {{-- Total Reviews --}}
    <div
      class="bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-pink-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Total Reviews</p>
      <p class="text-3xl font-bold text-gray-800">{{ $totalReviews }}</p>
    </div>

    {{-- Average Rating --}}
    <div
      class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-yellow-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.288 3.974a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.463a1 1 0 00-.364 1.118l1.288 3.974c.3.921-.755 1.688-1.54 1.118l-3.39-2.463a1 1 0 00-1.176 0l-3.39 2.463c-.784.57-1.838-.197-1.539-1.118l1.287-3.974a1 1 0 00-.364-1.118L2.043 9.4c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.288-3.974z" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Average Rating</p>
      <p class="text-3xl font-bold text-yellow-500">
        {{ number_format($averageRating, 1) }} ⭐
      </p>
    </div>

    {{-- 5-Star Reviews --}}
    <div
      class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-blue-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 17.75l-6.172 3.245 1.179-6.873-5-4.867 6.9-1L12 2l3.093 6.255 6.9 1-5 4.867 1.179 6.873z" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">5-Star Reviews</p>
      <p class="text-3xl font-bold text-gray-800">{{ $fiveStarReviews }}</p>
    </div>
  </div>

  {{-- Recent Reviews --}}
  <h4 class="text-md font-semibold mb-4 text-left">Recent Reviews</h4>
  <div class="space-y-4">
    @foreach ($reviews->take(5) as $review)
      <div class="flex items-start justify-between bg-gray-50 p-4 rounded-lg">
        <div>
          {{-- user name --}}
          <p class="font-semibold text-gray-800">
            {{ $review->orderDetail->order->user->name ?? 'Unknown User' }}
          </p>

          {{-- product name --}}
          <p class="text-sm text-pink-600">
            {{ $review->orderDetail->product->name ?? 'Unknown Product' }}
          </p>

          {{-- comment --}}
          <p class="text-gray-600 text-sm mt-1">{{ $review->comment }}</p>
        </div>

        {{-- stars --}}
        <div class="flex text-yellow-400">
          @for ($star = 1; $star <= 5; $star++)
            <svg xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 {{ $star <= $review->rating ? 'fill-current' : 'stroke-current text-gray-300' }}"
              viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 
                           00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 
                           2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 
                           1.688-1.54 1.118l-3.371-2.449a1 1 0 
                           00-1.175 0l-3.371 2.449c-.784.57-1.838-.197-1.539-1.118l1.287-3.955a1 
                           1 0 00-.364-1.118L2.075 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 
                           1 0 00.95-.69l1.286-3.955z" />
            </svg>
          @endfor
        </div>
      </div>
    @endforeach
  </div>
</div>