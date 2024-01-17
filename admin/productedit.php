<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>
<?php
$product = new product;
$product_id = $_GET['product_id'];
$get_product = $product->get_product($product_id);
if($get_product){
    $get_result = $get_product->fetch_assoc();
}
$get_product_img_desc = $product->get_product_img_desc($product_id);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_sale = $_POST['product_sale'];
    $product_desc = $_POST['product_desc'];
    $old_img =  $_POST['old_img'];
    $old_img_desc = $_POST['old_img_desc'];
    $brand_id = $_POST['brand_id'];
    $product_img = $_FILES['product_img']['name'];
    $product_img_desc = $_FILES['product_img_desc']['name'];    
    $update_product = $product ->update_product($category_id,$product_name,$product_price,$product_sale,$product_desc,$old_img,$product_img,$product_img_desc,$brand_id,$product_id);
}


?>

<div class="admin-content-right">
            <div class="admin-content-right-product-add">
                <h1>Thêm Sản Phẩm</h1>
                <form id="formUpdate" action="" method="POST" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm <span style="color: red;">*</span></label>
                    <input  name= "product_name" value="<?php echo $get_result['product_name'] ?>" require type="text">
                    <label for="">Chọn Danh Mục <span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="#">--Chọn--</option>
                        <?php
                        $show_category = $product->show_category();
                        if($show_category){while($result = $show_category -> fetch_assoc()){
                        ?>

                        <option <?php if($get_result['category_id']==$result['category_id']) {echo "SELECTED";} ?>
                        value="<?php echo $result['category_id'] ?>"><?php echo $result['category_name'] ?></option>
                        <?php
                        }}
                        ?>

                    </select>
                    <label for="">Chọn loại sản phẩm<span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <label for="">Chọn loại sản phẩm<span style="color: red;">*</span></label>
                        <option value="#">--Chọn--</option>
                        <?php
                        $show_brand = $product->get_brand($product_id);
                        if($show_brand){while($result = $show_brand -> fetch_assoc()){
                        ?>

                        <option <?php if($get_result['brand_id']==$result['brand_id']) {echo "SELECTED";} ?>
                        value="<?php echo $result['brand_id'] ?>"><?php echo $result['brand_name'] ?></option>
                        <?php
                        }}
                        ?>
                    </select>
                    <label for="">giá sản phẩm<span style="color: red;">*</span></label>
                    <input name="product_price" value="<?php echo $get_result['product_price'] ?>" require type="text">
                    <label for="">giá khuyến mãi<span style="color: red;">*</span></label>
                    <input name="product_sale" value="<?php echo $get_result['product_sale'] ?>" require type="text">
                    <label for="">Mô tả sản phẩm<span style="color: red;">*</span></label>
                    <textarea require name="product_desc" id="editor1" cols="30" rows="10"><?php echo $get_result['product_desc'] ?></textarea>
                    <label for="">Ảnh sản phẩm<span style="color: red;">*</span></label>
                    <span style="color: red;">
                    <?php 
                    if(isset($insert_product)) {
                        echo ($insert_product);
                    } 
                    if(isset($update_product)) {
                        echo ($update_product);
                    }
                    ?></span>
                    <input name="product_img" require type="file">
                    <input name="old_img" type="hidden" value="<?php echo $get_result['product_img'] ?>">
                    <img src="<?php echo "uploads/".$get_result['product_img'] ?>" width="100px"><br>
                    <label for="">Ảnh mô tả<span style="color: red;">*</span></label>
                    <input name="product_img_desc[]" require multiple type="file">
                    <input name="old_img_desc[]" type="hidden" value="
                    <?php if($get_product_img_desc){$j = 0;
                            while($get_result_img_desc = $get_product_img_desc->fetch_assoc()) {$j++;
                            if($get_result_img_desc['product_id'] == $get_result['product_id']){
                                // echo $get_result_img_desc['product_img_desc']
                            
                    ?>">
                            <img src="../admin/uploads/images_desc/<?php echo $get_result_img_desc['product_img_desc'] ?>" style="width:100px; height: 100px;"><br>
                    <?php
                            }
                        }   
                    }
                    ?>
                    <button onclick="return myUFunction()" name="add" type="submit">Cập nhật</button>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
CKEDITOR.replace( 'editor1', {
    filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
    filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'})
                </script>


<script>
    $(document).ready(function(){
        $("#category_id").change(function(){
            // alert($(this).val())
            var x = $(this).val()
            $.get("test_productadd_ajax.php",{category_id:x},function(data){
                $("#brand_id").html(data);
            })
        })
    })
</script>
<script src="./admin_style.js"></script>
</html>