<?php
    include("./admin/config.php");
?>

<?php
    // $sql_menu = "SELECT * FROM tbl_category ORDER BY category_id DESC";
    // $query_menu = mysqli_query($con,$sql_menu);
    // $string_temp = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    // $string_name = str_replace(".php","",$string_temp);
    // $sql_link = "SELECT category_name FROM tbl_category WHERE tbl_category.category_php_name='$string_name'";
    // $query_link = mysqli_query($con,$sql_link);
    $string = $_POST['urlFilename'];
    $string_name = str_replace(".php","",$string);
?>

<?php

if(isset($_POST["action"])){
    $query = "SELECT * FROM tbl_product 
    JOIN tbl_category 
    ON tbl_product.category_id = tbl_category.category_id
    JOIN tbl_brand
    ON tbl_brand.brand_id = tbl_product.brand_id
    WHERE tbl_product.category_id=tbl_category.category_id
    AND tbl_category.category_php_name='$string_name' ";
    if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && 
    !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])){
        $query .= "AND product_price BETWEEN '".$_POST["minimum_price"]."' AND
        '".$_POST["maximum_price"]."'";
    }
    if(isset($_POST["brand_name"])){
        $brand_filter = implode("','", $_POST["brand_name"]);
        $query .= "AND brand_name IN('".$brand_filter."')";
    }
    
    $statement = $con->prepare($query);
    $statement->execute();
    $statement->store_result();
    $total_row = $statement->num_rows();
    $statement2 = $con->prepare($query);
    $statement2->execute();
    $data = $statement2->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $output = '';

    if($total_row > 0){
        foreach($result as $row){
            $output .= 
            '<div class="category-right-content-item">
                <div class= "category-right-content-item-img">
                    <a href="product.php?id='.$row['product_id'].'"><img src="./admin/uploads/'.$row['product_img'].'"></a>
                </div>
                <a href="product.php?id='.$row['product_id'].'"><h1>'.$row['product_name'].'</h1></a>
                <p>'.number_format($row['product_price'],0,',','.').'<sup>đ</sup></p>
                <p>SALE: '.number_format($row['product_sale'],0,',','.').'<sup>đ</sup></p>
            </div>';
        }
    }else{
        $output = '<h3>Hiện không có sản phẩm</h3>';
    }
    echo $output;

}
?>

