<?php
    include("./main/header.php");
    $con = mysqli_connect("localhost","demouser_animeshop","animeshop", "demouser_animeshop");
?>
<?php
if(isset($_POST['pay'])){
    $customer_id = $_SESSION['customer_id'];
    $code_order = rand(0,99999);
    $paid = $_POST['paid'];
    $cart_pay_temp = $_SESSION['pay_before_all'];
    $cart_pay_all = $_SESSION['pay_all'];
    $cart_ship_fee = $_SESSION['ship_fee'];
    $insert_cart = "INSERT INTO tbl_cart(customer_id,cart_code,cart_status,cart_pay_temp,cart_ship_fee,cart_pay_all) 
    VALUES('$customer_id','$code_order',1,'$cart_pay_temp','$cart_ship_fee','$cart_pay_all')";
    $cart_query = mysqli_query($con, $insert_cart);
    if($cart_query){
        foreach($_SESSION['cart'] as $key => $value){
            $product_id = $value['product_id'];
            $quantity = $value['total'];
            $insert_order_details =  "INSERT INTO tbl_cart_details(product_id,cart_code,quantity,paid) 
            VALUES('$product_id','$code_order','$quantity','$paid')";
            mysqli_query($con,$insert_order_details);
        }
    }
    unset($_SESSION['cart']);
    header('location:thankyou.php');
}
?>
<!-----------------------------payment---------------------------------------->
<section class="payment">
    <div class="container">
        <div class="payment-top-wrap">
            <div class="payment-top">
                <div class="payment-top-delivery payment-top-item">
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
                <div class="payment-top-address payment-top-item">
                <a href="delivery.php"><i class="fa-solid fa-location-dot"></i></a>
                </div>
                <div class="payment-top-payment payment-top-item">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
            </div>
        </div>
    </div>
<form action="" method="POST">
    <div class="container">
        <div class="payment-content row">
            <div class="payment-content-left">
                <div class="payment-content-left-method-payment">
                    <p style="font-weight: bold;">Phương thức thanh toán</p>
                    <p>Mọi giao dịch đều được bảo mật hóa. Thông tin thẻ tín dụng sẽ không được ghi lại</p>
                    <div class="payment-content-left-method-payment-item row">
                        <input checked name="paid" value="1" type="radio">
                        <label for=""> Thanh toán thẻ tín dụng</label>
                    </div>
                    <div class="payment-content-left-method-payment-item row">
                        <input checked name="paid" value="1" type="radio">
                        <label for=""> Thanh toán thẻ ATM</label>
                    </div>
                    <div class="payment-content-left-method-payment-item row">
                        <input checked name="paid" value="1" type="radio">
                        <label for=""> Thanh toán Ví điện tử</label>
                    </div>
                    <div class="payment-content-left-method-payment-item row">
                        <input checked name="paid" value="0" type="radio">
                        <label for=""> Thu tiền tận nơi</label>
                    </div>
                </div>

            </div>
            <div class="payment-content-right">
                <div class="payment-content-right-button">
                    <p>Giá hoàn tất thanh toán:</p>
                </div>
                <div class="payment-content-right-button">
                    <input readonly type="text" placeholder="<?php echo number_format($_SESSION['pay_all'],0,',','.').'đ' ?>">
                </div>
            </div>
        </div>
        <div class="payment-content-right-payment">
            <button type="submit" name="pay" value="Thanh toán">HOẢN TẤT THANH TOÁN</button>
        </div>
    </div>
</form>
</section>
<!-----------------------------app-container------------------------------->
<?php
    include("./main/app_container.php");
?>
<!-----------------------------footer------------------------------->
<?php
    include("./main/footer.php");
?>