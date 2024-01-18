<?php
    $sql_menu = "SELECT * FROM tbl_category ORDER BY category_id DESC";
    $con = mysqli_connect("localhost","root","","demouser_animeshop");
    $query_menu = mysqli_query($con,$sql_menu);
    $string_temp = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    $string_name = str_replace(".php","",$string_temp);
    $sql_link = "SELECT category_name FROM tbl_category WHERE tbl_category.category_php_name='$string_name'";
    $query_link = mysqli_query($con,$sql_link);
?>

<?php
    session_start();
    if(isset($_GET['log_out']) && $_GET['log_out']==1){
        unset($_SESSION['sign_up']);
    }
    // session_start();

    // $helper = array_keys($_SESSION);
    // foreach ($helper as $key){
    //     unset($_SESSION[$key]);
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://kit.fontawesome.com/00e90bdb6c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Project</title>
</head>
<body>
<header>
        <div class="logo">
            <a href="./index.php"><img src="./assets/images/logo.jpg"></a>
        </div>
        <div class="menu">
            <?php
                while($row_menu = mysqli_fetch_array($query_menu)){
            ?>
            <li><a href="<?php echo $row_menu['category_php_name']?>.php"><?php echo mb_strtoupper($row_menu['category_name'])?></a></li>
            <?php
                }
            ?>
            <?php
            if(isset($_SESSION['sign_up'])){

            ?>
            <li><a href="index.php?log_out=1">ĐĂNG XUẤT</a></a></li>
            <?php
            }else{

            ?>
            <li><a href="sign_in.php">ĐĂNG NHẬP</a></a></li>
            <?php
            }
            ?>
            <a href="#" id="icon" class="icon" onclick="openSlideMenu()">
                <i class="fa-solid fa-bars fa-lg"></i>
            </a>
        </div>

        <div class="others">
            <li class="search-box">
                <form action="search.php" method="POST">
                    <input class="search-txt" placeholder="Tìm kiếm" type="text" name="key_word">
                    <a class="btn">
                        <button type="submit" name="search"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
                    </a>
                </form>
            </li>
            <li>
                <a href="profile.php">
                    <i class="fa-solid fa-user fa-lg" href=""></i>
                </a>
            </li>
            <li>
                <a href="cart.php">
                    <i class="fa-solid fa-bag-shopping fa-lg" href=""></i>
                </a>
            </li>
        </div>
    </header>
    <div id="side-menu" class="side-nav">
        <a href="" class="close" onclick="closeSlideMenu()">
            <i class="fa-solid fa-bars fa-lg"></i>
        </a>
        <form action="search.php">
            <input class="search-side" placeholder="Tìm kiếm" type="text" name="key_word">
            <a class="btn" href="">
                <button type="submit" name="search"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
            </a>
        </form>
        <?php
        if(isset($_SESSION['sign_up'])){

        ?>
        <a href="index.php?log_out=1">ĐĂNG XUẤT</a>
        <?php
        }else{

        ?>
        <a href="sign_up.php">ĐĂNG NHẬP</a>
        <?php
        }
        ?>
        <a href="pre_order.php">ĐẶT TRƯỚC</a>
        <a href="figure.php">FIGURE</a>
        <a href="wall_scroll.php">WALLSCROLL</a>
        <a href="plush.php">PLUSH</a>
        <a href="shirt.php">ÁO PHÔNG</a>
        <a href="poster.php">POSTER</a>
    </div>