<div class="bg-white shadow rounded-xl p-6"
  x-data="{ order: {}, openConfirm: false, openView: false, openCancel: false }">

  <h3 class="text-lg font-semibold mb-6">Orders Management</h3>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    {{-- Total Orders --}}
    <div
      class="bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-pink-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Total Orders</p>
      <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
    </div>

    {{-- Pending Orders --}}
    <div
      class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-yellow-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Pending Orders</p>
      <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
    </div>

    {{-- Completed Orders --}}
    <div
      class="bg-gradient-to-br from-green-100 to-green-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-green-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Completed Orders</p>
      <p class="text-3xl font-bold text-gray-800">{{ $completedOrders }}</p>
    </div>

    {{-- Total Revenue --}}
    <div
      class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition text-center">
      <div class="flex justify-center mb-3">
        <div class="bg-purple-500 text-white p-3 rounded-full shadow-lg">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-1.657 0-3 .843-3 1.875v6.25C9 17.157 10.343 18 12 18s3-.843 3-1.875v-6.25C15 8.843 13.657 8 12 8z" />
          </svg>
        </div>
      </div>
      <p class="text-gray-600 font-medium">Total Revenue</p>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
  </div>

  {{-- Orders Table --}}
  <div class="overflow-x-auto rounded-lg border border-gray-200 p-4">
    <table id="ordersTable" class="min-w-full text-sm text-gray-700 mb-4">
      <thead>
        <tr class="bg-gradient-to-r from-pink-50 to-rose-50 text-gray-600 uppercase text-xs tracking-wider">
          <th class="px-4 py-3 text-center font-semibold">Order ID</th>
          <th class="px-4 py-3 text-center font-semibold">Customer</th>
          <th class="px-4 py-3 text-center font-semibold">Total</th>
          <th class="px-4 py-3 text-center font-semibold">Status</th>
          <th class="px-4 py-3 text-center font-semibold">Date</th>
          <th class="px-4 py-3 text-center font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach ($orders as $o)
          <tr class="hover:bg-pink-50 transition">
            <td class="px-4 py-3 text-center font-medium text-gray-800">#{{ $o->id }}</td>
            <td class="px-4 py-3 text-center">
              <span class="{{ $o->user ? '' : 'italic text-gray-500' }}">
                {{ $o->user ? $o->user->name : 'Deleted User' }}
              </span>
            </td>
            <td class="px-4 py-3 text-center font-semibold text-pink-600">
              Rp {{ number_format($o->total_amount, 0, ',', '.') }}
            </td>
            <td class="px-4 py-3 text-center">
              <span class="px-3 py-1 rounded-full text-xs font-semibold
                              @if($o->status == 'completed') bg-green-100 text-green-700
                              @elseif($o->status == 'pending') bg-yellow-100 text-yellow-700
                              @elseif($o->status == 'cancelled') bg-red-100 text-red-700
                              @else bg-blue-100 text-blue-700 @endif">
                {{ ucfirst($o->status) }}
              </span>
            </td>
            <td class="px-4 py-3 text-center">{{ $o->created_at->format('Y-m-d') }}</td>
            <td class="px-4 py-3 flex gap-2 justify-center">
              {{-- View --}}
              <button @click="openView = true; order = {{ $o->load('orderDetails.product')->toJson() }}"
                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                View
              </button>

              {{-- Cancel --}}
              @if($o->status == 'pending')
                <button @click="openCancel = true; order = {{ $o->toJson() }}"
                  class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                  Cancel
                </button>
                <button @click="openConfirm = true; order = {{ $o->toJson() }}"
                  class="px-3 py-1 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                  Confirm
                </button>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Confirm Payment Modal --}}
  <div x-show="openConfirm" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm text-center">
      <h2 class="text-lg font-bold mb-4">Confirm Payment</h2>
      <p class="mb-6">Confirm payment for
        <span class="font-semibold text-pink-600">Order #<span x-text="order.id"></span></span>?
      </p>
      <form :action="'/admin/orders/' + order.id + '/confirm-payment'" method="POST" class="flex justify-center gap-2">
        @csrf
        @method('PUT')
        <button type="button" @click="openConfirm = false" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
          Confirm
        </button>
      </form>
    </div>
  </div>

  {{-- Cancel Order Modal --}}
  <div x-show="openCancel" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm text-center">
      <h2 class="text-lg font-bold mb-4">Cancel Order</h2>
      <p class="mb-6">Cancel order for
        <span class="font-semibold text-pink-600">Order #<span x-text="order.id"></span></span>?
      </p>
      <form :action="'/admin/orders/' + order.id + '/cancel'" method="POST" class="flex justify-center gap-2">
        @csrf
        @method('PUT')
        <button type="button" @click="openCancel = false" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
          Confirm
        </button>
      </form>
    </div>
  </div>

  {{-- View Order Modal --}}
  <div x-show="openView" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
      <h2 class="text-lg font-bold mb-4">Order Detail</h2>

      <p><strong>Order ID:</strong> <span x-text="order.id"></span></p>
      <p>
        <strong>Customer:</strong>
        <span :class="!order.user?.name ? 'italic text-gray-500' : ''" x-text="order.user?.name ?? 'Deleted User'">
        </span>
      </p>

      <p><strong>Total:</strong> Rp <span x-text="Number(order.total_amount).toLocaleString()"></span></p>
      <p><strong>Status:</strong> <span x-text="order.status"></span></p>

      <h3 class="mt-4 font-semibold">Items</h3>
      <ul class="list-disc pl-6 space-y-1">
        <template x-if="order.order_details && order.order_details.length">
          <template x-for="item in order.order_details" :key="item.id">
            <li>
              <span :class="item.product ? '' : 'italic text-gray-500'"
                x-text="item.product && item.product.name ? item.product.name : '🗑️ Product data deleted'">
              </span>
              | Qty:
              <span :class="!item.product ? 'italic text-gray-500' : ''" x-text="item.product ? item.quantity : '-'">
              </span>
            </li>
          </template>
        </template>

        <template x-if="!order.order_details || order.order_details.length === 0">
          <li class="text-gray-500 italic">🗑️ Product data deleted</li>
        </template>
      </ul>

      <div class="mt-4 flex justify-end">
        <button @click="openView = false" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition-colors">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

{{-- DataTables init --}}
<script>
  $(document).ready(function () {
    let table = $('#ordersTable').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"flex flex-col md:flex-row items-center justify-between gap-4 mb-4"f>t<"flex flex-col md:flex-row items-center justify-between gap-4 mt-4"lip>',
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search orders...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ orders",
        paginate: {
          previous: "← Prev",
          next: "Next →"
        }
      },
      columnDefs: [
        { orderable: false, targets: -1 },
      ],
      order: [[4, "desc"]]
    });
  });
</script>