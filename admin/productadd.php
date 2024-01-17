<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>
<?php
$product = new product;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $insert_product = $product ->insert_product($_POST,$_FILES);
}
?>


<div class="admin-content-right">
            <div class="admin-content-right-product-add">
                <h1>Thêm Sản Phẩm</h1>
                <form id="formAdd" action="" method="POST" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm <span style="color: red;">*</span></label>
                    <input  name= "product_name" require type="text">
                    <label for="">Chọn Danh Mục <span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="#">--Chọn--</option>
                        <?php
                        $show_category = $product -> show_category();
                        if($show_category) {while($result = $show_category ->fetch_assoc()){
                        ?>
                        <option value="<?php echo $result['category_id']?>"><?php echo $result['category_name'] ?></option>
                        <?php
                        }}
                        ?>

                    </select>
                    <label for="">Chọn loại sản phẩm<span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <label for="">Chọn loại sản phẩm<span style="color: red;">*</span></label>
                        <option value="#">--Chọn--</option>

                    </select>
                    <label for="">giá sản phẩm<span style="color: red;">*</span></label>
                    <input name="product_price" require type="text">
                    <label for="">giá khuyến mãi<span style="color: red;">*</span></label>
                    <input name="product_sale" require type="text">
                    <label for="">Mô tả sản phẩm<span style="color: red;">*</span></label>
                    <textarea require name="product_desc" id="editor1" cols="30" rows="10"></textarea>
                    <label for="">Ảnh sản phẩm (Chỉ chọn 1 ảnh)<span style="color: red;">*</span></label>
                    <input name="product_img" require type="file">
                    <label for="">Ảnh mô tả (Có thể chọn nhiều ảnh khi giữ Ctrl)<span style="color: red;">*</span></label>
                    <input name="product_img_desc[]" require multiple type="file">
                    <span style="color: red;"><?php if(isset($insert_product)) {
                        echo ($insert_product);
                    } ?></span>
                    <button onclick="return myAFunction()" type="submit" name="add">Thêm</button>
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