<?php 
session_start();
include_once('../connection.php');
include_once('../helper/base_url.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['nik'] == "" && $_POST['fullname'] == "" && $_POST['email'] == "") {
        # code...
        header("location: " . BASE_URL . "/register.php", true, 301);
    } else {
        $nik = isset($_POST['nik']) ? $_POST['nik'] : '';
        $fullname = strtoupper($_POST['fullname']);
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $placeofbirth = strtoupper($_POST['placeofbirth']);
        $dateofbirth = $_POST['dateofbirth'];
        $address = strtoupper($_POST['address']);
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $token = hash('sha256', md5(date("Y-m-d H:i:s")));
        $confirm_password = $_POST['confirm_password'];
        $isWNA = isset($_POST['isWNA']) ? $_POST['isWNA'] : 0;
        $country = empty($_POST['country']) ? "Indonesia" : $_POST['country'];
        $passport = isset($_POST['passport']) ? (int)$_POST['passport'] : 0;

        // echo "$nik, $fullname, $email, $phone, $placeofbirth, $dateofbirth, $address, $gender, $password, $token, $confirm_password, $isWNA, $country, $passport";

        // exit();

        if (strlen($password) < 8 || strlen($confirm_password) < 8) {
            

            $_SESSION['register'] = $_POST;
            $_SESSION['error_register'] = "Maaf, Panjang karakter password min 8 &hellip;";

            header('location: ' . $_SERVER['HTTP_REFERER']);
        } else if ($password != $confirm_password) {
            session_start();

            $_SESSION['register'] = $_POST;
            $_SESSION['error_register'] = "Field konfirmasi password tidak sama dengan password &hellip;";

            header('location: ' . $_SERVER['HTTP_REFERER']);
        } else if ($gender == '') {
       	    session_start();

            $_SESSION['register'] = $_POST;
            $_SESSION['error_register'] = "Field keterangan jenis kelamin tidak boleh kosong &hellip;";

            header('location: ' . $_SERVER['HTTP_REFERER']);
        
        } else if ($nik == '' && $passport == 0) {
            session_start();

            $_SESSION['register'] = $_POST;
            $_SESSION['error_register'] = "Field NIK atau Passport tidak boleh kosong &hellip;";

            header('location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $encryptPassword = md5($password);

            $cek_data = mysqli_query($conn, "select * from master_pasien where nik = '$nik' || email = '$email' || phone = '$phone'");

            if (mysqli_num_rows($cek_data) > 0) {
                session_start();

                $_SESSION['register'] = $_POST;
                $_SESSION['error_register'] = "NIK, No HP, atau email telah terdaftar ! &hellip;";

                header('location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                session_destroy();
                if ($nik != '') {
                    $insert_query = "insert into master_pasien value (null, '$nik', '$fullname', '$email', '$phone', '$address', '$gender', '$placeofbirth', '$dateofbirth', '$encryptPassword', 'null', '$token', 'Aktif', $passport, '$country', '$isWNA', 1, 0, NOW())";
                    $execute = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
                    include("email.php");

                    if ($execute) {
                        # code...
                        # header("location: info_activation_send.php", true, 301);
                        echo("<script>location.href = 'info_activation_send.php';</script>");

                        exit();
                    } else {
                        session_start();

                        $_SESSION['register'] = $_POST;
                        $_SESSION['error_register'] = "Maaf, Terjadi Kesalahan! Mohon coba lagi! &hellip;";

                        header('location: ' . $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $insert_query = "insert into master_pasien value (null, $passport, '$fullname', '$email', '$phone', '$address', '$gender', '$placeofbirth', '$dateofbirth', '$encryptPassword', 'null', '$token', 'Aktif', $passport, '$country', '$isWNA', 1, 0, NOW())";
                    $execute = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
                    include("email.php");

                    if ($execute) {
                        # code...
                        #header("location: info_activation_send.php", true, 301);
                         echo("<script>location.href = 'info_activation_send.php';</script>");
                        exit();
                    } else {
                        session_start();

                        $_SESSION['register'] = $_POST;
                        $_SESSION['error_register'] = "Maaf, Terjadi Kesalahan! Mohon coba lagi! &hellip;";

                        header('location: ' . $_SERVER['HTTP_REFERER']);
                    }
                }
            }
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Register | Norbu Medika</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

</html>