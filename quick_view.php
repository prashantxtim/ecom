<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<div class="topheader2">
   <h3>Product Details</h3>
   <p><a href="home.php">Home</a> <span> > Product Details</span></p>
</div>

<section class="quick-view">

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <input type="hidden" name="link" value="<?= $fetch_product['link']; ?>">

      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
            
         </div>
         <div class="content">
            <div class="flex">
               <div class="name"><?= $fetch_product['name']; ?></div>
            </div>
            <div class="flex">
               <div class="description"><?= $fetch_product['description']; ?></div>
            </div>
            
            <div class="flex">
               <div class="price"><span>Nrs. </span><?= $fetch_product['price']; ?><span>/-</span></div>
               <input type="number" name="qty" class="qty" min="1" max="1" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <div class="flex-btn">
               <input type="submit" value="add to cart" class="btn" name="add_to_cart">
            </div>
            <br>
            <div class="flex-btn">
               <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
         </div>

      </div>

      <div class="row3">
         <dev class = "content">
            <a href="#" class="btn2">Descriptions</a>
         </dev>
         <div class="content">
            <!-- <a href="#" class="btn2">Descriptions</a> -->
            <div class="name">Product Details</div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="details_points"><?= $fetch_product['details_points']; ?></div>
         </div>
      </div>

      
   </form>


   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>