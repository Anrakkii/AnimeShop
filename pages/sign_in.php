<?php
    include("./main/header.php");
    include("../admin/config.php");
?>
<?php
if(isset($_SESSION['sign_in'])){
    header('location:index.php');
}else{
    if(isset($_POST['sign_in'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM tbl_customer WHERE customer_email='$email' AND customer_password = '$password' LIMIT 1";
        $row = mysqli_query($con,$sql);
        $count = mysqli_num_rows($row);

        if($count>0){
            $row_data = mysqli_fetch_array($row);
            $_SESSION['sign_up'] = $row_data['customer_name'];
            $_SESSION['sign_in'] = $row_data['customer_name'];
            $_SESSION['customer_id'] = $row_data['customer_id'];
            header("location:index.php");
        }else{
            echo '<p style="color:red">Mật khẩu hoặc email sai, vui lòng nhập lại!</p>';
        }
    }
    
}
?>

<style>
    table.sign_in{
        padding:200px 5% 5%; margin:0 auto;
    }

    table.sign_in tr td {
        padding:5px;
    }
</style>

<form action="" autocomplete="off" method="POST">
    <table class="sign_in">
        <tr>
            <td colspan="2"><h3>Đăng nhập Anime Shop</h3></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="email" placeholder="Email..."></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="password" placeholder="Mật khẩu..."></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="sign_in" value="Đăng Nhập"></td>
        </tr>
        <tr>
            <td colspan="2"><h4> <a style="color:blue;" href="sign_up.php">Đăng ký nếu chưa có tài khoản</a></h2></td>
        </tr>
    </table>
</form>
<!-----------------------------app-container------------------------------->
<?php
    include("./main/app_container.php");
?>
<!-----------------------------footer------------------------------->
<?php
    include("./main/footer.php");
?>