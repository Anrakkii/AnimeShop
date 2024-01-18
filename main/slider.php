<?php
    $sql_menu = "SELECT * FROM tbl_product ORDER BY RAND() LIMIT 4";
    $con = mysqli_connect("localhost","root","","demouser_animeshop");
    $query_menu = mysqli_query($con,$sql_menu);
?>

<section id="Slider">
        <div class="aspect-ratio-169">
        <?php
            while($row_menu = mysqli_fetch_array($query_menu)){
        ?>

            <a href="product.php?id=<?php echo $row_menu['product_id']?>"><img src="<?php echo './admin/uploads/'.$row_menu['product_img']?>"></a>
        <?php
            }
        ?>
        </div>
        <div class="dot-container">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </section>