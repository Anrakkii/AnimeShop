<?php
    include("./main/header.php");
    $con = mysqli_connect("localhost","root","", "demouser_animeshop");
    mysqli_set_charset($con, 'UTF8');
?>
<?php
    if(isset($_SESSION['cart'])){
        // echo '<pre>';
        // print_r($_SESSION['cart']);
        // echo '</pre>';
    }
?>

<!-----------------------------cart---------------------------------------->
<section class="cart">
    <div class="container">
    <?php
    if(isset($_SESSION['sign_up'])){
        echo 'Xin chào: '.'<span style="color: red"; margin:0 auto;>'.$_SESSION['sign_up'].'</span>';
    }
    ?>
        <div class="cart-top-wrap">
            <div class="cart-top">
                <div class="cart-top-cart cart-top-item">
                    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
                <div class="cart-top-address cart-top-item">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="cart-top-payment cart-top-item">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="cart-content row">
            <div class="cart-content-left">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Giá</th>
                        <th>SL</th>
                        <th>Thành phẩm</th>
                        <th>Xóa</th>
                    </tr>
                    <?php
                    if(isset($_SESSION['cart'])){
                        $x = 0;
                        $price_all = 0;
                        $total_all = 0;
                        foreach($_SESSION['cart'] as $cart_item){
                            $price_total = $cart_item['total']*$cart_item['product_sale'];
                            $price_all = $price_all + $price_total;
                            $total_all = $total_all + $cart_item['total'];
                        
                    ?>
                    <tr>
                        <td><img src="./admin/uploads/<?php echo $cart_item['product_img']?>"></td>
                        <td><p><?php echo $cart_item['product_name']?></p></td>
                        <td><p><?php echo $cart_item['brand_name']?></p></td>
                        <td><p><?php echo number_format($cart_item['product_sale'],0,',','.')?></p></td>
                        <td>
                            <a href="./addcart.php?add=<?php echo $cart_item['product_id'] ?>"><i class="fa-solid fa-circle-plus"></i></a>
                            <?php echo $cart_item['total'] ?>
                            <a href="./addcart.php?sub=<?php echo $cart_item['product_id'] ?>"><i class="fa-solid fa-circle-minus"></i></a>
                        </td>
                        <td><p><?php echo number_format($price_total,0,',','.') ?><sup>đ</sup></p></td>
                        <td><button><a href="./addcart.php?delete=<?php echo $cart_item['product_id'] ?>">X</a></button></td>
                    </tr>
                    <?php
                        }
                    }else{
                        $price_all = 0;
                        $total_all = 0;
                    ?>
                    <tr>
                        <td colspan="7"><p>Hiện tại giỏ hàng trống!</p></td>
                    </tr>
                    <?php
                        $x = 1;
                    }
                    ?>
                    <tr>
                        <td colspan="7"><p style="float: right;">
                        <button><a href="./addcart.php?delete_all=1">Xóa tất cả!</a></button></p></td>
                    </tr>
                </table>
            </div>
            <div class="cart-content-right">
                <table>
                    <tr>
                        <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                    </tr>
                    <tr>
                        <td>TỔNG SẢN PHẨM</td>
                        <td><?php echo $total_all?></td>
                    </tr>
                    <tr>
                        <td>TÔNG TIỀN HÀNG</td>
                        <td><p><?php echo number_format($price_all,0,',','.') ?><sup>đ</sup></p></td>
                    </tr>
                    <tr>
                        <td style="color: black; font-weight: bold;">TẠM TÍNH</td>
                        <td><p style="color: black; font-weight: bold;"><?php echo number_format($price_all,0,',','.') ?><sup>đ</sup></p></td>
                    </tr>
                </table>
                <div class="cart-content-right-text">
                    <p>Miễn phí ship nội thành nếu đơn hàng của bạn lớn hơn 200.000 đ <br>
                        Miễn phí ship ngoại thành nếu đơn hàng của bạn lớn hơn 500.000 đ
                    </p>
                    <?php 
                    if($price_all<200000){
                    ?>
                    <p style="color: red; font-weight: bold;">Mua thêm <span style="font-size: 18px;"><?php echo number_format(200000-$price_all,0,',','.') ?> đ</span> để được miễn phí ship nội thành!</p>
                    <?php
                    }
                    ?>
                    <?php 
                    if($price_all>=200000 && $price_all<500000){
                    ?>
                    <p style="color: red; font-weight: bold;">Mua thêm <span style="font-size: 18px;"><?php echo number_format(500000-$price_all,0,',','.') ?> đ</span> để được miễn phí ship ngoại thành!</p>
                    <?php
                    }
                    ?>
                </div>
                <?php
                    if($x==0){
                        if(isset($_SESSION['sign_up'])){
                ?>
                        <div class="cart-content-right-button">
                            <a href="delivery.php"><button>ĐẶT HÀNG</button></a>
                            <a href="index.php"><button>TIẾP TỤC MUA SẮM</button></a>
                        </div>
                <?php
                        }else{
                ?>
                        <div class="cart-content-right-button">
                            <a href="sign_up.php"><button>ĐĂNG KÝ ĐỂ ĐẶT HÀNG</button></a>
                            <a href="index.php"><button>TIẾP TỤC MUA SẮM</button></a>
                        </div>
                <?php
                         }
                    }else{
                ?>
                    <div class="cart-content-right-button">
                    <a href="index.php"><button>ĐI MUA SẮM</button></a>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
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