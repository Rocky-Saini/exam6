<?php
$ProdID=$_REQUEST['ProdID']; 
$ProdName=$_REQUEST['ProdName'];
$ProdQty=$_REQUEST['ProdQty'];
$ProdRate=$_REQUEST['ProdRate'];
$ProdValue=(int)$ProdQty*(int)$ProdRate;
$date=date('dd/mm/yyyy');
include_once 'config.php';

$sql="INSERT INTO order_master (OrderDate, ProdID, ProdRate, OrderQty, OrderValue)
 VALUES ('$date', '$ProdID', '$ProdRate', '$ProdQty', '$ProdValue')";
mysqli_query($conn,$sql);
if(mysqli_affected_rows($conn)>0) {
     echo "save success !";
} else{
echo "some error!";
}
?>