document.addEventListener("DOMContentLoaded", () => {
  const cartKey = "buds_cart";

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

  // render cart ke sidebar
  function renderCart() {
    let cart = getCart();
    const cartContainer = document.getElementById("cart-items");
    const totalEl = document.getElementById("cart-total");
    const countEl = document.getElementById("cart-count");
    const countMobileEl = document.getElementById("cart-count-mobile");

    cartContainer.innerHTML = "";
    let total = 0;
    let count = 0;

    cart.forEach(item => {
      let isOut = item.stock <= 0;

      if (!isOut) {
        total += item.price * item.quantity;
        count += item.quantity;
      }

      cartContainer.innerHTML += `
          <div class="flex items-center gap-4 border-b pb-4 mb-4">
              <img src="${item.image_url}" class="w-16 h-16 object-cover rounded" />
              <div class="flex-1">
                  <p class="font-semibold ${isOut ? 'text-red-500' : ''}">${item.name}</p>
                  <p class="text-sm">Quantity: ${item.quantity}</p>
                  <p class="text-sm">Rp ${item.price.toLocaleString()}</p>
                  ${isOut ? '<p class="text-xs text-red-600">Out of stock</p>' : ''}
              </div>
              <button class="text-red-500 text-sm" onclick="removeFromCart(${item.id})">Remove</button>
          </div>
        `;
    });

    totalEl.textContent = `Rp ${total.toLocaleString()}`;
    countEl.textContent = count;
    countMobileEl.textContent = count;
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

  // biar pertama kali langsung render
  renderCart();

  // expose function buat onclick remove
  window.removeFromCart = removeFromCart;
});

function updateCheckoutTotal() {
    const cart = JSON.parse(localStorage.getItem('buds_cart') || '[]');
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('checkout-total').innerText = 'Rp ' + total.toLocaleString();
}
document.addEventListener('DOMContentLoaded', updateCheckoutTotal);

