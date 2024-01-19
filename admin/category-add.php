<?php
include "./header.php";
include "./slider.php";
include "./class/category-class.php";
?>
<?php
$category = new category;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $category_name = $_POST['category_name'];
    $category_php_name = $_POST['category_php_name'];
    $insert_category = $category ->insert_category($category_name, $category_php_name);
}


?>

<div class="admin-content-right">
            <div class="admin-content-right-cartegoty-add">
                <h1>Thêm danh mục (Ví dụ: A)</h1>
                <form action="" method="POST">
                    <input required name="category_name" type="text" placeholder="Nhập tên danh mục">
                    <h1>Tên file (viết liền không dấu, file php sẽ được tạo)</h1>
                    <input required name="category_php_name" type="text" placeholder="Nhập tên file muốn tạo danh mục">
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>