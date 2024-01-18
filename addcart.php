<?php
session_start();
include "./admin/database.php";
//plus product
if(isset($_GET['add'])){
    $product_id = $_GET['add'];
    foreach($_SESSION['cart'] as $cart_item){
        if($cart_item['product_id']!=$product_id){
            $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
            'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
            'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
            $_SESSION['cart'] = $product;
        }else{
            $increase = $cart_item['total'] + 1;
            if($cart_item['total']<20){
                $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
                'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                'product_img'=>$cart_item['product_img'], 'total'=>$increase);
            }else{
                $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
                'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
            }
            $_SESSION['cart'] = $product;
        }
    }
    header('location:cart.php');
}

//subtract product
if(isset($_GET['sub'])){
    $product_id = $_GET['sub'];
    foreach($_SESSION['cart'] as $cart_item){
        if($cart_item['product_id']!=$product_id){
            $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
            'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
            'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
            $_SESSION['cart'] = $product;
        }else{
            $increase = $cart_item['total'] - 1;
            if($cart_item['total']>1){
                $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
                'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                'product_img'=>$cart_item['product_img'], 'total'=>$increase);
            }else{
                $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
                'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
            }
            $_SESSION['cart'] = $product;
        }
    }
    header('location:cart.php');
}

//delete chosen product
if(isset($_SESSION['cart']) && isset($_GET['delete'])){
    $product_id = $_GET['delete'];
    foreach($_SESSION['cart'] as $cart_item){
        if($cart_item['product_id']!=$product_id){
            $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
            'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
            'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
        }
    }
    $_SESSION['cart'] = $product;
    header('location:cart.php');
}

//delete all products in cart
if(isset($_GET['delete_all']) && $_GET['delete_all']==1){
    unset($_SESSION['cart']);
    header('location:cart.php');
}

//add product to cart
if(isset($_POST['addcart'])){
    $product_id = $_GET['id'];
    $plus = $_POST['plus'];
    $query = "SELECT * FROM tbl_product
    JOIN tbl_brand
    ON tbl_product.brand_id = tbl_brand.brand_id
    WHERE product_id = $product_id LIMIT 1";
    $query_link = mysqli_query($con,$query);
    $row = $query_link->fetch_array();
    if($row){
        $new_product = array(array('product_name'=>$row['product_name'], 'brand_name'=>$row['brand_name'], 
        'product_id'=>$product_id, 'product_sale'=>$row['product_sale'], 
        'product_img'=>$row['product_img'], 'total'=>$plus));
        if(isset($_SESSION['cart'])){
            $found = false;
            foreach($_SESSION['cart'] as $cart_item){
                if($cart_item['product_id']==$product_id){
                    $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'], 
                    'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                    'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']+$plus);
                    $found = true;
                }else{
                    $product[] = array('product_name'=>$cart_item['product_name'], 'brand_name'=>$cart_item['brand_name'],
                    'product_id'=>$cart_item['product_id'], 'product_sale'=>$cart_item['product_sale'], 
                    'product_img'=>$cart_item['product_img'], 'total'=>$cart_item['total']);
                }
            }
            if($found == false){
                $_SESSION['cart'] = array_merge($product,$new_product);
            }else{
                $_SESSION['cart'] = $product;
            }
        }else{
            $_SESSION['cart'] = $new_product;
        }
    }
    header('location:cart.php');
    // print_r($_SESSION['cart']);
}
?>