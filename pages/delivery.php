<?php
    include("./main/header.php");
    include("../admin/config.php");
?>
<?php
    $sql = "SELECT * FROM tbl_customer WHERE customer_id = ".$_SESSION['customer_id']." ";
    $sql_s = mysqli_query($con,$sql);
    $sql_result = $sql_s->fetch_assoc();
    $inner_city = array('Hà Nội', 'Hải Phòng', 'Đà Nẵng', 'Hồ Chí Minh', 'Cần Thơ');
?>
<section class="delivery">
    <div class="container">
        <div class="delivery-top-wrap">
            <div class="delivery-top">
                <div class="delivery-top-delivery delivery-top-item">
                    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
                <div class="delivery-top-address delivery-top-item">
                    <a href="delivery.php"><i class="fa-solid fa-location-dot"></i></a>
                </div>
                <div class="delivery-top-payment delivery-top-item">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="delivery-content row">
            <div class="delivery-content-left">
                <p>Vui lòng kiểm tra lại thông tin giao hàng!</p><br>
                <p>Nếu có bất kì thông tin nào không đúng, vui lòng kiểm tra và thay đổi trong Hồ sơ!</p>
                <div class="delivery-content-left-input-top row">
                    <div class="delivery-content-left-input-top-item">
                        <label for="">Họ tên <span style="color:red">*</span></label>
                        <input readonly type="text" value="<?php echo $sql_result['customer_name']  ?>">
                    </div>
                    <div class="delivery-content-left-input-top-item">
                        <label for="">Điện thoại <span style="color:red">*</span></label>
                        <input readonly type="text" value="<?php echo $sql_result['customer_phone']  ?>">
                    </div>
                    <div class="delivery-content-left-input-top-item">
                        <label for="">Email <span style="color:red">*</span></label>
                        <input readonly type="text" value="<?php echo $sql_result['customer_email']  ?>">
                    </div>
                </div>
                <div class="delivery-content-left-input-bottom">
                    <label for="">Địa chỉ <span style="color:red">*</span></label>
                    <input readonly type="text" value="<?php echo $sql_result['customer_address'] .', '.$sql_result['customer_city']  ?>">
                </div>
                <div class="delivery-content-left-button row">
                    <a href="cart.php"><span>&#171;</span>Quay lại giỏ hàng</a>
                    <a href="payment.php"><button><p style="font-weight: bold;">THANH TOÁN VÀ GIAO HÀNG</p></button></a>
                </div>
            </div>
            <div class="delivery-content-right">
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
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
                        <td><p><?php echo $cart_item['product_name']?></p></td>
                        <td><p><?php echo number_format($cart_item['product_sale'],0,',','.')?></p></td>
                        <td><p><?php echo $cart_item['total'] ?></p></td>
                        <td><p><?php echo number_format($cart_item['total']*$cart_item['product_sale'],0,',','.') ?><sup>đ</sup></p></td>
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
                        <td style="font-weight: bold;" colspan="3">Tổng</td>
                        <td style="font-weight: bold;">
                        <p><?php echo number_format($price_all,0,',','.') ?><sup>đ</sup></p></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">Thuế VAT (10%)</td>
                        <td style="font-weight: bold;"><p><?php echo number_format($price_all/10,0,',','.') ?><sup>đ</sup></p></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">Phí Ship</td>
                        <td style="font-weight: bold;"><p>
                            <?php
                                if(in_array($sql_result['customer_city'],$inner_city)){
                                    if($price_all>=200000){
                                        $ship_fee = 0;
                                    }else{
                                        $ship_fee = 20000;
                                    }
                                }else{
                                    if($price_all>=500000){
                                        $ship_fee = 0;
                                    }else{
                                        $ship_fee = 50000;
                                    }
                                }
                                echo number_format($ship_fee,0,',','.') 
                            ?>
                            <sup>đ</sup></p></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">Tổng</td>
                        <td style="font-weight: bold;"><p>
                            <?php
                                echo number_format($ship_fee+$price_all+$price_all/10,0,',','.');
                                $_SESSION['pay_before_all'] = $price_all;
                                $_SESSION['ship_fee'] = $ship_fee;
                                $_SESSION['pay_all'] = $ship_fee+$price_all+$price_all/10;
                            ?><sup>đ</sup></p></td>
                    </tr>
                </table>
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