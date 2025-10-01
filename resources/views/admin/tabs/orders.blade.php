<div class="bg-white shadow rounded-xl p-6"
  x-data="{ order: {}, openConfirm: false, openView: false, openCancel: false }">

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
            <td class="px-4 py-3 text-center">{{ $o->user->name }}</td>
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
            <td class="px-4 py-3 flex flex-wrap gap-2 justify-center">
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
      <p><strong>Customer:</strong> <span x-text="order.user.name"></span></p>
      <p><strong>Total:</strong> Rp <span x-text="order.total_amount"></span></p>
      <p><strong>Status:</strong> <span x-text="order.status"></span></p>

      <h3 class="mt-4 font-semibold">Items</h3>
      <ul class="list-disc pl-6">
        <template x-for="item in order.order_details" :key="item.id">
          <li>
            <span x-text="item.product.name"></span> - Qty: <span x-text="item.quantity"></span>
          </li>
        </template>
      </ul>

      <div class="mt-4 flex justify-end">
        <button @click="openView = false" class="px-4 py-2 bg-gray-300 rounded-lg">Close</button>
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


