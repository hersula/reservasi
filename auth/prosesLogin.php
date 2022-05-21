<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Login | Norbu Medika</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container" align='center'>
        <?php
        
        if ($_POST['email'] == "" && $_POST['password'] == "") {
            # code...
            include_once('../helper/base_url.php');
            # header("location: ". BASE_URL, true, 301);
            echo("<script>location.href = '".BASE_URL."';</script>");
        } else {
            include_once('../connection.php');
            include_once('../helper/base_url.php');

            $email = $_POST['email'];
            $password = $_POST['password'];

            $cek_email = mysqli_query($conn, "select * from master_pasien where email = '$email'") or die(mysqli_error($conn));

            if (mysqli_num_rows($cek_email) == 0) {

                $_SESSION['login'] = $_POST;
                $_SESSION['error'] = "Maaf, Email Belum Terdaftar &hellip;";

                #header('location: ' . $_SERVER['HTTP_REFERER']);
                echo("<script>location.href = '".BASE_URL."';</script>");
            } else {
                $cek_activation = mysqli_query($conn, "SELECT * from master_pasien where email = '$email'  && isEmailVerified = 0") or die(mysqli_error($conn));

                if (mysqli_num_rows($cek_activation) == 1) {
                    # code...
                    echo '<div class="alert alert-danger">
                            <h5>Maaf, akun anda belum diaktivasi ! Silahkan periksa email yang anda daftarkan !</h5> <br>
                            <b><a href="reSendEmail.php?email=' . $email . '" class="text-danger">Kirim ulang kode aktivasi !</a></b>
                        </div>';
                    exit();
                } else {
                    $encryptPassword = md5($password);
                    $select_email = mysqli_query($conn, "select * from master_pasien where email='$email' AND password='$encryptPassword'") or die(mysqli_error($conn));

                    if (mysqli_num_rows($select_email) == 1) {
                        # code...
                        $result = mysqli_fetch_array($select_email);
                        $_SESSION['idPasien'] = $result['idPasien'];
                        $_SESSION['nik'] = $result['nik'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['phone'] = $result['phone'];
                        $_SESSION['name'] = $result['name'];
                        $_SESSION['logged_on'] = true;
                        #header("location: ../pasien/main", true, 301);
                        echo("<script>location.href = '".BASE_URL."';</script>");
                        exit();
                    } else { 
                        session_start();

                        $_SESSION['login'] = $_POST;
                        $_SESSION['error'] = "Maaf, Email atau password anda salah &hellip;";
        
                        #header('location: ' . $_SERVER['HTTP_REFERER']);
                        echo("<script>location.href = '".BASE_URL."';</script>");
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>