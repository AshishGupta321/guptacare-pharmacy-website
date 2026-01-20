// Key for storing cart in browser
const CART_KEY = "cart";

// Get cart from localStorage
function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || [];
}

// Save cart to localStorage
function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}


// ===============================
//   MAIN FUNCTION → ADD TO CART
// ===============================
// ALWAYS call: addToCart(productId, quantity)

function addToCart(productId, qty = 1) {

    // find product from master list
    let product = window.allProducts.find(p => p.id === productId);
    if (!product) {
        alert("Product not found!");
        return;
    }

    let cart = getCart();
    
    let existing = cart.find(item => item.id === productId);

    if (existing) {
        existing.quantity += qty;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: qty
        });
    }

    saveCart(cart);
    updateCartCount();
    alert(product.name + " added to cart!");
}



// Clear entire cart
function clearCart() {
    localStorage.removeItem(CART_KEY);
}



// ===============================
//   RENDER CART PAGE
// ===============================

function renderCartPage() {
    let container = document.getElementById("cartArea");
    if (!container) return;

    let cart = getCart();

    container.innerHTML = "";

    if (cart.length === 0) {
        container.innerHTML = `
            <p>Your cart is empty.</p>
            <a href="index.html" class="btn">Continue Shopping</a>
        `;
        return;
    }

    let total = 0;

    cart.forEach((item, index) => {
        let amount = item.price * item.quantity;
        total += amount;

        let row = document.createElement("div");
        row.classList.add("cart-item");

        row.innerHTML = `
            <img src="${item.image}" class="cart-img">
            <div class="cart-info">
                <h3>${item.name}</h3>
                <p>Price: ₹${item.price}</p>
            </div>

            <div class="cart-qty">
                <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="qty-input">
            </div>

            <div class="cart-amount">₹${amount}</div>

            <button class="remove-btn" data-index="${index}">Remove</button>
        `;

        container.appendChild(row);
    });

    document.getElementById("cartSummary").innerHTML = `
        <h3>Subtotal: ₹${total}</h3>
        <button id="checkoutBtn" class="btn-green">Proceed to Checkout</button>
        <button id="clearCartBtn" class="btn-grey">Clear Cart</button>
    `;

    // quantity change
    document.querySelectorAll(".qty-input").forEach(input => {
        input.addEventListener("change", () => {
            let i = input.dataset.index;
            cart[i].quantity = parseInt(input.value);
            saveCart(cart);
            renderCartPage();
        });
    });

    // remove item
    document.querySelectorAll(".remove-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            let i = btn.dataset.index;
            cart.splice(i, 1);
            saveCart(cart);
            renderCartPage();
        });
    });

    document.getElementById("checkoutBtn").onclick = () => {
        window.location.href = "checkout.php";
    };

    document.getElementById("clearCartBtn").onclick = () => {
        clearCart();
        renderCartPage();
    };
}



// ===============================
//   CHECKOUT SUMMARY
// ===============================

function renderCheckoutSummary() {
    let area = document.getElementById("summaryArea");
    let totals = document.getElementById("summaryTotals");
    let cart = getCart();

    if (!area || !totals) return;

    if (cart.length === 0) {
        area.innerHTML = "<p>Your cart is empty!</p>";
        return;
    }

    let subtotal = 0;

    area.innerHTML = "";
    cart.forEach(item => {
        let amount = item.price * item.quantity;
        subtotal += amount;

        area.innerHTML += `
            <div class="summary-row">
                <span>${item.name} × ${item.quantity}</span>
                <span>₹${amount}</span>
            </div>
        `;
    });

    let gst = subtotal * 0.12;
    let discount = 0;
    let total = subtotal + gst - discount;

    totals.innerHTML = `
        <p>Subtotal: ₹${subtotal}</p>
        <p>GST (12%): ₹${gst.toFixed(2)}</p>
        <p>Discounts: ₹${discount}</p>
        <h3>Total: ₹${total.toFixed(2)}</h3>
    `;

    let hidden = document.getElementById("cartData");
    if (hidden) hidden.value = JSON.stringify(cart);
}



// ===============================
//   CART COUNT BUBBLE
// ===============================

function updateCartCount() {
    let cart = getCart();
    let count = 0;
    cart.forEach(item => count += item.quantity);

    let bubble = document.getElementById("cartCount");
    if (bubble) bubble.textContent = count;
}

document.addEventListener("DOMContentLoaded", updateCartCount);


// ===============================
//   USED BY ALL BUTTONS
// ===============================
function addProductById(id) {
    addToCart(id, 1);
}
