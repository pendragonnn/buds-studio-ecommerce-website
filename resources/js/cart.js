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

  // nambah produk ke cart
  function addToCart(product) {
    let cart = getCart();
    const index = cart.findIndex(item => item.id === product.id);

    if (index > -1) {
      // kalau sudah ada, tambahin quantity
      if (cart[index].quantity < cart[index].stock) {
        cart[index].quantity++;
      } else {
        alert("Stock limit reached!");
      }
    } else {
      // kalau belum ada
      cart.push({ ...product, quantity: 1 });
    }

    saveCart(cart);
    renderCart();
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
