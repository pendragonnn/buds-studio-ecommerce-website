document.addEventListener("DOMContentLoaded", () => {
  // ambil userId dari body attribute (di Blade kasih: <body data-user-id="{{ auth()->id() ?? 'guest' }}">
  const userId = document.body.dataset.userId || "guest";
  const cartKey = `buds_cart_${userId}`;

  // ambil cart dari localStorage
  function getCart() {
    return JSON.parse(localStorage.getItem(cartKey)) || [];
  }

  function saveCart(cart) {
    localStorage.setItem(cartKey, JSON.stringify(cart));
  }

  // Toast Notification Function
  function showToast(productName, isUpdate = false) {
    // Remove existing toast if any
    const existingToast = document.getElementById('cart-toast');
    if (existingToast) {
      existingToast.remove();
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.id = 'cart-toast';
    toast.className = 'fixed top-20 right-6 z-[60] transform transition-all duration-500 ease-out';
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(400px)';
    
    toast.innerHTML = `
      <div class="bg-white rounded-xl shadow-2xl border-2 border-green-400 p-4 flex items-center gap-3 min-w-[320px] max-w-[400px]">
        <!-- Success Icon with Animation -->
        <div class="flex-shrink-0">
          <div class="relative">
            <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
            <div class="relative bg-gradient-to-br from-green-400 to-green-500 rounded-full p-2">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
          </div>
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
          <p class="font-bold text-gray-800 text-sm mb-1">
            ${isUpdate ? 'Quantity Updated!' : 'Added to Cart!'}
          </p>
          <p class="text-xs text-gray-600 truncate">
            <span class="font-semibold text-pink-600">${productName}</span>
          </p>
        </div>
        
        <!-- Close Button -->
        <button onclick="document.getElementById('cart-toast').remove()" 
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      
      <!-- Progress Bar -->
      <div class="h-1 bg-gray-200 rounded-b-xl overflow-hidden mt-1">
        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 animate-progress"></div>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove after 3 seconds
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

  // nambah produk ke cart
  function addToCart(product) {
    let cart = getCart();
    const index = cart.findIndex(item => item.id === product.id);
    let isUpdate = false;

    if (index > -1) {
      // kalau sudah ada, tambahin quantity
      if (cart[index].quantity < cart[index].stock) {
        cart[index].quantity++;
        isUpdate = true;
      } else {
        alert("Stock limit reached!");
        return;
      }
    } else {
      // kalau belum ada
      cart.push({ ...product, quantity: 1 });
    }

    saveCart(cart);
    renderCart();
    
    // Show toast notification
    showToast(product.name, isUpdate);
  }

  // hapus produk dari cart
  function removeFromCart(id) {
    let cart = getCart().filter(item => item.id !== id);
    saveCart(cart);
    renderCart();
  }

  // render cart ke sidebar & checkout
  function renderCart() {
    let cart = getCart();
    const cartContainer = document.getElementById("cart-items");
    const totalEl = document.getElementById("cart-total");
    const checkoutTotalEl = document.getElementById("checkout-total");
    const checkoutTotalFinalEl = document.getElementById("checkout-total-final");
    const countEl = document.getElementById("cart-count");
    const countMobileEl = document.getElementById("cart-count-mobile");

    if (cartContainer) cartContainer.innerHTML = "";
    let total = 0;
    let count = 0;

    cart.forEach(item => {
      let isOut = item.stock <= 0;

      if (!isOut) {
        total += item.price * item.quantity;
        count += item.quantity;
      }

      if (cartContainer) {
        cartContainer.innerHTML += `
          <div class="flex items-center gap-4 border-b pb-4 mb-4">
            <img src="${item.image_url}" class="w-16 h-16 object-cover rounded" />
            <div class="flex-1">
              <p class="font-semibold ${isOut ? 'text-red-500' : ''}">${item.name}</p>
              <p class="text-sm">Quantity: ${item.quantity}</p>
              <p class="text-sm">Rp ${item.price.toLocaleString()}</p>
              ${isOut ? '<p class="text-xs text-red-600">Out of stock</p>' : ''}
            </div>
            <button class="text-white bg-pink-200 text-sm p-2 rounded-lg hover:bg-pink-500" onclick="removeFromCart(${item.id})">Remove</button>
          </div>
        `;
      }
    });

    // Update semua UI
    if (totalEl) totalEl.textContent = `Rp ${total.toLocaleString()}`;
    if (checkoutTotalEl) checkoutTotalEl.textContent = `Rp ${total.toLocaleString()}`;
    if (checkoutTotalFinalEl) checkoutTotalFinalEl.textContent = `Rp ${total.toLocaleString()}`;
    if (countEl) countEl.textContent = count;
    if (countMobileEl) countMobileEl.textContent = count;
  }

  // Event listener buat add-to-cart
  document.querySelectorAll(".add-to-cart-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const product = {
        id: parseInt(btn.dataset.id),
        name: btn.dataset.name,
        price: parseInt(btn.dataset.price),
        stock: parseInt(btn.dataset.stock),
        image_url: btn.dataset.image,
      };

      addToCart(product);
    });
  });

  // render cart pertama kali
  renderCart();

  // expose function buat onclick remove
  window.removeFromCart = removeFromCart;

  // update checkout total pas DOM ready
  updateCheckoutTotal();
  
  function updateCheckoutTotal() {
    const cart = getCart();
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const checkoutTotal = document.getElementById('checkout-total');
    if (checkoutTotal) checkoutTotal.innerText = 'Rp ' + total.toLocaleString();
  }
});

// Add CSS for progress bar animation
const style = document.createElement('style');
style.textContent = `
  @keyframes progress {
    from {
      width: 100%;
    }
    to {
      width: 0%;
    }
  }
  
  .animate-progress {
    animation: progress 3s linear forwards;
  }
`;
document.head.appendChild(style);