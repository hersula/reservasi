<?php 

error_reporting(0);

include "../../connection.php";
include "../../helper/base_url.php";

$passwordBaru="";
$error = 0;

if(isset($_POST["simpan"])) {
    $email = $_GET['email'];
    if (!empty($email)) {
        $email_ = $email;
    }else{
        $email_ = '';
    }

  $passwordBaru = md5($_POST["password"]);
  $passwordBaru_conf = md5($_POST['confirm_password']);

  if($error == 0){
    if ($passwordBaru != $passwordBaru_conf){
        echo '<script>
              alert("Password dan Re-Password yang dimasukan harus sama !");
              window.location.href = "'.BASE_URL.'/admin/utility/Lupa_Password.php?page=lupa-password&email='.$_GET['email'].'";
              </script>';
    }else{
        $sql2 = "update master_karyawan set password = '$passwordBaru' where email='$email_'";
        mysqli_query($conn, $sql2);
    
          if(mysqli_error($conn) == ""){
            echo '<script>
                  alert("Password baru berhasil diubah, Silahkan login kembali.");
                  window.location.href = "'.BASE_URL.'/admin";
                  </script>';
          }else{
            echo '<script>
                  alert("Password baru tidak berhasil diubah.");
                  window.location.href = "'.BASE_URL.'/admin";
                  </script>';
          }
    }
    
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Norbu Medika Online Reservation</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bootstrap/css/template/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="../../images/LogoNorbuMedika.png" type="image/png">

</head>
<style>
  
  .body-btn {
      width:320px;
      height:40px;
  }

  .body-btn2 {
      width:320px;
      height:40px;
  }

</style>

<body style="background-color: #17AE9D;">
<div class="login-form">
    <h2 class="text-center text-white">Lupa Password</h2>
                <?php
                    if ($_GET['page'] == 'lupa-password') {
                ?>
                    <form method="POST">
                <?php
                    }else{
                ?>
                    <form method="POST" action="reSendLupaPassword.php" name="formLupaPassword">
                <?php
                    }
                ?>
      <div class="avatar" style="background-color:#e6e6e6;">
        <img src="<?= BASE_URL . 'images/LogoNorbuMedika.png' ?>" alt="LogoNorbu" height="70">
      </div>

      <!-- <?php
                        if (!empty($_SESSION['error_register'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="font-size: 14px;">
                                <?= @$_SESSION["error_register"] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php   } else echo '' ?> -->
    
                        <?php
                                //if (isset($_GET['page'])) {
                                  $page = isset($_GET['page']);

                                  if ($page == 'lupa-password') {
                        ?>
                                
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-unlock" aria-hidden="true"></i>
                                    </span>
                                    <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password" required>
                                    <span class="input-group-text" id="basic-addon1">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password">
                                    </span>
                                    </span>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-unlock" aria-hidden="true"></i>
                                    </span>
                                    <input type="password" class="form-control" id="InputRePassword" placeholder="Confirm Password" name="confirm_password" required>
                                    <span class="input-group-text" id="basic-addon1">
                                        <span toggle="#password-field" class=" fa fa-fw fa-eye-slash field_icon toggle-password2">
                                    </span>
                                    </span>
                                </div>

                                <!-- <div class="form-group">
                                    <button type="submit" name="simpan" value="simpan" class="btn btn-primary btn-block" style="background-color: #4aba70; border: 1px solid #4aba70"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                                </div> -->

                                <div class="body-btn2">
                                    <button type="submit" name="simpan" value="simpan" class="btn btn-primary btn-lg" style="background-color: #4aba70; border: 1px solid #4aba70; width:320px;"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                                </div>
                        
                        <?php
                                  }else{
                        ?>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" name="email" id="address" placeholder="Confirm Email" required></input>
                                </div>

                                <div class="body-btn">
                                    <button type="submit" class="btn btn-primary btn-lg" style="background-color: #4aba70; border: 1px solid #4aba70; width:320px;"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                                </div>

                        <?php
                                  }
                        ?>
    </form>
  </div>

  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->

  <script type="text/javascript" src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
        $("body").on('click', '.toggle-password', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#InputPassword");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
        $("body").on('click', '.toggle-password2', function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $("#InputRePassword");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>
    <script type="text/javascript">
        function validasiEmail() {
            var rs = document.forms["formRegister"]["email"].value;
            var atps = rs.indexOf("@");
            var dots = rs.lastIndexOf(".");
            if (atps < 1 || dots < atps + 2 || dots + 2 >= rs.length) {
                alert("Your email is not valid!");
                return false;
            }
        }

        $(document).ready(function () {
          $("#isWNA").change(function() {
            var determineCountry = $("#isWNA").val();
            var country = $("#country").val("Indonesia");
            if (determineCountry == "0") {
                 country.trigger('change');
            }     
          });
        });
    </script>

</body>

</html>