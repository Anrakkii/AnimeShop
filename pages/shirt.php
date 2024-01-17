<?php
    include("./main/header.php");
    $con = mysqli_connect("localhost","root","","webbanhang_demo");
?>
<?php
    $sql_product = "SELECT * FROM tbl_product_img_desc 
    JOIN tbl_product 
    ON tbl_product_img_desc.product_id = tbl_product.product_id 
    JOIN tbl_category 
    ON tbl_product.category_id = tbl_category.category_id 
    WHERE tbl_product.category_id=tbl_category.category_id 
    AND tbl_category.category_php_name='$string_name' 
    ORDER BY tbl_product.product_id DESC";
    $query_product = mysqli_query($con,$sql_product);
    $query_link = mysqli_query($con,$sql_link);
    $link_result = mysqli_fetch_array($query_link);
?>
<!-----------------------------category------------------------------->
<section class="category">
    <div class="container">
        <div class="category-top row">
            <a href="index.php">Trang chủ</a> <span>&#10230; </span>
            <a href="<?php echo $string_name?>.php"><?php echo $link_result['category_name']?></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="category-left">
                <ul>
                    <div class="category-left-li">
                        <h3>Price</h3>
                        <input type="hidden" id="hidden_minimum_price" value="0"/>
                        <input type="hidden" id="hidden_maximum_price" value="65000"/>
                        <p id="price_show">1 - 65000</p>
                        <div id="price_range"></div>
                        
                    </div>
                    <li class="category-left-li">
                        <h3>Brand</h3>
                        <?php
                        $query = "SELECT DISTINCT(brand_name) FROM tbl_brand
                            ORDER BY brand_id DESC";
                        $statement = $con->prepare($query);
                        $statement->execute();
                        $brand_result = $statement->get_result();
                        $brand_data = $brand_result->fetch_all(MYSQLI_ASSOC);
                        foreach($brand_result as $brand_row)
                        {
                        ?>
                        <div class="list-group-item checkbox">
                            <label><input type="checkbox" class="common_selector brand_name" 
                            value="<?php echo $brand_row['brand_name']; ?>">
                            <?php echo $brand_row['brand_name']; ?>
                            </label>
                        </div>
                        <?php
                        }
                        ?>
                    </li>
                    <li class=""></li>
                    <li class=""></li>
                </ul>
            </div>
            <div class="category-right row">
                <div class="category-right-top-item">
                    <p>HÀNG SẮP VỀ</p>
                </div>
                <div class="category-right-content row">

                </div>

            </div>
        </div>
    </div>
</section>
<style>
#loading
{
 text-align:center; 
 background: url('../assets/images/Visa.webp') no-repeat center; 
 height: 150px;
}
</style>
<script>
var url=location.href;
var urlFilename = url.substring(url.lastIndexOf('/')+1);

$(document).ready(function(){

filter_data();

function filter_data()
{
    $('.category-right-content').html('<div id="loading" style="" ></div>');
    var action = 'fetch_data';
    var minimum_price = $('#hidden_minimum_price').val();
    var maximum_price = $('#hidden_maximum_price').val();
    var brand_name = get_filter('brand_name');
    var url=location.href;
    var urlFilename = url.substring(url.lastIndexOf('/')+1);
    $.ajax({
        url:"fetch_data.php",
        method:"POST",
        data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand_name:brand_name, urlFilename:urlFilename},
        success:function(data){
            $('.category-right-content').html(data);
        }
    });
}

function get_filter(class_name)
{
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}

$('.common_selector').click(function(){
    filter_data();
});

$('#price_range').slider({
    range:true,
    min:1000,
    max:65000,
    values:[1000, 65000],
    step:500,
    stop:function(event, ui)
    {
        $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
        $('#hidden_minimum_price').val(ui.values[0]);
        $('#hidden_maximum_price').val(ui.values[1]);
        filter_data();
    }
});

});
</script>
<!-----------------------------app-container------------------------------->
<?php
    include("./main/app_container.php");
?>
<!-----------------------------footer------------------------------->
<?php
    include("./main/footer.php");
?>