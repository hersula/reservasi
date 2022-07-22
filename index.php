<?php

include('helper/base_url.php');

session_start();
$logged_on = isset($_SESSION['logged_on']) ? $_SESSION['logged_on'] : "";
if ($logged_on == true) {
  # code...
  header("location: pasien/main", true, 301);
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Norbu Medika Online Reservation</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/css/template/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="images/LogoNorbuMedika.png" type="image/png">

  <!-- tambahan modal -->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

      <script>
        $(document).ready(function() {
            //focusin berfungsi ketika cursor berada di dalam textbox modal langsung aktif
            $(".pencarian").focusin(function() {
              $("#myModal").modal('show'); // ini fungsi untuk menampilkan modal
            });
            $('#example').DataTable(); // fungsi ini untuk memanggil datatable
          });
          
          // function in berfungsi untuk memindahkan data kolom yang di klik menuju text box
          function masuk(txt, data) {
            document.getElementById('nik').value = data; // ini berfungsi mengisi value  yang ber id textbox
            $("#myModal").modal('hide'); // ini berfungsi untuk menyembunyikan modal
          }
    </script>
</head>

<body style="background-color: #17AE9D;">
  <div class="login-form">
    <h2 class="text-center text-white">LOGIN MEMBER</h2>
    <form action="<?= BASE_URL . 'auth/prosesLogin.php' ?>" method="post">
      <div class="avatar" style="background-color:#e6e6e6;">
        <img src="<?= BASE_URL . 'images/LogoNorbuMedika.png' ?>" alt="LogoNorbu" height="70">
      </div>
      <?php 
      if (!empty($_SESSION['error'])) {
        # code...
        echo '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="font-size: 14px;">
         ' . @$_SESSION["error"] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      } else echo '' ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
        <input required type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" autocomplete="off" value="<?= @$_SESSION['login']['email'] ?>" required>
      </div>

      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="fa fa-unlock" aria-hidden="true"></i>
        </span>
        <input required type="password" id="form-password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" autocomplete="off" required>

        <!--
            <span class="input-group-text" id="basic-addon1">
            <i class="fa fa-eye-slash" id="togglepassword" aria-hidden="true" toggle="#password-field"></i>
            </span>
            -->
        <span class="input-group-text" id="basic-addon1">
          <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password">
          </span>
        </span>
      </div>
      <div class="form-group">
        <label class="form-check-label"><input type="checkbox"> Remember me</label>
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fa fa-sign-in" aria-hidden="true"></i> Login
        </button>
      </div>
    </form>
    <div class="hint-text text-white">Belum memiliki akun? <b><a class='text-black' href="<?= BASE_URL . 'register.php' ?>">Daftar Sekarang</a></b></div>
     <div class="hint-text text-white">Lupa Password ? <b><a class='text-black' href="<?= BASE_URL . 'Lupa_Password.php' ?>"><i><u>Click Disini</u></i></a></b></div>
  </div>

  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->

  <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
    $("body").on('click', '.toggle-password', function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#form-password");
      (input.attr("type") === "password") ? input.attr("type", "text") : input.attr("type", "password");
    });
    
      /*
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    */

    /*
    $("body").on('click', '.input-group-text', function() {
      $(this).toggleClass("fa-eye fa-eye");
      var input = $("#form-password");
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }

    });
    */
  </script>

</body>

</html>