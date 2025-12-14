<?php
// place_order.php - final order receiver
$cartJSON = $_POST['cart'] ?? '[]';
$cart = json_decode($cartJSON, true);
if (!is_array($cart)) $cart = [];

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$payment_method = $_POST['payment_method'] ?? 'Unknown';
$payment_status = $_POST['payment_status'] ?? 'pending';

// compute totals
$subtotal = 0;
foreach ($cart as $it) {
    $price = floatval($it['price'] ?? 0);
    $qty = intval($it['quantity'] ?? ($it['qty'] ?? 1));
    $subtotal += $price * $qty;
}
$shipping = 30;
$total = round($subtotal + $shipping, 2);

// create order record (one-line JSON)
$order = [
    'time' => date('Y-m-d H:i:s'),
    'name' => $name,
    'phone' => $phone,
    'address' => $address,
    'payment_method' => $payment_method,
    'payment_status' => $payment_status,
    'items' => $cart,
    'subtotal' => $subtotal,
    'shipping' => $shipping,
    'total' => $total
];

file_put_contents('orders.txt', json_encode($order, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Order Placed - GuptaCare Pharmacy</title>
  <style>
    body{font-family:Arial;background:#f7f7f7}
    .box{width:700px;margin:48px auto;background:#fff;padding:28px;border-radius:12px;box-shadow:0 6px 16px rgba(0,0,0,0.08)}
    h1{color:#0b5a0b}
    .small{color:#444}
    .btn{display:inline-block;margin-top:16px;padding:10px 14px;border-radius:8px;background:#0b5a0b;color:#fff;text-decoration:none}
  </style>
</head>
<body>
<div class="box">
    <h1 style="color:green; font-size:32px; margin-bottom:5px;">
        🎉 Order Placed Successfully!
    </h1>

    <p class="small" style="font-size:18px; margin-bottom:20px;">
        Thanks <strong><?php echo htmlspecialchars($name); ?></strong>.  
        Your order has been recorded.
    </p>

    <!-- Delivery Message Box -->
    <div style="
        background:#e9ffe9;
        padding:16px 20px;
        border-radius:10px;
        border:2px solid #baf4ba;
        margin:0 auto 20px;
        max-width:500px;
        font-size:17px;
        line-height:1.6;
        color:#0c4f0c;
    ">
        📦 <strong>Your order has been received!</strong><br>
        🚚 Expected Delivery: <strong>2–3 working days</strong><br>
        📞 We may contact you for confirmation if required.
    </div>

    <a href="index.html" style="
        display:inline-block;
        background:green;
        color:white;
        padding:12px 22px;
        border-radius:6px;
        font-size:17px;
        text-decoration:none;
        margin-top:10px;
    ">Continue Shopping</a>
</div>


<script>
// clear cart on client after successful place
localStorage.removeItem('cart');
</script>
</body>
</html>

