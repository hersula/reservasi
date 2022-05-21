<!DOCTYPE html>
<html lang="en">

<head>
  <title>Aktivasi Akun | Norbu Medika</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container" align="center">
    <br>
    <?php
    include "../connection.php";
    include "../helper/base_url.php";
    $token = $_GET['t'];
    $sql_cek = mysqli_query($conn, "select * from master_pasien where token='" . $token . "' and isEmailVerified=0");
    $jml_data = mysqli_num_rows($sql_cek);
    if ($jml_data == 1) {
      //update data users aktif
      mysqli_query($conn, "update master_pasien set isEmailVerified=1 where token='" . $token . "' and isEmailVerified=0");
      echo '<div class="alert alert-success">
                        Akun anda sudah aktif, silahkan <a href="'.BASE_URL.'">Login Sekarang</a>
                    </div>';
    } else {
      //data tidak di temukan
      echo '<div class="alert alert-warning">
                    Invalid Token!
            </div>';
    }
    ?>
  </div>
</body>

</html>