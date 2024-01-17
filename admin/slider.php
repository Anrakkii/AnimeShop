<?php
    $string = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if($string != 'index.php'){
        session_start();
    }
    if (!isset($_SESSION['login']))
    {
        header("Location: login.php");
    }
    if(isset($_GET['logout'])=='logout' && $_GET['logout']==1){
        unset($_SESSION['login']);
        header('location:login.php');
    }
?>
<section class="admin-content">
        <div class="admin-content-left">
            <ul>
                <li><a href="#">Danh mục</a>
                    <ul>
                        <li><a href="category-add.php">Thêm danh mục</a></li>
                        <li><a href="categorylist.php">Danh sách danh mục</a></li>
                    </ul>
                </li>
                <li><a href="#">Loại sản phẩm</a>
                    <ul>
                        <li><a href="brandadd.php">Thêm loại sản phẩm</a></li>
                        <li><a href="brandlist.php">Danh sách loại sản phẩm</a></li>
                    </ul>
                </li>
                <li><a href="#">Danh sách sản phẩm</a>
                    <ul>
                        <li><a href="productadd.php">Thêm sản phẩm</a></li>
                        <li><a href="productlist.php">Danh sách sản phẩm</a></li>
                    </ul>
                </li>
                <li><a href="orders_manager.php">Quản lí đơn hàng</a>
                </li>
                <li><a href="index.php">Admin</a></li>
                <li><a href="<?php echo $string ?>?logout=1">Đăng xuất : <?php if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                } ?></a></li>
            </ul>
        </div>