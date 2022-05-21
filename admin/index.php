<?php

include "../connection.php";
include "../helper/base_url.php";
session_start();
$logged_on = isset($_SESSION['logged_on']) ? $_SESSION['logged_on'] : "";
if ($logged_on == true) {
  # code...
  header("location: admin.php", true, 301);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $encryptPassword = md5($password);

  $sql = "select * from master_karyawan where email='$email' and password='$encryptPassword' and status = 'Aktif'";
  $result = mysqli_query($conn, $sql);
  if ($row = mysqli_fetch_array($result)) {
    $email    = $row['email'];
    $password = $row['password'];
    $idKaryawan = $row['id'];
    $_SESSION['idKaryawan'] = $idKaryawan;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $row['name'];
    $_SESSION['outletID'] = $row['outletID'];
    $_SESSION['logged_on'] = true;

    $query = $conn->query("select karyawan_role_list.rolesID from karyawan_role_list join master_karyawan on karyawan_role_list.karyawanID = master_karyawan.id where master_karyawan.email ='$email'");
    $fetch = $query->fetch_array();
    
    $outletID = $_SESSION['outletID'];
    $queryisFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outletID'");
    $fetchIsFaskes = $queryisFaskes->fetch_array();

    $_SESSION['isFaskes'] = $fetchIsFaskes['isFaskes'];
    $_SESSION['roleID'] = $fetch['rolesID'];
    
    $fetchDataRoleName = $conn->query("SELECT master_karyawan.name, master_roles.roleName FROM `karyawan_role_list` JOIN master_karyawan ON karyawan_role_list.karyawanID = master_karyawan.id JOIN master_roles ON master_roles.id = karyawan_role_list.rolesID WHERE master_karyawan.id = '$idKaryawan'");
    $data = [];
    while ($result = $fetchDataRoleName->fetch_array()) {
      # code...
      $datas = $result['roleName'];

      array_push($data, $datas);
    }

    $_SESSION['rolesName'] = $data;
    $array = $_SESSION['rolesName'];
    header('Location: admin.php');
    
    /*log file*/
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Login ke sistem reservasi') ";
      mysqli_query($conn, $sql_query1);
    /*log file*/
  } else {
    $_SESSION["pesanError"] = 'Username atau Password Salah!';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Norbu Medika</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="<?= BASE_URL  . 'images/LogoNorbuMedika.png'?>" type="image/png">
</head>
<style>
  .card-body {
    background-color: #e0ebeb;
  }

  .card-header {
    background-color: #f0f5f5;
  }
</style>

<body class="hold-transition login-page" style="background-color: #17AE9D;">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="admin.php" class="h1">
          <img src="../images/LogoNorbuMedika.png" alt="LogoNorbu" height="80">
        </a>
      </div>
      <div class="card-body">
        <h3>
          <p class="login-box-msg"><b>LOGIN ADMIN</b></p>
        </h3>
        <!--
      <form action="auth/prosesLoginAdmin.php" method="post" id="loginform">
      -->
        <form action="" method="post" id="loginform">
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope-open-text"></span>
              </div>
            </div>
            <input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="off">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Password" id="form-password" required oninvalid="this.setCustomValidity('Password wajib diisi!')" oninput="setCustomValidity('')" autocomplete="off">
            <span class="input-group-text" id="basic-addon1">
              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password">
              </span>
            </span>
          </div>


          <div class="row">
            <!--
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          -->
            <!-- /.col -->

            <!-- /.col -->

            <div class="col-sm-9" style="text-align:right;">
              <button type="submit" name="login" class="btn btn-primary" style="background-color:#4d9900;font-weight:bold;">
                <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login
              </button>
              <button type="reset" class="btn btn-warning" onclick="ResetFunction()" style="background-color:#ffff00;font-weight:bold;">
                <i class="fas fa-redo-alt"></i> Batal
              </button>
            </div>

          </div>
        </form>
        <!--
      <div class="social#ffff00inks text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
    -->
        <!-- /.social-auth-links -->
        <!--
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <center>
      <div class="hint-text text-white">Lupa Password ? <b><a class='text-black' href="<?= BASE_URL . 'admin/utility/Lupa_Password.php' ?>"><i>Click Disini</i></a></b></div>  
    </center> 
  </div>
  <!-- /.login-box -->


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <div class="modal fade" id="myAlertModal" tabindex="-1" role="dialog" aria-labelledby="myAlertModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!--
      <div class="modal-body" style="background-color: #cccccc;" id="alertModalMessage">
        -->
        <div class="modal-body" style="background-color: #f2dede; color:#a94442;" id="alertModalMessage">
        </div>
        <!--
      <div class="modal-footer" style="background-color: #eeeeff;">
      -->
        <div class="modal-footer" style="background-color: #f2dede">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="myConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myConfirmModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-body" style="background-color: #cccccc;" id="confirmModalMessage">

        </div>

        <div class="modal-footer" style="background-color: #eeeeff;">
          <button type="button" onclick="doConfirm()" class="btn btn-success" data-dismiss="modal">OK</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function ResetFunction() {
      document.getElementById("loginform").reset();
    }
  </script>
  <script>
    $("body").on('click', '.toggle-password', function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#form-password");
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
  <script>
    var lnk = '';

    alertModal = function(msg) {
      $("#alertModalMessage").html(msg);
      $("#myAlertModal").modal("show");
    }

    doConfirm = function() {
      document.location.href = lnk;
    }

    confirmModal = function(e, msg, link) {
      e.preventDefault();
      lnk = link;
      $("#confirmModalMessage").html(msg);
      $("#myConfirmModal").modal("show");
    }
  </script>
  <?php
  if (isset($_SESSION["pesanSukses"])) {
  ?><script>
      alertModal('<?php echo $_SESSION["pesanSukses"]; ?>', 'success');
    </script><?php
              unset($_SESSION["pesanSukses"]);
            }
            if (isset($_SESSION["pesanError"])) {
              ?><script>
      alertModal('<?php echo $_SESSION["pesanError"]; ?>', 'error');
    </script><?php
              unset($_SESSION["pesanError"]);
            }
              ?>

</body>

</html>