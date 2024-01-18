<?php 
include "./admin/database.php";
    
    $province_name = $_GET['province_name'];
    
    $sql = "SELECT * FROM tbl_district
    JOIN tbl_province
    ON tbl_district.province_id = tbl_province.province_id 
    WHERE tbl_province.province_name = '$province_name'";
    $result = mysqli_query($con, $sql);

    $data[0] = [
        'id' => null,
        'name' => 'Chọn một Quận/huyện'
    ];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['district_id'],
            'name'=> $row['district_name']
        ];
    }
    echo json_encode($data);
?>