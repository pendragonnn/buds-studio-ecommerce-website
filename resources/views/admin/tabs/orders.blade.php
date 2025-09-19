<div class="bg-white shadow rounded-xl p-6" 
     x-data="{ openView: false, order: {} }">
  <h3 class="text-lg font-semibold mb-6">Orders Management</h3>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Total Orders</p>
      <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Pending Orders</p>
      <p class="text-2xl font-bold text-gray-800">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Completed Orders</p>
      <p class="text-2xl font-bold text-gray-800">{{ $completedOrders }}</p>
    </div>
    <div class="bg-gray-100 p-4 rounded-lg text-center">
      <p class="text-gray-600 font-medium">Total Revenue</p>
      <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
  </div>

  {{-- Orders Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-center">Order ID</th>
          <th class="px-4 py-2 text-center">Customer</th>
          <th class="px-4 py-2 text-center">Total</th>
          <th class="px-4 py-2 text-center">Status</th>
          <th class="px-4 py-2 text-center">Date</th>
          <th class="px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach ($orders as $o)
          <tr>
            <td class="px-4 py-2 text-center">{{ $o->id }}</td>
            <td class="px-4 py-2 text-center">{{ $o->user->name }}</td>
            <td class="px-4 py-2 text-center">Rp {{ number_format($o->total_amount, 0, ',', '.') }}</td>
            <td class="px-4 py-2 text-center">
              <span class="px-3 py-1 rounded-lg text-sm
                @if($o->status == 'completed') bg-green-100 text-green-700
                @elseif($o->status == 'pending') bg-yellow-100 text-yellow-700
                @else bg-blue-100 text-blue-700 @endif">
                {{ ucfirst($o->status) }}
              </span>
            </td>
            <td class="px-4 py-2 text-center">{{ $o->created_at->format('Y-m-d') }}</td>
            <td class="px-4 py-2 flex gap-2 justify-center">
              {{-- View --}}
              <button @click="openView = true; order = {{ $o->toJson() }}"
                      class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">
                View
              </button>
              {{-- Confirm Payment --}}
              @if($o->status == 'pending')
                <form action="{{ route('admin.orders.confirmPayment', $o->id) }}" method="POST">
                  @csrf @method('PUT')
                  <button type="submit"
                          class="bg-pink-500 text-white px-3 py-1 rounded-lg hover:bg-pink-600">
                    Confirm Payment
                  </button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- View Modal --}}
  <div x-show="openView" x-cloak 
       class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
      <h2 class="text-lg font-bold mb-4">Order Detail</h2>
      <p><strong>Order ID:</strong> <span x-text="order.id"></span></p>
      <p><strong>Customer:</strong> <span x-text="order.user?.name"></span></p>
      <p><strong>Status:</strong> <span x-text="order.status"></span></p>
      <p><strong>Total:</strong> Rp <span x-text="order.total_amount"></span></p>

      {{-- Close --}}
      <div class="flex justify-end mt-4">
        <button @click="openView = false"
                class="px-4 py-2 bg-gray-300 rounded-lg">Close</button>
      </div>
    </div>
  </div>
</div>
