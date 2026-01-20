<?php
// checkout.php - client side only: shows order summary and forwards to payment handlers
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Checkout - GuptaCare Pharmacy</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    body { background: linear-gradient(180deg,#f7f9f7,#ffffff); font-family: Arial, sans-serif; }
    .checkout-container {
      width: 850px; margin: 36px auto; background:#fff; padding:28px; border-radius:12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    h1 { text-align:center; color:#0b5a0b; }
    input, select, textarea { width:100%; padding:10px; margin-top:10px; border-radius:6px; border:1px solid #ddd; }
    .summary-box { background:#fafafa; padding:12px; border-radius:6px; margin-top:12px; }
    .place-btn { background:#0b5a0b; color:white; padding:12px 20px; border:none; border-radius:8px; cursor:pointer; font-size:16px; }
  </style>
</head>
<body>

<div class="checkout-container">
  <h1>Checkout</h1>

  <form id="checkoutForm" method="POST">
    <!-- The form action will be set by JS depending on payment method -->

    <h3>Personal Details</h3>
    <input type="text" name="name" id="name" placeholder="Full Name" required>
    <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
    <textarea name="address" id="address" placeholder="Delivery address" rows="3" required></textarea>

    <h3>Payment Method</h3>
    <select name="payment_method" id="payment_method" required>
      <option value="Cash on Delivery">Cash on Delivery</option>
      <option value="UPI">UPI</option>
      <option value="Credit / Debit Card">Credit / Debit Card</option>
    </select>
    <!-- UPI PAYMENT BOX -->
<div id="upiBox" style="display:none; margin-top:20px; text-align:center;">
    <h3>Scan to Pay</h3>
    <img src="images/qr.jpg" alt="UPI QR Code" 
         style="width:250px; border:2px solid #ccc; border-radius:10px; padding:10px;">
    <p style="margin-top:10px; color:green; font-weight:bold;">
        UPI ID: guptamedical@upi
    </p>
</div>


    <h3>Order Summary</h3>
    <div id="orderSummary" class="summary-box"></div>

    <!-- Hidden cart JSON (filled by JS) -->
    <input type="hidden" name="cart" id="cartData">

    <div style="margin-top:16px; display:flex; gap:12px;">
      <button type="submit" class="place-btn">Continue</button>
      <button type="button" id="backBtn" style="background:#eee;border-radius:8px;padding:10px 14px;border:1px solid #ddd;cursor:pointer">Back to shop</button>
    </div>
  </form>
</div>

<script>
// get cart from localStorage
const cart = JSON.parse(localStorage.getItem('cart')) || [];

// show order summary
const orderSummaryEl = document.getElementById('orderSummary');
let subtotal = 0;
if (cart.length === 0) {
  orderSummaryEl.innerHTML = '<p>Your cart is empty — <a href="index.html">Go shopping</a></p>';
} else {
  cart.forEach(item => {
    orderSummaryEl.innerHTML += `<div style="display:flex;justify-content:space-between;padding:6px 0;">
      <div><strong>${item.name}</strong><br><small>Qty: ${item.quantity}</small></div>
      <div>₹${(item.price * item.quantity).toFixed(2)}</div>
    </div>`;
    subtotal += item.price * item.quantity;
  });
  orderSummaryEl.innerHTML += `<hr><p><strong>Subtotal:</strong> ₹${subtotal.toFixed(2)}</p>
    <p><strong>Shipping:</strong> ₹30</p>
    <h3>Total: ₹${(subtotal + 30).toFixed(2)}</h3>`;
}
/*(6)let subtotal = 0;

// cart.forEach(item => {
//   subtotal += item.price * item.quantity;
// });

// // ✅ QUESTION 6 DISCOUNT LOGIC
// let discount = 0;
// if (subtotal > 1000) {
//   discount = subtotal * 0.10; // 10% off
// }

// let shipping = 30;
// let finalTotal = subtotal - discount + shipping;

// orderSummaryEl.innerHTML += `
//   <hr>
//   <p><strong>Subtotal:</strong> ₹${subtotal.toFixed(2)}</p>
//   ${discount > 0 ? `<p style="color:green;"><strong>Discount (10%):</strong> -₹${discount.toFixed(2)}</p>` : ""}
//   <p><strong>Shipping:</strong> ₹${shipping}</p>
//   <h3>Total: ₹${finalTotal.toFixed(2)}</h3>
// `;*/

// write cart JSON into hidden field (send to server)
document.getElementById('cartData').value = JSON.stringify(cart);

// form handling - choose destination based on payment method
const form = document.getElementById('checkoutForm');
form.addEventListener('submit', function(e) {
  if (cart.length === 0) {
    e.preventDefault();
    alert('Your cart is empty.');
    return;
  }

  const payMethod = document.getElementById('payment_method').value;

  // ensure required fields
  const name = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const address = document.getElementById('address').value.trim();
  if (!name || !phone || !address) {
    e.preventDefault();
    alert('Please fill your name, phone and address.');
    return;
  }

  // Set appropriate action:
  if (payMethod === 'Cash on Delivery') {
    form.action = 'place_order.php'; // final save
    // allow submit
  } else if (payMethod === 'UPI') {
    // forward to UPI simulation page (with name/phone/address/cart)
    form.action = 'upi.php';
  } else if (payMethod === 'Credit / Debit Card') {
    form.action = 'card.php';
  }
  // allow submit to chosen action
});

// back to shop button
document.getElementById('backBtn').addEventListener('click', ()=> location.href='index.html');
</script>
<script>
function toggleUPI() {
    let method = document.getElementById("payment_method").value;
    let upi = document.getElementById("upiBox");

    if (method === "UPI") {
        upi.style.display = "block";
    } else {
        upi.style.display = "none";
    }
}
</script>

</body>
</html>
