<?php
include "./class/product-class.php";

$product = new product;
$product_id = $_GET['product_id'];
$delete_product = $product->delete_product($product_id);
$delete_product_img_desc = $product->delete_product_img_desc($product_id);
?>
?>