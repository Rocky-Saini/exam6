<?php

@include 'config.php';

$order_id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $product_id = $_POST['product_id'];
   $order_date = $_POST['order_date'];
   $order_qty = $_POST['order_qty'];
 

   if(empty($product_id) || empty($order_date) || empty($order_qty)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE order_master SET  order_date='$order_date', order_qty='$order_qty'  WHERE  order_id = '$order_id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         // move_uploaded_file($product_image_tmp_name, $product_image_folder);
         header('location:admin_page.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">
<div class="admin-product-form-container centered">
   <?php
      $select = mysqli_query($conn, "select * from order_master inner join product_master on order_master.product_id=product_master.product_id where order_id='$order_id';");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" >
      <h3 class="title">update the product</h3>
      <input type="text" readonly class="box" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>" placeholder="enter the product name">
      <input type="text" readonly class="box" name="name" id="name" value="<?php echo $row['name']; ?>" placeholder="enter the product name">
      <input type="text" readonly class="box" name="unit_price" id="unit_price" value="<?php echo $row['unit_price']; ?>" placeholder="enter the product name">
      <input type="date"  class="box" name="order_date" id="order_date" value="<?php echo $row['order_date']; ?>" placeholder="enter the product price">
      <input type="number" min="0" class="box" name="order_qty" id="order_qty" value="<?php echo $row['order_qty']; ?>" placeholder="enter the product price">
  
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="admin_page.php" class="btn">go back!</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>