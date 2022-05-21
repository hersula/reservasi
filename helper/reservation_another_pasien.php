<?php

include('../connection.php');

session_start();

$name = isset($_POST['name']) ? $_POST['name'] : "";
$gender = isset($_POST['gender']) ? $_POST['gender'] : "";
$address = isset($_POST['address']) ? $_POST['address'] : "";
$placeOfBirth = isset($_POST['placeOfBirth']) ? $_POST['placeOfBirth'] : "";
$dateOfBirth = isset($_POST['dateOfBirth']) ? $_POST['dateOfBirth'] : "";
$phone = empty($_POST['phone']) ? $_SESSION['phone'] : $_POST['phone'];
$isWNA = isset($_POST['isWNA']) ? (int)$_POST['isWNA'] : "";
$country = isset($_POST['country']) ? $_POST['country'] : "null";
$passport = isset($_POST['passport']) ? $_POST['passport'] : "";
$nik2 = empty($_POST['nik2']) ? $_POST['passport']  : $_POST['nik2'];

// echo "NIK : " . $nik2, "NAME : " . $name, $gender, $address, $placeOfBirth, $dateOfBirth, "PHONE : " . $phone, "IsWNA : " .  $isWNA, " COUNTRY : " . $country, "PASSPORT : " . $passport;

// $insert_query = "insert into master_pasien value (null, '$nik2', '$name', 'null', '$phone', '$address', '$gender', '$placeOfBirth', '$dateOfBirth', 'null', 'null', 'null', 'Aktif', $passport, '$country', '$isWNA', 0, NOW())";

// $execute = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
// exit();

if ($nik2 == '' && $passport == 0) {
    # code...
    echo '<script>alert("Maaf field NIK atau Passport salah satunya harus diisi !");history.go(-1);</script>';
    exit();
} else if ($passport != 0) {
    if ($country == '') {
        echo "Maaf field country mohon diisi !";
        exit();
    } else {
        $cek_passport = mysqli_query($conn, "select * from master_pasien where passport = $passport") or die(mysqli_error($conn));

        if (mysqli_num_rows($cek_passport) > 0) {
            # code...
            echo '<script>alert("Maaf, kamu tidak bisa mendaftarkan Passport tersebut karena sudah terdaftar !");history.go(-1);</script>';
            exit();
        }
    }
} else if ($nik2 != '') {
    $cek_nik = mysqli_query($conn, "select * from master_pasien where nik = '$nik2'") or die(mysqli_error($conn));

    if (mysqli_num_rows($cek_nik) > 0) {
        # code...
        echo '<script>alert("Maaf, kamu tidak bisa mendaftarkan NIK tersebut karena sudah terdaftar !");history.go(-1);</script>';
        exit();
    }
}

$insert_query = "insert into master_pasien values (null, '$nik2', '$name', 'null', '$phone', '$address', '$gender', '$placeOfBirth', '$dateOfBirth', 'null', 'null', 'null', 'Aktif', '$passport', '$country', $isWNA, 0, NOW())";

// mysqli_query($conn, $insert_query) or die(mysqli_error($conn));

if (mysqli_query($conn, $insert_query) or die(mysqli_error($conn))) {
    # code...
    $_SESSION['nikTo'] = isset($nik2) ? $nik2 : $passport;
    header("location:  ../pasien/main/index.php?page=epidemiologi", true, 301);
} else {
    echo '<script>alert("Tindakan baru gagal ditambahkan ! Mohon periksa kembali datanya!");history.go(-1);</script>';
}
