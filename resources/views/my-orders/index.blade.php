@php
    $currentStatus = request('status', 'all');

    function getStatusClasses($status)
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'admin_validation' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-700',
        };
    }
@endphp

<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">My Purchases</h1>

        <!-- Tabs for order statuses -->
        <div class="flex space-x-4 border-b mb-6">
            <a href="{{ route('my-orders.index', ['status' => 'all']) }}"
                class="px-4 py-2 text-sm font-semibold border-b-2 {{ $currentStatus === 'all' ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500' }}">
                All
            </a>
            <a href="{{ route('my-orders.index', ['status' => 'admin_validation']) }}"
                class="px-4 py-2 text-sm font-semibold border-b-2 {{ $currentStatus === 'admin_validation' ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500' }}">
                Admin Validation
            </a>
            <a href="{{ route('my-orders.index', ['status' => 'shipping']) }}"
                class="px-4 py-2 text-sm font-semibold border-b-2 {{ $currentStatus === 'shipping' ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500' }}">
                Shipping
            </a>
            <a href="{{ route('my-orders.index', ['status' => 'completed']) }}"
                class="px-4 py-2 text-sm font-semibold border-b-2 {{ $currentStatus === 'completed' ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500' }}">
                Completed
            </a>
            <a href="{{ route('my-orders.index', ['status' => 'cancelled']) }}"
                class="px-4 py-2 text-sm font-semibold border-b-2 {{ $currentStatus === 'cancelled' ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500' }}">
                Cancelled
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="text-center text-gray-500 py-12">
                <p>No orders yet</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="border rounded-lg p-4 shadow-sm bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ getStatusClasses($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="divide-y">
                            @foreach($order->orderDetails as $detail)
                                <div class="py-2">
                                    <div class="flex justify-between">
                                        <span>{{ $detail->product->name }} x {{ $detail->quantity }}</span>
                                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </div>

                                    {{-- Testimony section (only for completed orders) --}}
                                    @if($order->status === 'completed')
                                        <div class="mt-3">
                                            @if($detail->testimony)
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <div class="flex items-center mb-2">
                                                        @for($i=1; $i<=5; $i++)
                                                            <svg class="w-5 h-5 {{ $i <= $detail->testimony->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.17 3.6a1 1 0 00.95.69h3.8c.969 0 1.371 1.24.588 1.81l-3.076 2.236a1 1 0 00-.364 1.118l1.17 3.6c.3.921-.755 1.688-1.54 1.118l-3.076-2.236a1 1 0 00-1.176 0l-3.076 2.236c-.784.57-1.838-.197-1.539-1.118l1.17-3.6a1 1 0 00-.364-1.118L2.54 9.027c-.783-.57-.38-1.81.588-1.81h3.8a1 1 0 00.95-.69l1.17-3.6z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="text-gray-600 text-sm">{{ $detail->testimony->comment }}</p>
                                                    <form method="POST" action="{{ route('my-orders.testimony.update', $detail->id) }}" class="mt-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" onclick="document.getElementById('form-{{ $detail->id }}').classList.toggle('hidden')"
                                                            class="text-pink-500 text-sm">Update Testimony</button>
                                                    </form>
                                                </div>
                                            @else
                                                <button type="button" onclick="document.getElementById('form-{{ $detail->id }}').classList.toggle('hidden')"
                                                    class="mt-2 bg-pink-500 text-white px-3 py-1 rounded text-sm">
                                                    Add Testimony
                                                </button>
                                            @endif

                                            {{-- Hidden form --}}
                                            <form id="form-{{ $detail->id }}" method="POST"
                                                action="{{ $detail->testimony ? route('my-orders.testimony.update', $detail->id) : route('my-orders.testimony.store', $detail->id) }}"
                                                class="hidden mt-3 border p-3 rounded bg-gray-50">
                                                @csrf
                                                @if($detail->testimony)
                                                    @method('PUT')
                                                @endif

                                                {{-- Star rating --}}
                                                <div class="flex items-center space-x-1 mb-2">
                                                    @for($i=1; $i<=5; $i++)
                                                        <label>
                                                            <input required type="radio" name="rating" value="{{ $i }}" class="hidden"
                                                                {{ $detail->testimony && $detail->testimony->rating == $i ? 'checked' : '' }}
                                                                onchange="updateStars({{ $detail->id }}, {{ $i }})">
                                                            <svg id="star-{{ $detail->id }}-{{ $i }}" class="w-6 h-6 cursor-pointer {{ $detail->testimony && $i <= $detail->testimony->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.17 3.6a1 1 0 00.95.69h3.8c.969 0 1.371 1.24.588 1.81l-3.076 2.236a1 1 0 00-.364 1.118l1.17 3.6c.3.921-.755 1.688-1.54 1.118l-3.076-2.236a1 1 0 00-1.176 0l-3.076 2.236c-.784.57-1.838-.197-1.539-1.118l1.17-3.6a1 1 0 00-.364-1.118L2.54 9.027c-.783-.57-.38-1.81.588-1.81h3.8a1 1 0 00.95-.69l1.17-3.6z"/>
                                                            </svg>
                                                        </label>
                                                    @endfor
                                                </div>

                                                <textarea required name="comment" rows="3" class="w-full border rounded p-2 text-sm" placeholder="Write your testimony...">{{ $detail->testimony->comment ?? '' }}</textarea>

                                                <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-1 rounded text-sm">
                                                    {{ $detail->testimony ? 'Update Testimony' : 'Add Testimony' }}
                                                </button>
                                                <button type="button" onclick="document.getElementById('form-{{ $detail->id }}').classList.toggle('hidden')"
                                                    class="mt-2 bg-pink-500 text-white px-3 py-1 rounded text-sm">
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <p class="font-semibold">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                            @if($order->status === 'pending' && $order->payment->status === 'admin_validation')
                                <button 
                                    onclick="sendOrderToWhatsApp({{ $order->id }})" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                    </svg>
                                    Chat Admin
                                </button>
                            @endif

                            @if($order->status === 'pending' && $order->payment->status === 'admin_validation')
                                <form method="POST" action="{{ route('my-orders.cancel', $order->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Cancel Order
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'shipped')
                                <div class="flex flex-col items-end">
                                    <p class="text-sm text-gray-500 mb-2">
                                        Your order is being shipped and is estimated to arrive in 3–7 days (depending on location).
                                    </p>
                                    <form method="POST" action="{{ route('my-orders.complete', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Mark as Completed
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function updateStars(detailId, rating) {
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById(`star-${detailId}-${i}`);
                if (i <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            }
        }

        async function sendOrderToWhatsApp(orderId) {
  try {
    const res = await fetch(`/my-orders/${orderId}/whatsapp-data`);
    if (!res.ok) throw new Error('Failed to fetch order data');
    const order = await res.json();
    console.log('Order fetched:', order);

    const nf = new Intl.NumberFormat('id-ID');

    const parseNum = (v) => {
      if (v === null || v === undefined || v === '') return NaN;
      if (typeof v === 'number') return v;
      // remove thousands separators if any, then parse
      const cleaned = String(v).replace(/[,\s]/g, '');
      const n = Number(cleaned);
      return isNaN(n) ? NaN : n;
    };

    // Determine total (fallback compute from items if total missing)
    let totalNum = parseNum(order.total);
    const items = order.items || [];

    // Build items list and compute fallback totals if necessary
    let itemsList = '';
    let computedTotal = 0;

    items.forEach((item, i) => {
      const qty = Number(item.quantity) || 1;
      let priceNum = parseNum(item.price);
      const subtotalNum = parseNum(item.subtotal);

      // If price is missing but subtotal present, try to infer price
      if (isNaN(priceNum) && !isNaN(subtotalNum) && qty > 0) {
        priceNum = subtotalNum / qty;
      }

      // If subtotal missing but price available, compute subtotal
      const finalSubtotalNum = !isNaN(subtotalNum) ? subtotalNum : (!isNaN(priceNum) ? priceNum * qty : 0);

      computedTotal += finalSubtotalNum;

      const priceStr = !isNaN(priceNum) ? `Rp ${nf.format(priceNum)}` : 'Rp -';
      const subtotalStr = `Rp ${nf.format(finalSubtotalNum)}`;

      itemsList += `${i + 1}. ${item.name}\n`;
      itemsList += `   Qty: ${qty} x ${priceStr}\n`;
      itemsList += `   Subtotal: ${subtotalStr}\n`;
    });

    if (isNaN(totalNum)) {
      totalNum = computedTotal;
    }

    const totalStr = `Rp ${nf.format(totalNum)}`;

    const address = order.address || 'Not provided';

    // Build message
    let message = '*BUDS STUDIO - ORDER VALIDATION*\n\n';
    message += `Order ID: ${order.id}\n`;
    message += `Status: ${order.status}\n\n`;
    message += `===== ORDER DETAILS =====\n`;
    message += itemsList + '\n';
    message += `TOTAL: *${totalStr}*\n\n`;
    message += `===== CUSTOMER INFO =====\n`;
    message += `Name: ${order.user?.name || '-'}\n`;
    message += `Phone: ${order.user?.phone || '-'}\n`;
    message += `Address: ${order.user.address}\n\n`;
    message += `I would like to confirm my payment, thank you!`;
    console.log(order.user);

    const waNumber = "6281809740724";
    const url = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;

    window.open(url, "_blank");
  } catch (err) {
    console.error(err);
    alert("Failed to send order to WhatsApp. Please try again.");
  }
}
    </script>
</x-app-layout>
