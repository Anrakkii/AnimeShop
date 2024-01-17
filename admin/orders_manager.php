<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>

<?php
    $sql_order = "SELECT * FROM tbl_cart
    JOIN tbl_customer
    ON tbl_cart.customer_id = tbl_customer.customer_id
    ORDER BY tbl_cart.cart_id DESC";
    $query_orders_list = mysqli_query($con,$sql_order);
?>

<table style="width:100%" border="1" style="border-collapse: collapse;">
    <tr>
        <th>Mã đơn hàng</th>
        <th>Tên khách hàng</th>
        <th>Địa chỉ</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Tổng giá sản phẩm</th>
        <th>Phí ship</th>
        <th>Tổng thanh toán</th>
        <th>Tình trạng</th>
        <th>Quản lý</th>
    </tr>
    <?php
    while($row = mysqli_fetch_array($query_orders_list)){
    ?>
    <tr>
        <td><?php echo $row['cart_code'] ?></td>
        <td><?php echo $row['customer_name'] ?></td>
        <td><?php echo $row['customer_address'] ?></td>
        <td><?php echo $row['customer_email'] ?></td>
        <td><?php echo $row['customer_phone'] ?></td>
        <td><?php echo $row['cart_pay_temp'] ?></td>
        <td><?php echo $row['cart_ship_fee'] ?></td>
        <td><?php echo $row['cart_pay_all'] ?> (Đã tính VAT 10%)</td>
        <td>
            <?php
                if($row['cart_status']==1){
                    echo '<a style="color:blue" href="orders_status.php?status=2&cart_code='.$row['cart_code'].'">Đơn hàng mới</a>';
                }elseif($row['cart_status']==2){
                    echo '<a style="color:blue" href="orders_status.php?status=3&cart_code='.$row['cart_code'].'">Đang xử lý</a>';
                }else{
                    echo "Hoàn thảnh";
                }
            ?>
        </td>
        <td>
            <a style="color:blue" href="view_orders.php?code=<?php echo $row['cart_code'] ?> ">Xem đơn hàng</a>
        </td>
    </tr>
    <?php
        }
    ?>
</table>