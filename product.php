<?php
    include("./main/header.php");
    include("./admin/class/product-class.php");
?>

<?php
    $product = new product;
    $show_product = $product->show_product();
    $get_img_desc = $product->show_img_desc();
    $string_temp = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    $product_id = $_GET['id'];
?>

<!---------------------------Product------------------------------------->
<section class="product container">
        <div class= "product-top row">
        <a href="index.php">Trang chủ</a> <span>&#10230; </span>
            <a href=""><?php echo "Sản phẩm"?></a>
        </div>
    <div class="product-content row">
        <div class="product-content-left row">
            <div class="product-content-left-big-img">
            <?php
            if($get_img_desc){$i=0;
                foreach($get_img_desc as $get_result) {
                    if($product_id == $get_result['product_id'] and $i < 1){$i++;
            ?>
                        <img src="./admin/uploads/images_desc/<?php echo $get_result['product_img_desc'] ?>">
            <?php
                    }
                }
            }
            ?>
            </div>
            <div class="product-content-left-small-img">

            <?php
            if($get_img_desc){
                foreach($get_img_desc as $get_result) {
                    if($product_id == $get_result['product_id']){
            ?>
                        <img src="./admin/uploads/images_desc/<?php echo $get_result['product_img_desc'] ?>">
            <?php
                    }
                }
            }
            ?>
            </div>
        </div>
        <form method="POST" action="./addcart.php?id=<?php echo $product_id ?>" enctype="multipart/form-data">
            <div class="product-content-right">
                <div class="product-content-right-product-name">
                    <h1><?php $get = $product->get_product($product_id);
                        if($get){
                        $get_product = $get->fetch_assoc();
                        echo $get_product['product_name'];
                    }
                    ?></h1>
                    <p>MSP: <?php echo $product_id; ?></p>
                </div>
                <div class="product-content-right-product-price">
                    <p><?php echo number_format($get_product['product_price'],0,',','.'); ?><sup>đ</sup></p>
                </div>
                <div class="product-content-right-product-price">
                    <p>SALE: <?php echo number_format($get_product['product_sale'],0,',','.'); ?><sup>đ</sup></p>
                </div>
                <div class="quantity center">
                    <p style="font-weight: bold;">Số lượng:</p>
                    <input type="number" name="plus" min="1" value="1">
                </div>
                <div class="product-content-right-product-button">
                    <button type="submit" name="addcart"><i class="fa-solid fa-cart-shopping"></i> <p>MUA HÀNG</p></button>
                </div>
                <div class="product-content-right-product-icon">
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-solid fa-phone"><p>Hotline</p></i>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-solid fa-comment"><p>Chat</p></i>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fa-solid fa-envelope"><p>Mail</p></i>
                    </div>
                </div>
                <p style="color: red; margin:10px;">Vui lòng liên hệ nếu khách hàng có thắc mắc!</p>
                <div class="product-content-right-bottom">
                    <div class="product-content-right-bottom-top">
                        &#8744;
                    </div>
                    <div class="product-content-right-bottom-content-big">
                        <div class="product-content-right-bottom-content-title row">
                            <div class="product-content-right-bottom-content-title-item detail">
                                <p>Chi tiết</p>
                            </div>
                            <div class="product-content-right-bottom-content-title-item preserve">
                                <p>Bản quyền</p>
                            </div>
                        </div>
                        <div class="product-content-right-bottom-content">
                            <div class="product-content-right-bottom-content-detail">
                            <?php echo $get_product['product_desc']; ?> 
                            <br><br>

                            </div>
                            <div class="product-content-right-bottom-content-preserve">
                            Bản quyền của sản phẩm hoàn toàn theo quy định!    
                            <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--product-related-->
<section class="product-related container">
    <div class="product-related-title">
        <p>SẢN PHẨM LIÊN QUAN</p>
    </div>
    <div class="product-content row">
        <?php 
            $get = $product->get_product($product_id);
            if($get){
            $get_product = $get->fetch_assoc();
            $brand_id = $get_product['brand_id'];
            $get_related = $product->related_product($brand_id);
            }
            if($get_related){
                foreach($get_related as $result_related) {
            ?>
                <div class="product-related-item">
                    <div class="product-related-item-block-img">
                    <a href="product.php?id=<?php echo $result_related['product_id'] ?>"><img src="./admin/uploads/<?php echo $result_related['product_img'] ?>"></a>
                    </div>
                    <a href="product.php?id=<?php echo $result_related['product_id'] ?>"><h1><?php echo $result_related['product_name'] ?></h1></a>
                    <i><?php echo number_format($result_related['product_price'],0,',','.') ?><sup>đ</sup></i><p><?php echo number_format($result_related['product_sale'],0,',','.') ?><sup>đ</sup></p>
                </div>
            <?php
                    
                }
            }
        ?>
    </div>

</section>

<!-----------------------------app-container------------------------------->
<?php
    include("./main/app_container.php");
?>
<!-----------------------------footer------------------------------->
<?php
    include("./main/footer.php");
?>