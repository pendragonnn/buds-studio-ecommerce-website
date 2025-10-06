{{-- resources/views/components/checkout-modal.blade.php --}}
<div x-data x-show="$store.checkout.open" x-transition.opacity x-init="$store.checkout.init()"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
    {{-- Close Button --}}
    <button @click="$store.checkout.open = false; $store.checkout.step = 1; const form = document.getElementById('checkout-form');
        if (form) 
        $store.checkout.data.address = '';
        $store.checkout.data.province = '';
        $store.checkout.data.city = '';
        $store.checkout.data.district = '';
        $store.checkout.data.subdistrict = '';
        $store.checkout.data.postal_code = '';" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      ✕
    </button>

    {{-- STEP 1: Address --}}
    <div x-show="$store.checkout.step === 1" x-transition>
      <h2 class="text-xl font-bold text-center mb-4">Enter Your Delivery Address</h2>
      <form id="checkout-form" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" placeholder="Name" x-model="$store.checkout.data.name" readonly
            class="w-full border rounded-lg px-4 py-2 bg-gray-100 text-gray-600 cursor-not-allowed">

          <input type="text" placeholder="Phone" x-model="$store.checkout.data.phone" readonly
            class="w-full border rounded-lg px-4 py-2 bg-gray-100 text-gray-600 cursor-not-allowed">
        </div>
        <input required type="text" placeholder="Address" x-model="$store.checkout.data.address"
          class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">

        <select required x-model="$store.checkout.data.province" @change="
          const prov = $store.checkout.provinces.find(p => p.id == $event.target.value);
          $store.checkout.data.province_name = prov ? prov.name : '';
          $store.checkout.fetchCities($event.target.value)
        " class="w-full border rounded-lg px-4 py-2">
          <option value="">Province</option>
          <template x-for="prov in $store.checkout.provinces" :key="prov.id">
            <option :value="prov.id" x-text="prov.name"></option>
          </template>
        </select>

        <select required x-model="$store.checkout.data.city" @change="
          const city = $store.checkout.cities.find(c => c.id == $event.target.value);
          $store.checkout.data.city_name = city ? city.name : '';
          $store.checkout.fetchDistricts($event.target.value)
        " class="w-full border rounded-lg px-4 py-2">
          <option value="">City</option>
          <template x-for="city in $store.checkout.cities" :key="city.id">
            <option :value="city.id" x-text="city.name"></option>
          </template>
        </select>

        <select required x-model="$store.checkout.data.district" @change="
          const dist = $store.checkout.districts.find(d => d.id == $event.target.value);
          $store.checkout.data.district_name = dist ? dist.name : '';
          $store.checkout.fetchSubdistricts($event.target.value)
        " class="w-full border rounded-lg px-4 py-2">
          <option value="">District</option>
          <template x-for="district in $store.checkout.districts" :key="district.id">
            <option :value="district.id" x-text="district.name"></option>
          </template>
        </select>

        <select required x-model="$store.checkout.data.subdistrict" @change="
          const sub = $store.checkout.subdistricts.find(s => s.id == $event.target.value);
          $store.checkout.data.subdistrict_name = sub ? sub.name : '';
        " class="w-full border rounded-lg px-4 py-2">
          <option value="">Subdistrict</option>
          <template x-for="sub in $store.checkout.subdistricts" :key="sub.id">
            <option :value="sub.id" x-text="sub.name"></option>
          </template>
        </select>

        <input type="text" placeholder="Post Code" x-model="$store.checkout.data.postal_code"
          class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-pink-200">

        <div class="flex justify-end">
          <button type="button" @click="
    if ($store.checkout.validateAddress()) {
      $store.checkout.step = 2;
    } else {
      showCheckoutToast('Please complete your delivery address', 'error');
    }
  " class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
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
          <span x-text="$store.checkout.data.subdistrict_name"></span>,
          <span x-text="$store.checkout.data.district_name"></span>,
          <span x-text="$store.checkout.data.city_name"></span>,
          <span x-text="$store.checkout.data.province_name"></span>,
          <span x-text="$store.checkout.data.postal_code"></span>
        </p>
      </div>

      <div x-data="{
    userId: {{ auth()->id() }},
    get cart() {
      return JSON.parse(localStorage.getItem(`buds_cart_${this.userId}`) || '[]');
    },
    get total() {
      return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
  }">
        {{-- Cart Items --}}
        <div class="border rounded-lg p-4 mb-4 max-h-48 overflow-y-auto">
          <template x-for="item in cart" :key="item.id">
            <div class="flex justify-between border-b py-2">
              <span x-text="item.name"></span>
              <span x-text="'Rp ' + (item.price * item.quantity)"></span>
            </div>
          </template>
          <div class="flex justify-between font-bold pt-2">
            <span>Total:</span>
            <span x-text="'Rp ' + total"></span>
          </div>
        </div>
      </div>

      {{-- Payment Methods --}}
      <h3 class="text-lg font-semibold mb-2 text-center">Payment Methods</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <button type="button" @click="$store.checkout.paymentMethod = 'bank_transfer'"
          :class="{'border-pink-500 bg-pink-100': $store.checkout.paymentMethod === 'bank_transfer'}"
          class="border rounded-lg p-4 text-center hover:bg-gray-100">
          <p class="font-bold">Bank Transfer</p>
          <p class="text-sm text-gray-500">BCA, Mandiri, BNI</p>
        </button>

        <button type="button" @click="$store.checkout.paymentMethod = 'e_wallet'"
          :class="{'border-pink-500 bg-pink-100': $store.checkout.paymentMethod === 'e_wallet'}"
          class="border rounded-lg p-4 text-center hover:bg-gray-100">
          <p class="font-bold">E-Wallet</p>
          <p class="text-sm text-gray-500">GoPay, OVO, DANA</p>
        </button>
      </div>

      {{-- Confirm Button --}}
      <div class="flex justify-end mt-6">
        <button type="button" @click="
            if ($store.checkout.paymentMethod) {
              $store.checkout.step = 3;
              $dispatch('place-order');
            } else {
              showCheckoutToast('Please choose a payment method', 'error');
            }
            " class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
          Confirm Order
        </button>
      </div>
    </div>

    {{-- STEP 3: Payment Confirmation --}}
    <div x-show="$store.checkout.step === 3" x-transition>
      <h2 class="text-xl font-bold text-center mb-2">Order Confirmed!</h2>
      <p class="text-center text-gray-500 mb-4">Thank you for your order</p>

      {{-- Alamat --}}
      <div class="border rounded-lg p-4 mb-4">
        <p class="font-semibold" x-text="$store.checkout.data.name"></p>
        <p x-text="$store.checkout.data.phone"></p>
        <p x-text="$store.checkout.data.address"></p>
        <p>
          <span x-text="$store.checkout.data.subdistrict_name"></span>,
          <span x-text="$store.checkout.data.district_name"></span>,
          <span x-text="$store.checkout.data.city_name"></span>,
          <span x-text="$store.checkout.data.province_name"></span>,
          <span x-text="$store.checkout.data.postal_code"></span>
        </p>
      </div>

      <div x-data="{
    userId: {{ auth()->id() }},
    get cart() {
      return JSON.parse(localStorage.getItem(`buds_cart_${this.userId}`) || '[]');
    },
    get total() {
      return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
  }">
        {{-- Cart Items --}}
        <div class="border rounded-lg p-4 mb-4 max-h-48 overflow-y-auto">
          <template x-for="item in cart" :key="item.id">
            <div class="flex justify-between border-b py-2">
              <span x-text="item.name"></span>
              <span x-text="'Rp ' + (item.price * item.quantity)"></span>
            </div>
          </template>
          <div class="flex justify-between font-bold pt-2">
            <span>Total:</span>
            <span x-text="'Rp ' + total"></span>
          </div>
        </div>
      </div>

      {{-- Payment Method --}}
      <div class="text-center mb-6">
        <h3 class="text-lg font-semibold mb-2">Payment Method</h3>
        <p class="px-4 py-2 bg-gray-100 rounded-lg inline-block font-bold text-pink-600"
          x-text="$store.checkout.paymentMethodLabel"></p>
      </div>

      {{-- Chat Us Button with WhatsApp Integration --}}
      <div class="text-center">
        <p class="text-gray-600 mb-2">Chat us to send your proof of payment</p>
        <button @click="sendOrderToWhatsApp(); $store.checkout.open = false;"
          class="bg-gradient-to-r from-green-400 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-500 hover:to-green-700 font-semibold shadow-lg transition-all duration-300 flex items-center gap-2 mx-auto">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
          </svg>
          Send Order via WhatsApp
        </button>
      </div>
    </div>

  </div>
</div>

<script>
  // Toast Notification Function for Checkout
  function showCheckoutToast(message, type = 'success') {
    const existingToast = document.getElementById('checkout-toast');
    if (existingToast) {
      existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.id = 'checkout-toast';
    toast.className = 'fixed top-20 right-6 z-[70] transform transition-all duration-500 ease-out';
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(400px)';

    const colors = {
      success: {
        bg: 'from-green-400 to-green-500',
        border: 'border-green-400',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>`
      },
      error: {
        bg: 'from-red-400 to-red-500',
        border: 'border-red-400',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>`
      },
      info: {
        bg: 'from-blue-400 to-blue-500',
        border: 'border-blue-400',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>`
      }
    };

    const color = colors[type] || colors.success;

    toast.innerHTML = `
      <div class="bg-white rounded-xl shadow-2xl border-2 ${color.border} p-4 flex items-center gap-3 min-w-[320px] max-w-[400px]">
        <div class="flex-shrink-0">
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br ${color.bg} rounded-full animate-ping opacity-75"></div>
            <div class="relative bg-gradient-to-br ${color.bg} rounded-full p-2">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${color.icon}
              </svg>
            </div>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm text-gray-800 font-medium">${message}</p>
        </div>
        <button onclick="document.getElementById('checkout-toast').remove()" 
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <div class="h-1 bg-gray-200 rounded-b-xl overflow-hidden mt-1">
        <div class="h-full bg-gradient-to-r ${color.bg} animate-progress"></div>
      </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(0)';
    }, 10);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(400px)';
      setTimeout(() => {
        if (toast.parentNode) {
          toast.remove();
        }
      }, 500);
    }, 3000);
  }

  // Send Order Details to WhatsApp
  function sendOrderToWhatsApp() {
    const checkout = window.Alpine.store('checkout').data;
    const paymentMethod = window.Alpine.store('checkout').paymentMethod;

    // Ambil cart dari backup dulu
    let cart = JSON.parse(localStorage.getItem('last_order_cart') || '[]');

    if (!cart.length) {
      showCheckoutToast('No order found', 'error');
      return;
    }

    const orderId = localStorage.getItem('last_order_id') || 'ORDER-' + Date.now();
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    let itemsList = '';
    cart.forEach((item, index) => {
      itemsList += `${index + 1}. ${item.name}\n`;
      itemsList += `   Qty: ${item.quantity} x Rp ${item.price.toLocaleString()}\n`;
      itemsList += `   Subtotal: Rp ${(item.price * item.quantity).toLocaleString()}\n`;
    });

    const paymentLabel = paymentMethod === 'bank_transfer'
      ? 'Bank Transfer (BCA/Mandiri/BNI)'
      : 'E-Wallet (GoPay/OVO/DANA)';

    let message = `
*BUDS STUDIO - NEW ORDER*

Order ID: ${orderId}

===== ORDER DETAILS =====
${itemsList}

TOTAL: Rp ${total.toLocaleString()}

===== DELIVERY ADDRESS =====
Name: ${checkout.name}
Phone: ${checkout.phone}
Address: ${checkout.address}
${checkout.subdistrict_name}, ${checkout.district_name}
${checkout.city_name}, ${checkout.province_name}
Postal Code: ${checkout.postal_code}

===== PAYMENT METHOD =====
${paymentLabel}

I will send the proof of payment shortly.
Thank you!
`;

    const waNumber = "6281809740724";
    const url = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;

    window.open(url, '_blank');
    showCheckoutToast('Opening WhatsApp...', 'info');

    // Hapus backup cart setelah WhatsApp terbuka
    localStorage.removeItem('last_order_cart');
  }

  // Submit Order to Server
  async function submitOrderToServer() {
    const checkout = window.Alpine.store('checkout').data;
    const paymentMethod = window.Alpine.store('checkout').paymentMethod;
    const cart = JSON.parse(localStorage.getItem(`buds_cart_${document.body.dataset.userId}`) || '[]');

    if (!cart.length) {
      showCheckoutToast('Your cart is empty', 'error');
      return;
    }

    const payload = {
      checkout: checkout,
      payment_method: paymentMethod,
      cart: cart.map(item => ({ id: item.id, quantity: item.quantity }))
    };

    try {
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const res = await fetch("{{ route('checkout.store') }}".replace(window.location.origin, ''), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload),
        credentials: 'same-origin'
      });

      const data = await res.json();

      if (!res.ok) {
        console.error(data);
        showCheckoutToast(data.message || 'Failed to place order', 'error');
        return;
      }

      // Store order ID for WhatsApp message
      localStorage.setItem('last_order_id', data.order_id);

      localStorage.setItem('last_order_cart', JSON.stringify(cart));

      // Move to step 3
      window.Alpine.store('checkout').step = 3;

      // Clear cart
      localStorage.removeItem(`buds_cart_${document.body.dataset.userId}`);

      // Update UI
      const cartItemsEl = document.getElementById('cart-items');
      if (cartItemsEl) cartItemsEl.innerHTML = '';
      const cartTotalEl = document.getElementById('cart-total');
      if (cartTotalEl) cartTotalEl.innerText = 'Rp 0';
      const countEl = document.getElementById('cart-count');
      if (countEl) countEl.innerText = '0';
      const countMobileEl = document.getElementById('cart-count-mobile');
      if (countMobileEl) countMobileEl.innerText = '0';

      showCheckoutToast(`Order placed successfully! Order ID: ${data.order_id}`, 'success');

    } catch (err) {
      console.error(err);
      showCheckoutToast('Failed to place order. Please try again.', 'error');
    }
  }

  document.addEventListener('alpine:init', () => {
    document.addEventListener('place-order', (e) => {
      submitOrderToServer();
    });
  });

  // Update checkout total
  const totalEl = document.getElementById('checkout-total');
  if (totalEl) {
    const cart = JSON.parse(localStorage.getItem(`buds_cart_${document.body.dataset.userId}`) || '[]');
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    totalEl.innerText = 'Rp ' + total.toLocaleString();
  }
</script>