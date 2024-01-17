<?php
    include("./main/header.php");
    include("../admin/config.php");
?>

<?php
    $sql = "SELECT * FROM tbl_province";
    $result = mysqli_query($con,$sql);
?>

<?php
    $alert = null;
    if(isset($_POST['sign_up'])){
        if($_POST['re_password']==""){
            $alert = "Xin vui lòng nhập lại mật khẩu!";
        }else{
            if($_POST['password']!=$_POST['re_password']){
                $alert = "Mật khẩu không giống nhau! Xin vui lòng nhập lại!";
            }
        }
        if($_POST['password']==""){
            $alert = "Xin vui lòng nhập mật khẩu!";
        }else{
            $customer_password = $_POST['password'];
        }
        if($_POST['province']==""){
            $alert ="Xin vui lòng chọn thành phố!";
        }else{
            if($_POST['district']=="" && $_POST['district']=='Chọn một Quận/huyện'){
                $alert ="Xin vui lòng chọn Quận/Huyện!";
            }else{
                if(!isset($_POST['wards']) OR $_POST['wards']=="" && $_POST['wards']=='Chọn một xã/phường'){
                    $alert = "Xin vui lòng chọn Phường/Xã!";
                }else{
                    if($_POST['address']==""){
                        $alert = "Xin vui lòng nhập số nhà, tên đường!";
                    }else{
                        $customer_city = $_POST['province'];
                        $customer_address = $_POST['address'].", ".$_POST['wards'].", ".$_POST['district'];
                    }
                }
            }
        }
        if($_POST['phone']==""){
            $alert = "Xin vui lòng nhập số điện thoại!";
        }else{
            $customer_phone = $_POST['phone'];
        }
        if($_POST['email']==""){
            $alert = "Vui lòng nhập email!";
        }else{
            $e = "SELECT * FROM tbl_customer";
            $e_sql = mysqli_query($con,$e);
            $e_result = $e_sql->fetch_assoc();
            if($_POST['email']==$e_result['customer_email']){
                $alert = "email đã tồn tại! Xin vui lòng nhập email khác!";
            }else{
                $customer_email = $_POST['email'];
            }
        }
        if($_POST['name']==""){
            $alert = "Vui lòng nhập tên!";
        }else{
            $customer_name = $_POST['name'];
        }
        if($alert==null){
            $sql = "INSERT INTO tbl_customer(customer_name,
            customer_email,customer_address,customer_password,customer_phone,customer_city) 
            VALUES('$customer_name','$customer_email','$customer_address','$customer_password','$customer_phone','$customer_city')";
            $sql_sign_up = mysqli_query($con,$sql);
            if($sql_sign_up){
                echo '<p style="color:green; padding:200px 5% 5%; margin:0 auto;">Bạn đã đăng ký thành công!</p>';
                $_SESSION['sign_up'] = $customer_name;

                $_SESSION['customer_id'] = mysqli_insert_id($con);
                header('Location:cart.php');
            }
        }
    }
?>

<style>
    table.sign_up{
        padding:200px 5% 5%; margin:0 auto;
    }

    table.sign_up tr td {
        padding:5px;
    }
</style>
<form action="" method="POST">
    <table class="sign_up">
        <tr>
            <td>Họ và tên</td>
            <td><input type="text" size="50" name="name"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" size="50" name="email"></td>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <td><input type="text" size="50" name="phone"></td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="province">Tỉnh/Thành phố</label>
                </div>
            </td>
            <td>
            <select id="province" name="province" class="form_control">
                        <option value="">Chọn một tỉnh</option>
                        <?php
                        while($rows = $result->fetch_assoc()){
                        ?>
                            <option value="<?php echo $rows['province_name'] ?>"><?php echo $rows['province_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="district">Quận/Huyện</label>
                </div>
            </td>
            <td>
            <select id="district" name="district" class="form-control">
                        <option value="">Chọn một quận/huyện</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="wards">Phường/Xã</label>
                </div>
            </td>
            <td>
            <select id="wards" name="wards" class="form-control">
                        <option value="">Chọn một xã</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Số nhà - Đường</td>
            <td><input type="text" size="50" name="address"></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="text" size="50" name="password"></td>
        </tr>
        <tr>
            <td>Nhập lại mật khẩu</td>
            <td><input type="text" size="50" name="re_password"></td>
        </tr>
        <tr>
            <td><input type="submit" name="sign_up" value="Đăng ký"></td>
            <td><a style="color:blue" href="sign_in.php">Đăng nhập nếu có tài khoản</a></td>
        </tr>
        <tr>
            <td style="color:red">
            <?php 
                if($alert!=null)
                {echo $alert;
                }
            ?>
        </tr>
    </table>
</form>

<script>
    $(document).ready(function() {
  $('#province').on('change', function() {
    var province_name = $(this).val();
    if (province_name) {
      $.ajax({
        url: 'ajax_get_district.php',
        method: 'GET',
        dataType: "json",
        data: {
          province_name: province_name
        },
        success: function(data) {
          $('#district').empty();

          $.each(data, function(i, district) {
            $('#district').append($('<option>', {
              value: district.name,
              text: district.name
            }));
          });
          $('#wards').empty();
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log('Error: ' + errorThrown);
        }
      });
      $('#wards').empty();
    } else {
      $('#district').empty();
    }
  });
  
  $('#district').on('change', function() {
    var district_name = $(this).val();
    console.log(district_name);
    if (district_name) {
      $.ajax({
        url: 'ajax_get_wards.php',
        method: 'GET',
        dataType: "json",
        data: {
          district_name: district_name
        },
        success: function(data) {
          $('#wards').empty();
          $.each(data, function(i, wards) {
            $('#wards').append($('<option>', {
              value: wards.name,
              text: wards.name
            }));
          });
        }, 
        error: function(xhr, textStatus, errorThrown) {
          console.log('Error: ' + errorThrown);
        }
      });
    } else {
      $('#wards').empty();
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