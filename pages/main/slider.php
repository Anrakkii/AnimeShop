<?php
    $sql_menu = "SELECT * FROM tbl_product ORDER BY RAND() LIMIT 4";
    $con = mysqli_connect("localhost","root","","webbanhang_demo");
    $query_menu = mysqli_query($con,$sql_menu);
?>

<section id="Slider">
        <div class="aspect-ratio-169">
        <?php
            while($row_menu = mysqli_fetch_array($query_menu)){
        ?>

            <img src="<?php echo $row_menu['product_img']?>">
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