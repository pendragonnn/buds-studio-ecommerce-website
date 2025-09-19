<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-lg font-semibold mb-6 text-left">Customer Ratings</h3>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Total Reviews</p>
      <p class="text-2xl font-bold text-gray-800">15</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Average Rating</p>
      <p class="text-2xl font-bold text-yellow-500">4.5 ⭐</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">5-Star Reviews</p>
      <p class="text-2xl font-bold text-gray-800">10</p>
    </div>
  </div>

  {{-- Recent Reviews --}}
  <h4 class="text-md font-semibold mb-4 text-left">Recent Reviews</h4>
  <div class="space-y-4">
    @for ($i = 1; $i <= 5; $i++)
      <div class="flex items-start justify-between bg-gray-50 p-4 rounded-lg">
        <div>
          <p class="font-semibold text-gray-800">Sarah Johnson</p>
          <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing
            elit.</p>
        </div>
        <div class="flex text-yellow-400">
          @for ($star = 1; $star <= 5; $star++)
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20">
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
    @endfor
  </div>
</div>