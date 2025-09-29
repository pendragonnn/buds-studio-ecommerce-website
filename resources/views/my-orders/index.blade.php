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
    </script>
</x-app-layout>
