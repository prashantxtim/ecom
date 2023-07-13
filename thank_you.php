<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thank You Screen</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="topheader2">
   <h3>Thank You</h3>
   <p><a href="home.php">Home</a> <span> > Order Successful</span></p>
</div>

<section class="form-container2">

   <form action="" method="post">
      <h3>Thank You!<span>✔️</span></h3>
      <h5>Your purchase is completed. Now, please send us the receipt or the screenshot of the paymant to our email: prashantxtim@gmail.com</h5>
      <a href="shop.php" class="btn">Continue Browsing Products</a>
      <a href="contact.php" class="option-btn">Contact Us</a>
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>