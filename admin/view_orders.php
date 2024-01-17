<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>

<?php
    $sql_order = "SELECT * FROM tbl_cart_details
    JOIN tbl_product
    ON tbl_cart_details.product_id = tbl_product.product_id
    WHERE tbl_cart_details.cart_code = '$_GET[code]'
    ORDER BY tbl_cart_details.cart_details_id DESC";
    $query_orders_list = mysqli_query($con,$sql_order);
?>

<table style="width:100%" border="1" style="border-collapse: collapse;">
    <tr>
        <th>Mã đơn hàng</th>
        <th>Tên sản phẩm</th>
        <th>Giá sản phẩm</th>
        <th>Số lượng</th>
        <th>Tổng giá sản phẩm</th>
        <th>Tình trạng</th>
    </tr>
    <?php
    while($row = mysqli_fetch_array($query_orders_list)){
    ?>
    <tr>
        <td><?php echo $row['cart_code'] ?></td>
        <td><?php echo $row['product_name'] ?></td>
        <td><?php echo $row['product_price'] ?></td>
        <td><?php echo $row['quantity'] ?></td>
        <td><?php echo $row['product_price']*$row['quantity']?></td>
        <td>
            <?php
            if($row['paid']==1){
                echo "Đã thanh toán online";
            }else{
                echo "Thu tiền mặt khi giao";
            }
            ?>
        </td>
    </tr>
    <?php
        }
    ?>
</table>