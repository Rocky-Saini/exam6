<?php
$name=$_REQUEST['name'];
include_once 'config.php';
$sql = "select * from product_master where name='$name'";
$resource=mysqli_query($conn,$sql); 
$arr=mysqli_fetch_assoc($resource); 
echo json_encode($arr); 
?>