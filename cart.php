<?php
// cart.php - front-end page (cart is stored in browser localStorage)
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Your Cart - Gupta Medical</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .cart-item{display:flex;gap:16px;align-items:center;padding:12px;background:#fff;border-radius:8px;margin-bottom:12px}
    .cart-item img{width:80px;height:80px;object-fit:cover;border-radius:8px}
    .cart-controls input{width:60px;padding:6px}
    #checkoutBtn{background:#006400;color:#fff;padding:10px 18px;border-radius:8px;border:none;cursor:pointer}
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo">Gupta Medical</div>
    <div class="nav-right"><a href="index.html">Continue shopping</a></div>
  </header>

  <main class="container" style="padding:40px 20px;max-width:1000px;margin:0 auto;">
    <h2>Your Cart</h2>
    <div id="cartArea"></div>

    <div id="cartSummary" style="margin-top:20px;"></div>
  </main>

<script>
// --- cart client-side logic (reads localStorage 'cart') ---
const CART_KEY = 'cart';

function getCart(){ return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); }
function saveCart(c){ localStorage.setItem(CART_KEY, JSON.stringify(c)); renderCart(); }

function renderCart(){
  const area = document.getElementById('cartArea');
  const summary = document.getElementById('cartSummary');
  const cart = getCart();
  area.innerHTML = '';
  if(cart.length === 0){
    area.innerHTML = '<p>Your cart is empty. <a href="index.html">Shop now</a></p>';
    summary.innerHTML = '';
    return;
  }

  let total = 0;
  cart.forEach((it, idx) => {
    const subtotal = (it.price * it.quantity);
    total += subtotal;

    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <img src="${it.image || 'images/placeholder.png'}" alt="${it.name}">
      <div style="flex:1">
        <strong>${it.name}</strong>
        <div style="color:#666;margin-top:6px">Price: ₹${it.price}</div>
      </div>
      <div class="cart-controls">
        <label>Qty</label><br>
        <input type="number" min="1" value="${it.quantity}" data-idx="${idx}" class="qty-input">
      </div>
      <div style="width:120px;text-align:right">
        <div style="font-weight:700">₹${subtotal}</div>
        <button data-idx="${idx}" class="remove-btn" style="margin-top:8px;padding:6px 10px;border-radius:6px;border:1px solid #ccc;background:#fff;cursor:pointer">Remove</button>
      </div>
    `;
    area.appendChild(div);
  });

  // summary with checkout button
  summary.innerHTML = `
    <h3>Subtotal: ₹${total.toFixed(2)}</h3>
    <div style="margin-top:10px">
      <button id="checkoutBtn">Proceed to Checkout</button>
      <button id="clearBtn" style="margin-left:10px;background:#eee;border:1px solid #ccc;padding:8px;border-radius:6px">Clear Cart</button>
    </div>
  `;
// QUESTION 6: Discount logic
// let discount = 0;
// if (total > 1000) {
//   discount = total * 0.10; // 10% discount
// }

// let finalTotal = total - discount;

// summary.innerHTML = `
//   <h3>Subtotal: ₹${total.toFixed(2)}</h3>
//   ${discount > 0 ? `<p style="color:green;">Discount (10%): -₹${discount.toFixed(2)}</p>` : ""}
//   <h3>Total Payable: ₹${finalTotal.toFixed(2)}</h3>

//   <div style="margin-top:10px">
//     <button id="checkoutBtn">Proceed to Checkout</button>
//     <button id="clearBtn">Clear Cart</button>
//   </div>
// `;

  // attach events
  document.querySelectorAll('.qty-input').forEach(inp=>{
    inp.addEventListener('change', e=>{
      const idx = e.target.dataset.idx;
      let v = parseInt(e.target.value) || 1;
      const cart = getCart();
      cart[idx].quantity = v;
      saveCart(cart);
    });
  });

  document.querySelectorAll('.remove-btn').forEach(b=>{
    b.addEventListener('click', e=>{
      const idx = parseInt(b.dataset.idx);
      const cart = getCart();
      cart.splice(idx,1);
      saveCart(cart);
    });
  });

  document.getElementById('checkoutBtn').addEventListener('click', ()=>{
    // pass cart to checkout via localStorage (checkout reads cart itself)
    window.location.href = 'checkout.php';
  });

  document.getElementById('clearBtn').addEventListener('click', ()=>{
    if(!confirm('Clear entire cart?')) return;
    localStorage.removeItem(CART_KEY);
    renderCart();
  });
}

document.addEventListener('DOMContentLoaded', renderCart);
</script>

</body>

</html>
