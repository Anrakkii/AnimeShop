<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>

<?php
    if($_GET['status'] && isset($_GET['cart_code'])){
        $status = $_GET['status'];
        $code = $_GET['cart_code'];
        $sql = "UPDATE tbl_cart SET cart_status ='$status' WHERE cart_code ='$code' ";
        $sql_link = mysqli_query($con,$sql);
        header('location:orders_manager.php');
    } 
?>