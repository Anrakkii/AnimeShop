<?php
    include("./main/header.php");
    include("./admin/config.php");
?>
<style>
    .thankyou{
        padding:200px 5% 5%; margin:0 auto;
        text-align: center;
    }

    .thankyou img{
        display: block;
        width: 50%;
        height: 50%;
        margin: auto;
    }

    .thankyou a{
        display: block;
        margin: -150px 0 0 0;
        color: blue;
        font-size: 20px;
    }
</style>

<div class="thankyou">
    <img src="./assets/images/thankyou.gif">
</div>

<div class="thankyou">
    <a href="index.php">Quay về trang chủ</a>
</div>
<!-----------------------------app-container------------------------------->
<?php
    include("./main/app_container.php");
?>
<!-----------------------------footer------------------------------->
<?php
    include("./main/footer.php");
?>