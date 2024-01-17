<?php
    session_start();
    include "config.php";
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM tbl_admin WHERE username = $username AND  password='$password' LIMIT 1";
        $row = mysqli_query($con,$sql);
        $count = mysqli_num_rows($row);
        $result = $row->fetch_array();
        if($count>0){
            $_SESSION['login'] = $username;
            $_SESSION['admin_id'] = $result['admin_id'];
            header("location:index.php");
        }else{
            header("location:login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Adimin</title>
    <style>
        body {
            background:#f2f2f2 ;
        }

        .wrapper-login {
            width: 15%;
            margin: 0 auto;
        }

        table.table-login {
            width: 100%;
        }

        table.table-login tr td {
            padding: 5px;
        }
    </style>
</head>
<body>
<div class="wrapper-login">
    <form action="" autocomplete="off" method="POST">
        <table border="1" class="table-login" style="text-align: center; border-collapse:collapse;">
            <tr>
                <td colspan="2"><h3>Đăng nhập Adimin</h3></td>
            </tr>
            <tr>
                <td>Tài khoản</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Mật khẩu</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="login" value="Đăng Nhập"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
