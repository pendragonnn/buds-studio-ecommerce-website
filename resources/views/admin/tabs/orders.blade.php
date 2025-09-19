<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-lg font-semibold mb-6">Orders Management</h3>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Total Orders</p>
      <p class="text-2xl font-bold text-gray-800">15</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Pending Orders</p>
      <p class="text-2xl font-bold text-gray-800">5</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Completed Orders</p>
      <p class="text-2xl font-bold text-gray-800">17</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Total Revenue</p>
      <p class="text-2xl font-bold text-gray-800">Rp 2,125,000</p>
    </div>
  </div>

  {{-- Orders Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">Order ID</th>
          <th class="px-4 py-2 text-left">Name</th>
          <th class="px-4 py-2 text-left">Products</th>
          <th class="px-4 py-2 text-left">Total</th>
          <th class="px-4 py-2 text-left">Status</th>
          <th class="px-4 py-2 text-left">Date</th>
          <th class="px-4 py-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @for ($i = 1; $i <= 10; $i++)
          <tr>
            <td class="px-4 py-2">#BS{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</td>
            <td class="px-4 py-2">Sarah Johnson</td>
            <td class="px-4 py-2">Blush Bloom Nails</td>
            <td class="px-4 py-2">Rp 75.000</td>
            <td class="px-4 py-2">
              @if($i % 3 === 0)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm">Completed</span>
              @elseif($i % 3 === 1)
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm">Pending</span>
              @else
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm">Processing</span>
              @endif
            </td>
            <td class="px-4 py-2">2025-08-0{{ $i % 9 + 1 }}</td>
            <td class="px-4 py-2">
              <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">
                View
              </button>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>