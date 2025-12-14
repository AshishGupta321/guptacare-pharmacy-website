<?php
// upi.php - receives POST from checkout.php with cart + fields
$cartJSON = $_POST['cart'] ?? '[]';
$cart = json_decode($cartJSON, true);

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$payment_method = 'UPI';

// You can compute subtotal here if you like (not necessary)
$subtotal = 0;
if (is_array($cart)) {
    foreach ($cart as $it) { $subtotal += ($it['price'] * $it['quantity']); }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>UPI Payment - GuptaCare Pharmacy</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    body{font-family:Arial;background:#f7f7f7}
    .box{width:640px;margin:36px auto;background:#fff;padding:24px;border-radius:10px;box-shadow:0 6px 16px rgba(0,0,0,0.06)}
    .upi-qr{display:flex;gap:18px;align-items:center}
    .qr{width:180px;height:180px;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center;font-size:14px}
    .pay-btn{background:#0b5a0b;color:#fff;padding:10px 16px;border-radius:8px;border:none;cursor:pointer}
  </style>
</head>
<body>
<div class="box">
  <h2>Pay using UPI</h2>
  <p>Please scan the QR or use UPI ID: <strong>guptacare@upi</strong></p>

 <div class="upi-qr">
    
    <!-- LEFT SMALL BOX -->
    <div class="upi-left-box">
        <h3 style="margin-bottom:10px;">UPI Payment</h3>

        <div class="upi-qr-box">
            <img src="images/qr.jpg" 
                 alt="UPI QR Code"
                 style="width:160px; border:2px solid #ddd; border-radius:12px; padding:10px;">
        </div>

        <div class="or-text">OR</div>

        <label class="method-option">
            <input type="radio" checked> Card (Coming Soon)
        </label>
    </div>


    <div>
      <p><strong>Order for:</strong> <?php echo htmlspecialchars($name); ?></p>
      <p><strong>Amount:</strong> ₹<?php echo number_format($subtotal + 30,2); ?></p>
      <p>After you complete payment in your UPI app, click the button below to confirm payment.</p>
      <!-- This form will forward all details to place_order.php with payment_method and payment_status -->
      <form action="place_order.php" method="POST">
        <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
        <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($payment_method); ?>">
        <input type="hidden" name="payment_status" value="paid">
        <input type="hidden" name="cart" value='<?php echo json_encode($cart, JSON_HEX_APOS|JSON_HEX_QUOT); ?>'>
        <button type="submit" class="pay-btn">I have paid (Confirm)</button>
      </form>
    </div>
  </div>
  <p style="margin-top:14px"><a href="checkout.php">Back to checkout</a></p>
</div>
</body>
</html>
