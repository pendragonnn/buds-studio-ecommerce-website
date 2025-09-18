{{-- resources/views/components/checkout-modal.blade.php --}}
<div x-data x-show="$store.checkout.open" x-transition.opacity
  class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
    {{-- Close Button --}}
    <button @click="$store.checkout.open = false; $store.checkout.step = 1; const form = document.getElementById('checkout-form');
        if (form) form.reset();"
      class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      ✕
    </button>

    {{-- STEP 1: Address --}}
    <div x-show="$store.checkout.step === 1" x-transition>
      <h2 class="text-xl font-bold text-center mb-4">Enter Your Delivery Address</h2>
      <form id="checkout-form" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" placeholder="Nama" x-model="$store.checkout.data.name"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">
          <input type="text" placeholder="Nomor Telepon" x-model="$store.checkout.data.phone"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">
        </div>
        <input type="text" placeholder="Alamat Lengkap" x-model="$store.checkout.data.address"
          class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">

        {{-- Dropdown wilayah (sementara static dulu) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <select x-model="$store.checkout.data.province" class="w-full border rounded-lg px-4 py-2">
            <option>Provinsi</option>
          </select>
          <select x-model="$store.checkout.data.city" class="w-full border rounded-lg px-4 py-2">
            <option>Kota</option>
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <select x-model="$store.checkout.data.district" class="w-full border rounded-lg px-4 py-2">
            <option>Kecamatan</option>
          </select>
          <select x-model="$store.checkout.data.subdistrict" class="w-full border rounded-lg px-4 py-2">
            <option>Kelurahan</option>
          </select>
        </div>

        <input type="text" placeholder="Kode Pos" x-model="$store.checkout.data.postal_code"
          class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">

        <div class="flex justify-end">
          <button type="button" @click="$store.checkout.step = 2"
            class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
            Next
          </button>
        </div>
      </form>
    </div>

    {{-- STEP 2: Review Order & Payment --}}
    <div x-show="$store.checkout.step === 2" x-transition>
      <h2 class="text-xl font-bold text-center mb-2">Complete Your Order</h2>
      <p class="text-center text-gray-500 mb-4">Choose your payment method</p>

      {{-- Alamat --}}
      <div class="border rounded-lg p-4 mb-4">
        <p class="font-semibold" x-text="$store.checkout.data.name"></p>
        <p x-text="$store.checkout.data.phone"></p>
        <p x-text="$store.checkout.data.address"></p>
        <p>
          <span x-text="$store.checkout.data.city"></span>,
          <span x-text="$store.checkout.data.province"></span>,
          <span x-text="$store.checkout.data.postal_code"></span>
        </p>
      </div>

      {{-- Cart Items --}}
      <div class="border rounded-lg p-4 mb-4 max-h-48 overflow-y-auto">
        <template x-for="item in JSON.parse(localStorage.getItem('cart') || '[]')" :key="item.id">
          <div class="flex justify-between border-b py-2">
            <span x-text="item.name"></span>
            <span x-text="'Rp ' + (item.price * item.quantity).toLocaleString()"></span>
          </div>
        </template>
        <div class="flex justify-between font-bold pt-2">
          <span>Total:</span>
          <span id="checkout-total"></span>
        </div>
      </div>

      {{-- Payment Methods --}}
      <h3 class="text-lg font-semibold mb-2 text-center">Payment Methods</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <button type="button" @click="$store.checkout.paymentMethod = 'bank'"
          :class="{'border-pink-500 bg-pink-100': $store.checkout.paymentMethod === 'bank'}"
          class="border rounded-lg p-4 text-center hover:bg-gray-100">
          <p class="font-bold">Bank Transfer</p>
          <p class="text-sm text-gray-500">BCA, Mandiri, BNI</p>
        </button>

        <button type="button" @click="$store.checkout.paymentMethod = 'ewallet'"
          :class="{'border-pink-500 bg-pink-100': $store.checkout.paymentMethod === 'ewallet'}"
          class="border rounded-lg p-4 text-center hover:bg-gray-100">
          <p class="font-bold">E-Wallet</p>
          <p class="text-sm text-gray-500">GoPay, OVO, DANA</p>
        </button>

        <button type="button" @click="$store.checkout.paymentMethod = 'cod'"
          :class="{'border-pink-500 bg-pink-100': $store.checkout.paymentMethod === 'cod'}"
          class="border rounded-lg p-4 text-center hover:bg-gray-100">
          <p class="font-bold">Cash on Delivery</p>
          <p class="text-sm text-gray-500">Pay when received</p>
        </button>
      </div>

      {{-- Confirm Button --}}
      <div class="flex justify-end mt-6">
        <button type="button" @click="$store.checkout.step = 3;localStorage.removeItem('buds_cart');
        document.getElementById('cart-items').innerHTML = '';
        document.getElementById('cart-total').innerText = 'Rp 0';
        document.getElementById('cart-count').innerText = '0';
        document.getElementById('cart-count-mobile').innerText = '0';
        "
          class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
          Confirm Order
        </button>
      </div>
    </div>

    {{-- STEP 3: Payment Confirmation --}}
    <div x-show="$store.checkout.step === 3" x-transition>
      <h2 class="text-xl font-bold text-center mb-2">Complete Your Order</h2>
      <p class="text-center text-gray-500 mb-4">Choose your payment method</p>

      {{-- Alamat --}}
      <div class="border rounded-lg p-4 mb-4">
        <p class="font-semibold" x-text="$store.checkout.data.name"></p>
        <p x-text="$store.checkout.data.phone"></p>
        <p x-text="$store.checkout.data.address"></p>
        <p>
          <span x-text="$store.checkout.data.city"></span>,
          <span x-text="$store.checkout.data.province"></span>,
          <span x-text="$store.checkout.data.postal_code"></span>
        </p>
      </div>

      {{-- Order Summary --}}
      <div class="border rounded-lg p-4 mb-4">
        <template x-for="item in JSON.parse(localStorage.getItem('cart') || '[]')" :key="item.id">
          <div class="flex justify-between border-b py-2">
            <span x-text="item.name"></span>
            <span x-text="'Rp ' + (item.price * item.quantity).toLocaleString()"></span>
          </div>
        </template>
        <div class="flex justify-between font-bold pt-2">
          <span>Total</span>
          <span id="checkout-total-final"></span>
        </div>
      </div>

      {{-- Payment Method --}}
      <div class="text-center mb-6">
        <h3 class="text-lg font-semibold mb-2">Payment Method</h3>
        <p class="px-4 py-2 bg-gray-100 rounded-lg inline-block font-bold text-pink-600"
          x-text="$store.checkout.paymentMethodLabel"></p>
      </div>

      {{-- Chat Us --}}
      <div class="text-center">
        <p class="text-gray-600 mb-2">Chat us to send your proof of payment</p>
        <a href="https://wa.me/6281234567890" target="_blank"
          class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
          Chat Us
        </a>
      </div>
    </div>

  </div>
</div>