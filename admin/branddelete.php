<?php
include "./class/brand-class.php";

$brand = new brand;
$brand_id = $_GET['brand_id'];
$delete_brand = $brand->delete_brand($brand_id);
?>
?>