// pastikan script ini dimuat setelah Alpine & DOM ready
async function submitOrderToServer() {
    // read checkout data from Alpine store
    const checkout = window.Alpine.store('checkout').data;
    const paymentMethod = window.Alpine.store('checkout').paymentMethod;
    const cart = JSON.parse(localStorage.getItem('buds_cart') || '[]');

    if (!cart.length) {
        alert('Your cart is empty');
        return;
    }

    // Build payload
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
            // server responded with error (validation/stock)
            console.error(data);
            // show user-friendly message
            if (data.message) alert(data.message);
            return;
        }

        // success
        console.log('order created:', data);
        // move to step 3 in Alpine store, show confirmation UI
        window.Alpine.store('checkout').step = 3;

        // clear cart & update UI counts
        localStorage.removeItem('buds_cart');
        const cartItemsEl = document.getElementById('cart-items');
        if (cartItemsEl) cartItemsEl.innerHTML = '';
        const cartTotalEl = document.getElementById('cart-total');
        if (cartTotalEl) cartTotalEl.innerText = 'Rp 0';
        const countEl = document.getElementById('cart-count');
        if (countEl) countEl.innerText = '0';
        const countMobileEl = document.getElementById('cart-count-mobile');
        if (countMobileEl) countMobileEl.innerText = '0';

        // optional: show success toast
        alert('Order placed successfully! Order ID: ' + data.order_id);
        localStorage.removeItem('buds_cart')
    } catch (err) {
        console.error(err);
        alert('Failed to place order. Please try again.');
    }
}
