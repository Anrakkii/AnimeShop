<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>
<?php
$product = new product;
$show_product = $product->show_product();
$get_img_desc = $product->show_img_desc();


?>

<div class="admin-content-right">
<div class="admin-content-right-cartegoty-list">
                <h1>Danh sách loại sản phẩm</h1>
                <table>
                    <tr>
                        <th>STT&ensp;</th>
                        <th>ID sản phẩm&ensp;</th>
                        <th>Tên danh mục&ensp;</th>
                        <th>Tên loại sản phẩm&ensp;</th>
                        <th>Tên sản phẩm&ensp;</th>
                        <th>Giá gốc sản phẩm&ensp;</th>
                        <th>Giá sau khi giảm&ensp;</th>
                        <th>Mô tả sản phẩm&ensp;</th>
                        <th>Hình sản phẩm&ensp;</th>
                        <th>Hình mô tả&ensp;</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if($show_product){$i = 0;
                        while($result = $show_product->fetch_assoc()) {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['product_id']?> </td>
                        <td><?php echo $result['category_name']?></td>
                        <td><?php echo $result['brand_name']?></td>
                        <td><?php echo $result['product_name']?></td>
                        <td><?php echo $result['product_price']?></td>
                        <td><?php echo $result['product_sale']?></td>
                        <td><?php echo $result['product_desc']?></td>
                        <td><img src="../admin/uploads/<?php echo $result['product_img'] ?>" alt="Image" style="width:100px; height: 100px;"></td>
                        <td>
                        <?php if($get_img_desc){$j = 0;
                                while($get_result = $get_img_desc->fetch_assoc()) {$j++;
                                if($get_result['product_id'] == $result['product_id']){
                                
                        ?>
                                <img src="../admin/uploads/images_desc/<?php echo $get_result['product_img_desc'] ?>" alt="Image" style="width:100px; height: 100px;"><br>
                        <?php
                                }
                            }   
                        }
                        ?>
                        </td>
                        <td><a href="productedit.php?product_id=<?php echo $result['product_id']?>">Sửa</a>|<a class="delete" href="productdelete.php?product_id=<?php echo $result['product_id']?>" onclick="return checkDelete()">Xóa<a href=""></a></a></td>
                    </tr>
                    <?php
                        $get_img_desc->data_seek(0);
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
</body>
<script src="./admin_style.js"></script>
</html>