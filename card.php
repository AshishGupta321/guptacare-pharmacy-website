<?php
$cartJSON = $_POST['cart'] ?? '[]';
$cart = json_decode($cartJSON, true);

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$payment_method = 'Card';

$subtotal = 0;
if (is_array($cart)) {
    foreach ($cart as $it) { $subtotal += ($it['price'] * $it['quantity']); }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Card Payment - GuptaCare Pharmacy</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    body{font-family:Arial;background:#f7f7f7}
    .box{width:640px;margin:36px auto;background:#fff;padding:24px;border-radius:10px;box-shadow:0 6px 16px rgba(0,0,0,0.06)}
    .card-inputs input {width:100%; padding:10px; margin:8px 0; border-radius:6px; border:1px solid #ddd}
    .pay-btn{background:#0b5a0b;color:#fff;padding:10px 16px;border-radius:8px;border:none;cursor:pointer}
  </style>
</head>
<body>
<div class="box">
  <h2>Enter Card Details (Demo)</h2>
  <p>Card payments are simulated for the project. Enter dummy card info and press Pay to continue.</p>

  <form action="place_order.php" method="POST" class="card-inputs">
    <input type="text" name="card_number" placeholder="Card number (xxxx xxxx xxxx xxxx)" required>
    <input type="text" name="card_name" placeholder="Name on card" required>
    <input type="text" name="card_exp" placeholder="Expiry MM/YY" required>
    <input type="text" name="card_cvv" placeholder="CVV" required>

    <!-- forward original fields -->
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
    <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($payment_method); ?>">
    <input type="hidden" name="payment_status" value="paid">
    <input type="hidden" name="cart" value='<?php echo json_encode($cart, JSON_HEX_APOS|JSON_HEX_QUOT); ?>'>

    <button type="submit" class="pay-btn">Pay ₹<?php echo number_format($subtotal+30,2); ?></button>
  </form>

  <p style="margin-top:12px"><a href="checkout.php">Back to checkout</a></p>
</div>
</body>
</html>
