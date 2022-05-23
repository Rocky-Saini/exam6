<?php
@include 'config.php';

if(isset($_POST['add'])){

@$product_id=$_REQUEST['product_id']; 
@$name=$_REQUEST['name'];
@$product_qty=$_REQUEST['product_qty'];
@$unit_price=$_REQUEST['unit_price'];
@$order_value=(int)@$product_qty * (int)@$unit_price;
@$order_date=$_REQUEST['order_date'];
include_once 'config.php';

$sql="INSERT INTO order_master (product_id, order_date, order_qty,order_value) 
          VALUES ('$product_id','$order_date','$product_qty','$order_value')";
mysqli_query($conn,$sql);
if(mysqli_affected_rows($conn)>0) {
    $message[] = 'please fill out all!';  
} else{
echo "some error!";
}
}
if(isset($_GET['delete'])){
   $order_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM order_master WHERE order_id = '$order_id'");
   header('location:admin_page.php');
};

?>
<!-- // @$product_id=$_REQUEST['product_id']; 
// @$name=$_REQUEST['name'];
// @$product_qty=$_REQUEST['product_qty'];
// @$unit_price=$_REQUEST['unit_price'];
// @$ProdValue=(int)$product_qty*(int)$unit_price;
// @$order_date=$_REQUEST['order_date'];
// include_once 'config.php';
//    if(empty($product_name) || empty($product_price) || empty($product_image)){
//       $message[] = 'please fill out all';
//    }else{
//       $insert = "INSERT INTO order_master (product_id, order_date, order_qty)
//         VALUES ('$product_id','$order_date','$product_qty')";
//       $upload = mysqli_query($conn,$insert);
//       if($upload){
//          $message[] = 'new product added successfully';
//       }else{
//          $message[] = 'could not add the product';
//       }
//    }

// }

// @$product_id=$_REQUEST['product_id']; 
// @$name=$_REQUEST['name'];
// @$product_qty=$_REQUEST['product_qty'];
// @$unit_price=$_REQUEST['unit_price'];
// @$ProdValue=(int)$product_qty*(int)$unit_price;
// @$order_date=date('dd/mm/yyyy');
// include_once 'config.php';

// $sql="INSERT INTO order_master (product_id, order_date, order_qty) VALUES ('$product_id','$order_date','$product_qty')";
// mysqli_query($conn,$sql);
// if(mysqli_affected_rows($conn)>0) {
//      echo "save success !";
// } else{
// echo "some error!";
// }

// if(isset($_GET['delete'])){
//    $order_id = $_GET['delete'];
//    mysqli_query($conn, "DELETE FROM order_master WHERE order_id = $order_id");
//    header('location:admin_page.php');
// }; -->



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script type="text/javascript">
      $(document).ready(function(){
            $("#name").blur(function()
            {
                        var errorproduct_qty = true;
                        function validproduct_qty(){
                            product_qty = parseInt($('#product_qty').val());
                            product_qtyOld = parseInt($('#product_qtyOld').val());
                            if (product_qtyOld >= product_qty) {
                                errorproduct_qty = true;
                            } else {
                                errorproduct_qty = false;
                            }
                        }
                        $("#btn").click(function(){
                            validproduct_qty();
                            if (errorproduct_qty) {
                                return true;
                            } else {
                                return false;
                            }
                        })
                        $.ajax({
                            type: "POST",
                            url: "getproductname.php",
                            dataType: "JSON",
                            data: {name:$("#name").val()},
                            success:function(res){
                                if (res) {
                                    $("#errorProductName").html("&#x2611;");
                                    $("#unit_price").val(res.unit_price);
                                    $("#product_qtyOld").val(res.product_qty);
                                    $("#product_id").val(res.product_id);
                                    $("#unit_price").val(res.unit_price);
                                    $("#btn").attr("disabled", false);
                                } else {
                                    $("#errorProductName").html("product not aval !");
                                    $("#unit_price").val("");
                                    $("#product_qtyOld").val("");
                                    $("#product_id").val("");
                                    $("#unit_price").val("");
                                    $("#btn").attr("disabled", true);
                                }
                            }
             })

        })

})

$("#form").validate({
    rule:{
        name:{
           name:true
        },
        messages:{
         required:'please enter product name'
        }
    }
    
   });
</script>
</head>
<body>
<div class="container">

   <div class="admin-product-form-container">
   <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
   <h3>Order Your Product</h3>
   Product Name : <input type="text" class="box" name="name" id="name" required/> <span id="errorProductName"></span>
    <br />
    Product rate : <input type="text" class="box" name="unit_price" readonly id="unit_price" required />
    <br />
    Product date: <input type="date" class="box" name="order_date" id="order_date"  required/>
    Product Qty: <input type="number" class="box" name="product_qty" id="product_qty"  required/>
    <input type="text" style="display: none;" name="product_qtyOld" id="product_qtyOld" /> 
    <input type="text" style="display: none;" name="product_id" id="product_id" />
    <input type="text" style="display: none;" name="unit_price" id="unit_price" />
    <br />
    <input type="submit" class="btn" value="save" name="add" id="btn" disabled />
    <input type="submit" class="btn" value="reset" />
</form> 
   </div>
</div>




<?php

   $select = mysqli_query($conn, "select * from order_master inner join product_master on order_master.product_id=product_master.product_id;");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Order Id</th>
            <th>Product Name</th>
            <th>Order Date</th>
            <th>Order Qty</th>
            <th>Unit Price</th>
            <th>Order Value</th>
            <th>Action</th>

         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
         <td><?php echo $row['order_id']; ?></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['order_date']; ?></td>
            <td><?php echo $row['order_qty']; ?></td>
            <td><?php echo $row['unit_price']; ?></td>
            <td><?php echo $row['order_qty'] * $row['unit_price']?></td>
           
            
            <td>
               <a href="admin_update.php?edit=<?php echo $row['order_id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="admin_page.php?delete=<?php echo $row['order_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<script src="./main.js"></script>
</body>
</html>