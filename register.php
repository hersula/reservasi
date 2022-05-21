<?php

include('helper/base_url.php');
include('connection.php');

session_start();
$logged_on = isset($_SESSION['logged_on']) ? $_SESSION['logged_on'] : "";
if ($logged_on == true) {
    # code...
    header("location: pasien/main", true, 301);
    exit();
}

?>

<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Norbu Medika Online Reservation</title>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <link rel="stylesheet" href="admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="icon" href="images/LogoNorbuMedika.png" type="image/png"> -->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="icon" href="images/LogoNorbuMedika.png" type="image/png">
    <!--end of DataTable -->
    <!-- Select2 -->
    <link rel="stylesheet" href="admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!--Sweet Alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <!--end of Sweet Alert-->
    <!--end of Sweet Alert untuk master-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body style="background-color: #17AE9D;">
    </div>
    <section class="container-fluid">
        <div class="row justify-content-center py-5">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="card">
                    <form class="card-body" action="<?= BASE_URL . 'auth/prosesRegister.php' ?>" method="POST" name="formRegister" onsubmit="validasiEmail();">
                        <img src="images/LogoNorbuMedika.png" class="rounded mx-auto d-block mb-5" width="100px" alt="...">

                        <h4 class="text-center font-weight-bold mt-3"> FORM REGISTRASI</h4>
                        
                        <!-- validation message -->
                        <?php
                        if (!empty($_SESSION['error_register'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="font-size: 14px;">
                                <?= @$_SESSION["error_register"] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php   } else echo '' ?>
                        
                        <!-- fulname field -->
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <span class="text-warning">*</span>
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="<?= @$_SESSION['register']['fullname'] ?>" required>
                        </div>
                        
                        <!-- address field -->
                        <div class="form-group">
                            <label for="InputAddress">Alamat Lengkap</label>
                            <span class="text-warning">*</span>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Full Address" required value="<?= @$_SESSION['register']['address'] ?>"></input>
                        </div>
                        
                        <!-- phone field -->
                        <div class="form-group">
                            <label for="InputPhone">Nomor Telepon / Whatsapp</label>
                            <span class="text-warning">*</span>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Example: 08581928xxxx" value="<?= @$_SESSION['register']['phone'] ?>" required>
                        </div>
                        
                        <!-- birthday -->
                        <div class="form-group">
                            <label for="InputPlaceofBirth">Tempat Lahir</label>
                            <span class="text-warning">*</span>
                            <input type="text" class="form-control" name="placeofbirth" id="placeofbirth" aria-describeby="emailHelp" placeholder="Place of Birth" value="<?= @$_SESSION['register']['placeofbirth'] ?>"  required >
                        </div>
                        <div class="form-group">
                            <label for="InputDateofBirth">Tanggal Lahir</label>
                            <span class="text-warning">*</span>
                            <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" placeholder="Date of Birth" value="<?= @$_SESSION['register']['dateofbirth'] ?>" required>
                        </div>
                        
                        <!-- gender fields -->
                        <div class="form-group">
                            <label for="InputAddress">Jenis Kelamin</label>
                            <span class="text-warning">*</span>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="flexRadioDefault1" name="gender" value="Laki-laki">
                                <label class="form-check-label" for="flexRadioDefault1">
                                        Laki-laki
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" id="flexRadioDefault1" name="gender" value="Perempuan">
                                <label class="form-check-label" for="flexRadioDefault1">
                                        Wanita
                                </label>
                            </div>
                        </div>
                        
                        <!-- citizenship -->
                        <!--<div class="form-group after-add-more">-->
                        <!--    <label for="InputAddress">Kewarganegaraan</label>-->
                        <!--    <span class="text-warning">*</span>-->
                        <!--    <div class="form-check">-->
                        <!--        <input class="form-check-input" type="radio" id="isWNA" name="isWNA" value="0">-->
                        <!--        <label class="form-check-label" for="isWNA">-->
                        <!--            WNI-->
                        <!--        </label>-->
                        <!--    </div>-->
                        <!--    <div class="form-check mt-2">-->
                        <!--        <input class="form-check-input" type="radio" id="isWNA2" name="isWNA" value="1">-->
                        <!--        <label class="form-check-label" for="isWNA2">-->
                        <!--           WNA-->
                        <!--        </label>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <!-- country -->
                        <!--<div class="form-group mt-4">-->
                        <!--    <label>Asal <span class='text-info'>(Optional)</span></label>-->
                        <!--    <div class="input-group">-->
                        <!--        <input type="text" class="form-control" name="country" id="country" value="<?= @$_SESSION['register']['country'] ?>" placeholder="Input Your Country">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="form-group after-add-more">
                            <label for="InputAddress">Kewarganegaraan</label>
                            <span class="text-warning">*</span>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="isWNA1" name="isWNA" value="0">
                                <label class="form-check-label" for="isWNA">
                                    WNI
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" id="isWNA2" name="isWNA" value="1">
                                <label class="form-check-label" for="isWNA2">
                                   WNA
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label>Asal <span class='text-info'>(Optional)</span></label>
                            <div class="input-group">   
                                            <input type="text" class="form-control" name="country" id="country1" placeholder="Input Your Country">
                                            <div id="country2" style="display: none; width:580px;">
                                                <select class="select2bs4 form-control form-control-sm" name="country" placeholder="Country">
                                                    <option value="">Country</option>
                                                    <?php
                                                    $query = "SELECT * FROM master_countries";
                                                    $fetch = mysqli_query($conn, $query);
                                                    while ($result = mysqli_fetch_array($fetch)) { ?>
                                                        <option value="<?= $result['country_name'] ?>"><?= $result['country_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                            </div>
                        </div>
                        
                        <!-- nik field -->
                        <div class="form-group mt-4">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= @$_SESSION['register']['nik'] ?>" placeholder="Identity Number" maxlength="16">
                        </div>
                        
                        <!-- passport field -->
                        <div class="form-group">
                            <label>Passport <span class='text-info'>(Optional)</span></label>
                            <div class="input-group mb-3">
                             <input type="text" class="form-control" name="passport" id="passport" value="<?= @$_SESSION['register']['passport'] ?>" placeholder="Input Your Passport">
                         </div>
                         
                        <!-- email fields -->
                        <div class="form-group">
                            <label for="InputEmail">Email</label>
                            <span class="text-warning">*</span>
                            <input type="email" class="form-control" name="email" id="email" value="<?= @$_SESSION['register']['email'] ?>" placeholder="Email Address" required>
                        </div>
                        
                        <!-- password fields -->
                        <div class="form-group mt-3">
                            <label for="InputPassword">Password</label>
                            <span class="text-warning">*</span>
                            <div class="input-group">
                                <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password" required>
                                <span type="button" class="input-group-text"><span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password"></span></span>
                            </div>
                        </div>
                        
                       <!-- confirm password -->
                        <div class="form-group">
                            <label for="InputPassword">Re-Password</label>
                            <span class="text-warning">*</span>
                            <div class="input-group">
                                <input type="password" class="form-control" id="InputRePassword" placeholder="Confirm Password" name="confirm_password" required>
                                <span type="button" class="input-group-text"> <span toggle="#password-field" class=" fa fa-fw fa-eye-slash field_icon toggle-password2"></span></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="background-color: #4aba70; border: 1px solid #4aba70"><i class="fa fa-check" aria-hidden="true"></i> Register</button>
                        <div class="form-footer mt-2 mb-4">
                            <p> Sudah memiliki akun? <a href="<?= BASE_URL ?>">Masuk Sekarang</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </div>

    <!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, danyang terakhit Bootstrap JS -->
    <!--  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script src="datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(function () {
                $('#placeofbirth').datepicker({
                    format: 'dd-mm-yyyy'
                });
            });
    </script> -->

    <!-- jQuery -->
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script> -->
    <!-- Bootstrap 4 -->
    <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select 2 -->
    <script src="admin/plugins/select2/js/select2.full.min.js"></script>
    <!-- Sparkline -->
    <script src="admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    
    <!--<script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
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
        
        $(document).ready(function () {
            $("#isWNA1").change(function() {
                var determineCountry = $("#isWNA1").val();
                //var country = $("#country1").val("Indonesia");
                if (determineCountry == "0") {
                    //$("#country1").show();
                    $("#country1").val("Indonesia").show();
                    $("#country2").hide();
                    // $('select[name="country"] option[value=Indonesia]').prop("selected",true);
                    //$('select[id="country"] option[value="Indonesia"]').attr("selected","selected");
                    // $("#country").select2({disabled:'readonly'});
                } 
            });
            $("#isWNA2").change(function() {
                var determineCountry = $("#isWNA2").val();
                //var country = $("#country1").val("Indonesia");
                if (determineCountry == "1") {
                    $("#country1").hide();
                    $("#country2").val("").trigger('change').show();
                }       
            });
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
            width: 'null',
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
    </script>

</body>

</html>