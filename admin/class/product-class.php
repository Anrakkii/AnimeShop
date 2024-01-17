<?php
include "../admin/database.php";


?>

<?php
class product {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function show_category(){
        $query = "SELECT * FROM tbl_category ORDER BY category_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_brand($product_id){
        // $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
        $query = "SELECT tbl_brand.*, tbl_product.product_name
        FROM tbl_brand INNER JOIN tbl_product ON tbl_brand.brand_id = tbl_product.brand_id
        WHERE product_id = $product_id
        ORDER BY tbl_brand.brand_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_product(){
        $query = "SELECT tbl_product.*, tbl_category.category_name, tbl_brand.brand_name
        FROM tbl_product
        INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
        INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
        ORDER BY tbl_product.product_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function related_product($brand_id){
        $query = "SELECT * FROM tbl_product WHERE brand_id = '$brand_id' ORDER BY brand_id ASC LIMIT 4 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_img_desc(){
        $query = "SELECT tbl_product_img_desc.*
        FROM tbl_product_img_desc
        ORDER BY tbl_product_img_desc.product_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_brand_ajax($category_id){
        // $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
        $query = "SELECT * FROM tbl_brand WHERE category_id = '$category_id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function delete_brand($brand_id){
        $query = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->delete($query);
        header('Location:productlist.php');
        return $result;
    }

    public function get_product($product_id){
        $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_product_img_desc($product_id){
        $query = "SELECT * FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function delete_product($product_id){
        $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        while($after_result = $result->fetch_assoc()){
            unlink("uploads/".$after_result['product_img']);
        }
        $query = "DELETE FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->delete($query);
        header('Location:productlist.php');
        return $result;
    }

    public function delete_product_img_desc($product_id){
        $query = "SELECT * FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        while($after_result = $result->fetch_assoc()){
            unlink("uploads/images_desc/".$after_result['product_img_desc']);
        }
        header('Location:productlist.php');
        $query = "DELETE FROM tbl_product_img_desc WHERE product_id = '$product_id'";
        $result = $this->db->delete($query);
        return $result;
    }

    public function insert_product() {
        $product_name = $_POST['product_name'];
        if($product_name == "") {
            $arlet = "Vui lòng phải nhập tên sản phẩm";
            return $arlet;
         }
        $category_id = $_POST['category_id'];
        if($category_id == "#") {
            $arlet = "Vui lòng phải chọn danh mục";
            return $arlet;
         }
        $brand_id = $_POST['brand_id'];
        if($brand_id == "#") {
            $arlet = "Vui lòng phải chọn loại sản phẩm";
            return $arlet;
         }
        $product_price = $_POST['product_price'];
        if($product_price == "") {
            $arlet = "Vui lòng phải nhập giá sản phẩm";
            return $arlet;
         }
        $product_sale = $_POST['product_sale'];
        if($product_sale == "") {
            $arlet = "Vui lòng phải nhập giá khuyến mãi bằng hoặc nhỏ hơn giá sản phẩm";
            return $arlet;
         } else {
            if($product_sale > $product_price){
                $arlet = "Vui lòng phải nhập giá khuyến mãi bằng hoặc nhỏ hơn giá sản phẩm";
                return $arlet;
            }
         }
        $product_desc = $_POST['product_desc'];
        if($product_desc == "") {
            $arlet = "Vui lòng phải nhập mô tả cho sản phẩm";
            return $arlet;
         }
        $product_img = $_FILES['product_img']['name'];
        $filetarget = basename($_FILES['product_img']['name']);
        $filesize = $_FILES['product_img']['size'];
        if ($filesize == 0){
            $alert = "vui lỏng phải có ảnh sản phẩm";
            return $alert;
        } elseif (file_exists("uploads/$filetarget")){
            $alert = "file ảnh sản phẩm đã tồn tại";
            return $alert;
        } else {
            if ($filesize > 307200){
                $alert = "File ảnh sản phẩm không được lớn hơn 300KB";
                return $alert;
            } else {
            move_uploaded_file($_FILES['product_img']['tmp_name'],"uploads/".$_FILES['product_img']['name']);
            $query = "INSERT INTO tbl_product (
            product_name,
            category_id,
            brand_id,
            product_price,
            product_sale,
            product_desc,
            product_img) VALUES (
                '$product_name',
                '$category_id',
                '$brand_id',
                '$product_price',
                '$product_sale',
                '$product_desc',
                '$product_img')";
            $result = $this->db->insert($query);
                if($result){
                    $query= "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
                    $result = $this->db->select($query)->fetch_assoc();
                    $product_id = $result['product_id'];
                    $filename = $_FILES['product_img_desc']['name'];
                    $filetmp = $_FILES['product_img_desc']['tmp_name'];
                    $i = 0;

                    foreach ($filename as $key => $value) {
                        $minifiletarget = basename($_FILES['product_img_desc']['name'][$key]);
                        $filesize_desc = $_FILES['product_img_desc']['size'][$key];
                        if ($filesize_desc == 0){
                            $alert = "vui lỏng phải có ảnh mô tả";
                            $error = "DELETE FROM tbl_product WHERE product_id = $product_id";
                            $result = $this->db->delete($error);
                            $file_to_delete = "uploads/".$_FILES['product_img']['name'];
                            unlink($file_to_delete);
                            return $alert;
                        } elseif (file_exists("uploads/images_desc/$minifiletarget")){
                            $file_to_delete = "uploads/".$_FILES['product_img']['name'];
                            unlink($file_to_delete);
                            $alert = "file ảnh mô tả đã tồn tại";
                            $error = "DELETE FROM tbl_product WHERE product_id = $product_id";
                            $result = $this->db->delete($error);
                            $error = "DELETE FROM tbl_product_img_desc WHERE product_id = $product_id";
                            $result = $this->db->delete($error);
                            if($i>0){
                                for($j = 0; $j < $i; $j++){
                                $file_to_delete = "uploads/images_desc/".$filename[$j];
                                unlink($file_to_delete);
                                }
                            }
                            return $alert;
                        } else {
                            if ($filesize_desc > 307200){
                                $alert = "File ảnh mô tả không được lớn hơn 300KB";
                                $error = "DELETE FROM tbl_product WHERE product_id = $product_id";
                                $result = $this->db->delete($error);
                                $error = "DELETE FROM tbl_product_img_desc WHERE product_id = $product_id";
                                $result = $this->db->delete($error);
                                $file_to_delete = "uploads/".$_FILES['product_img']['name'];
                                unlink($file_to_delete);
                                if($i>0){
                                    for($j = 0; $j < $i; $j++){
                                    $file_to_delete = "uploads/images_desc/".$filename[$j];
                                    unlink($file_to_delete);
                                    }
                                }
                                return $alert;
                            } else {
                                move_uploaded_file($filetmp [$key], "uploads/images_desc/".$value);
                                // move_uploaded_file($filetmp['product_img_desc'][$key],"uploads/".$_FILES['product_img']['name']);
                                $query = "INSERT INTO tbl_product_img_desc (product_id, product_img_desc) VALUES ('$product_id','$value')";
                                $result = $this->db->insert($query);
                                $i++;
                                
                            }
                        }
                    }
                }
            
            }
        // header('Location:productlist.php');
        return $result;
        }
    }

    public function update_product($category_id,$product_name,$product_price,$product_sale,$product_desc,$old_img,$product_img,$product_img_desc,$brand_id,$product_id){
        $query= "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
        $result = $this->db->select($query)->fetch_assoc();
        $old_target = $result['product_img'];
        $old_img =  $_POST['old_img'];
        $new_target = basename($product_img);
        $filesize = $_FILES['product_img']['size'];
        if($product_name == "") {
            $arlet = "Vui lòng phải nhập tên sản phẩm";
            return $arlet;
         }
         if($category_id == "#") {
            $arlet = "Vui lòng phải chọn danh mục";
            return $arlet;
         }
         if($brand_id == "#") {
            $arlet = "Vui lòng phải chọn loại sản phẩm";
            return $arlet;
         }
         if($product_price == "") {
            $arlet = "Vui lòng phải nhập giá sản phẩm";
            return $arlet;
         }
         if($product_sale == "") {
            $arlet = "Vui lòng phải nhập giá khuyến mãi bằng hoặc nhỏ hơn giá sản phẩm";
            return $arlet;
         } else {
            if($product_sale > $product_price){
                $arlet = "Vui lòng phải nhập giá khuyến mãi bằng hoặc nhỏ hơn giá sản phẩm";
                return $arlet;
            }
         }
         if($product_desc == "") {
            $arlet = "Vui lòng phải nhập mô tả cho sản phẩm";
            return $arlet;
         }
        if (file_exists("uploads/$new_target") and $filesize != 0){
            $alert = "file ảnh sản phẩm đã tồn tại";
            return $alert;
        } elseif ($old_target == null){
            if ($filesize > 307200){
                $alert = "File ảnh sản phẩm không được lớn hơn 300KB";
                return $alert;
            } else {
                move_uploaded_file($_FILES['product_img']['tmp_name'],"uploads/".$_FILES['product_img']['name']);
                $query = "UPDATE tbl_product SET product_name = '$product_name',
                product_price = '$product_price',
                product_sale = '$product_sale',
                product_desc = '$product_desc',
                product_img = '$product_img',
                brand_id = '$brand_id',
                category_id = '$category_id' WHERE product_id = '$product_id'";
                $result = $this->db->update($query);
                // header('Location:productlist.php');
                return $result;
            }
        } else{
            if ($filesize > 307200){
                $alert = "File ảnh sản phẩm không được lớn hơn 300KB";
                return $alert;
            } else {
                if($filesize != 0){
                    unlink("uploads/".$old_img);
                    move_uploaded_file($_FILES['product_img']['tmp_name'],"uploads/".$_FILES['product_img']['name']);
                    $query = "UPDATE tbl_product SET product_name = '$product_name',
                    product_price = '$product_price',
                    product_sale = '$product_sale',
                    product_desc = '$product_desc',
                    product_img = '$product_img',
                    brand_id = '$brand_id',
                    category_id = '$category_id' WHERE product_id = '$product_id'";
                    $result = $this->db->update($query);
                    // header('Location:productlist.php');
                    // return $result;
                }else{
                    $query = "UPDATE tbl_product SET product_name = '$product_name',
                    product_price = '$product_price',
                    product_sale = '$product_sale',
                    product_desc = '$product_desc',
                    brand_id = '$brand_id',
                    category_id = '$category_id' WHERE product_id = '$product_id'";
                    $result = $this->db->update($query);
                }
                if($result){
                    $query = "SELECT * FROM tbl_product_img_desc WHERE product_id = '$product_id'";
                    // $old_img_desc = $_POST['old_img_desc'];
                    $result = $this->db->select($query);
                    $j = 0;
                    $old_img_desc_target = array();
                    while($after_result = $result->fetch_assoc()){
                        $old_img_desc_target[] = $after_result['product_img_desc'];
                        $j++;
                    }
                    $filename = $_FILES['product_img_desc']['name'];
                    $y = count($filename);
                    $filetmp = $_FILES['product_img_desc']['tmp_name'];
                    $i = 0;

                    foreach ($filename as $key => $value) {
                        $minifiletarget = basename($_FILES['product_img_desc']['name'][$key]);
                        $filesize_desc = $_FILES['product_img_desc']['size'][$key];
                        // if ($filesize_desc == 0){
                        //     $alert = "vui lỏng phải có ảnh mô tả";
                        //     $error = "DELETE FROM tbl_product WHERE product_id = $product_id";
                        //     $result = $this->db->delete($error);
                        //     $file_to_delete = "uploads/".$_FILES['product_img']['name'];
                        //     unlink($file_to_delete);
                        //     return $alert;
                        if (file_exists("uploads/images_desc/$minifiletarget") and $filesize_desc != 0){
                            // $file_to_delete = "uploads/".$_FILES['product_img']['name'];
                            // unlink($file_to_delete);
                            $alert = "file ảnh mô tả đã tồn tại";
                            // $error = "DELETE FROM tbl_product WHERE product_id = $product_id";
                            // $result = $this->db->delete($error);
                            // $error = "DELETE FROM tbl_product_img_desc WHERE product_id = $product_id";
                            // $result = $this->db->delete($error);
                            if($i>0){
                                for($j = 0; $j < $i; $j++){
                                $file_to_delete = "uploads/images_desc/".$filename[$j];
                                unlink($file_to_delete);
                                }
                            }
                            return $alert;
                        } else {
                            if ($filesize_desc > 307200){
                                $alert = "File ảnh mô tả không được lớn hơn 300KB";
                                // foreach($old_img_desc_target as $val){
                                //     $error = "DELETE FROM tbl_product_img_desc WHERE product_img_desc = $val";
                                //     $result = $this->db->delete($error);
                                //     $file_to_delete = "uploads/images_desc/".$val;
                                //     unlink($file_to_delete);
                                // }
                                if($i>0){
                                    for($x = 0; $x < $i; $x++){
                                    $file_to_delete = "uploads/images_desc/".$filename[$j];
                                    unlink($file_to_delete);
                                    }
                                }
                                return $alert;
                            } else {
                                if($filesize_desc != 0){
                                    move_uploaded_file($filetmp [$key], "uploads/images_desc/".$value);
                                    // move_uploaded_file($filetmp['product_img_desc'][$key],"uploads/".$_FILES['product_img']['name']);
                                    // $query = "UPDATE tbl_product_img_desc SET product_img_desc = '$value'
                                    // WHERE product_id = '$product_id'";
                                    // $result = $this->db->update($query);
                                    $query = "INSERT INTO tbl_product_img_desc (product_id, product_img_desc) VALUES ('$product_id','$value')";
                                    $result = $this->db->insert($query);
                                    $i++;
                                    if($i == $y){
                                        for($z=0; $z < $j; $z++){
                                            // if (file_exists("uploads/images_desc/".$old_img_desc_target)){
                                                unlink("uploads/images_desc/".$old_img_desc_target[$z]);
                                                $error = "DELETE FROM tbl_product_img_desc WHERE product_img_desc = '$old_img_desc_target[$z]'";
                                                $result = $this->db->delete($error);
                                            // }
                                        }
                                    }
                                }
                            
                            }
                        }
                    }
                }
                // }

            }
            header('Location:productlist.php');
            return $result;
        }
    }



}