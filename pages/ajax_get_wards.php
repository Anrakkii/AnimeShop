<?php 
    include "../admin/database.php";
    $district_name = $_GET['district_name'];

    // echo $district_id;
    
    $sql = "SELECT * FROM tbl_wards
    JOIN tbl_district
    ON tbl_wards.district_id = tbl_district.district_id 
    WHERE district_name = '$district_name'";
    $result = mysqli_query($con, $sql);


    $data[0] = [
        'id' => null,
        'name' => 'Chọn một xã/phường'
    ];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['wards_id'],
            'name'=> $row['wards_name']
        ];
    }
    echo json_encode($data);
?>