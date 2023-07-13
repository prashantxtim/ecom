<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
}

$message = [];

if (isset($_POST['order'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = ''; 
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];
   $link = $_POST['link'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {
      $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $link]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';
      header('Location: thank_you.php');
      exit;
   } else {
      $message[] = 'Your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>
   <div class="topheader2">
      <h3>Checkout</h3>
      <p><a href="home.php">Home</a> <span> > Checkout</span></p>
   </div>
   <section class="checkout-orders">

      <?php if (!empty($message)) : ?>
         <div class="message">
            <?php foreach ($message as $msg) : ?>
               <p><?= $msg ?></p>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>

      <form action="" method="POST">

         <h3>Your Orders</h3>

         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items = [];
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $all_links[] = $fetch_cart['link'] . ', ';
                  $link = implode($all_links);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                  <p><?= $fetch_cart['name'] ?> <span>(<?= 'Nrs. ' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity'] ?>)</span></p>
            <?php
               }
            } else {
               echo '<p class="empty">Your cart is empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total ?>">
            <input type="hidden" name="link" value="<?= $link ?>">
            <div class="grand-total">Grand Total: <span>Nrs. <?= $grand_total ?>/-</span></div>
         </div>

         <h3>Place Your Orders</h3>

         <div class="flex">
            <div class="inputBox">
               <span>Your Name:</span>
               <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>Your Number:</span>
               <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>Your Email:</span>
               <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Payment Method:</span>
               <select name="method" class="box" required>
                  <option value="IME Pay">IME Pay: 9840358372</option>
                  <option value="Khalti">Khalti: 9840358372</option>
                  <option value="Esewa">Esewa: 9840358372</option>
               </select>
            </div>
         </div>

         <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled' ?>" value="Place Order">

      </form>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>
