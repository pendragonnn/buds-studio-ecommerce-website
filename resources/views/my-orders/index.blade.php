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
                                <div class="flex justify-between py-2">
                                    <span>{{ $detail->product->name }} x {{ $detail->quantity }}</span>
                                    <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <p class="font-semibold">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

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
</x-app-layout>