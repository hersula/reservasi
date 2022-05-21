<?php
include '../../../connection.php';
$nik = $_GET['nik'];
$query = mysqli_query($conn, "select * from master_pasien where nik='$nik'");
if($query->num_rows > 0) {
    $result = mysqli_fetch_array($query);
    //$isWNA = $result['isWNA'] == 0 ? 'WNI' : 'WNA';
    $data = array(
            'nik'      =>  $result['nik'],
            'name'   =>  $result['name'],
            'passport'    =>  $result['passport'],
            'country'    =>  $result['country'],
            'phone'    =>  $result['phone'],
            //'isWNA'    =>  $isWNA,
            'isWNA'    =>  $result['isWNA'],
            'gender' => $result['gender'],
            'address' => $result['address'],
            'placeOfBirth' => $result['placeOfBirth'],
            'dateOfBirth' => $result['dateOfBirth'],
        );
    echo json_encode($data);
} else {
    $result = mysqli_fetch_array($query);
    //$isWNA = $result['isWNA'] == 0 ? 'WNI' : 'WNA';
    $data = array(
            'nik'      =>  $result['nik'],
            'name'   =>  $result['name'],
            'passport'    =>  $result['passport'],
            'country'    =>  $result['country'],
            'phone'    =>  $result['phone'],
            //'isWNA'    =>  $isWNA,
            'isWNA'    =>  $result['isWNA'],
            'gender' => $result['gender'],
            'address' => $result['address'],
            'placeOfBirth' => $result['placeOfBirth'],
            'dateOfBirth' => $result['dateOfBirth'],
        );
    echo json_encode($data);
}