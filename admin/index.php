<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header('location:login.php');
    }
?>

<?php
include "./header.php";
include "./slider.php";
include "./class/product-class.php";
?>

<?php
    if(isset($_GET['password_change']) and $_GET['password_change']==1){
        $alert=null;
        $admin_id = $_SESSION['admin_id'];
        $admin_query = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
        $admin_link = mysqli_query($con, $admin_query);
        $admin_result = $admin_link->fetch_array();
        if(isset($_POST['change'])){
            if($_POST['password'] == ""){
                $alert="Mật khẩu không được để trống!";
            }else{
                if($_POST['re_password'] != $_POST['password']){
                    $alert="Mật khẩu nhập lại không chính xác!";
                }
                $new_password = $_POST['password'];
                $change_query = "UPDATE tbl_admin SET tbl_admin.password = '$new_password'
                WHERE admin_id = '$admin_id'";
                $change_query_link = mysqli_query($con, $change_query);
                header('location:index.php');
            }
        }
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegoty-list">
    <form action="" autocomplete="off" method="POST">
        <table border="1" class="table-login" style="text-align: center; border-collapse:collapse;">
            <tr>
                <td colspan="2"><h3>Đổi mật khẩu Adimin</h3></td>
            </tr>
            <tr>
                <td>Tên tài khoản</td>
                <td><input readonly type="text" name="username" value="<?php echo $admin_result['username'] ?>"></td>
            </tr>
            <tr>
                <td>Mật khẩu mới</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Nhập lại mật khẩu</td>
                <td><input type="password" name="re_password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="change" value="Đăng Nhập"></td>
            </tr>
        </table>
        <h2 style="color:red"><?php echo $alert ?></h2>
    </form>
    </div>
</div>
<?php
    }else{
?>
<div class="admin-content-right">
    <div class="admin-content-right-cartegoty-list">
        <h1>Xin chào Amin: <?php echo $_SESSION['login'] ?></h1>
        <br>
        <a href="index.php?password_change=1"><h2 style="color:blue">Đổi mật khẩu</h2></a>
    </div>
</div>

<?php
    } 
?>
</div>
    </section>
</body>