<?php

include('../connection.php');
include('../helper/base_url.php');
session_start();

$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
$pasienID = isset($_GET['noPasien']) ? $_GET['noPasien'] : '';

$auth    = isset($_POST['auth']) ? $_POST['auth'] : '';
$sess_error = isset($_SESSION['authfailed']) ? $_SESSION['authfailed'] : '';
if ($auth != '') {
    # code...

    $query = $conn->query("select dateOfBirth from master_pasien where id='$pasienID'") or die($conn->error);

    // var_dump($query);
    $fetch = $query->fetch_array();
    $tglLahir = $fetch['dateOfBirth'];
    $dates = strtotime($tglLahir);
    $newFormat = date('dm', $dates);

    if ($auth == $newFormat) {
        # code...
        unset($sess_error);
        $_SESSION['idpasienauth'] = $pasienID;
        header('Location: ' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $idTransaction . '&noPasien=' . $pasienID . '');
    } else {
        $_SESSION['authfailed'] = 'invalid';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Autentikasi LHU</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">

        <!-- The Modal -->
        <div class="modal fade" id="modalku">
            <div class="modal-dialog">
                <form action="" method="POST">
                    <div class="modal-content">

                        <!-- Ini adalah Bagian Header Modal -->
                        <div class="modal-header">
                            <h5 class="modal-title">Masukkan tanggal lahir anda (DDMM)</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Ini adalah Bagian Body Modal -->
                        <div class="modal-body">
                            <?php
                            $sess_error = isset($_SESSION['authfailed']) ? $_SESSION['authfailed'] : '';
                            if ($sess_error == 'invalid') {
                                # code...
                                echo '<div class="alert alert-danger" role="alert">
                                        Maaf, data tidak sesuai ! Silahkan coba lagi !
                                        </div>';
                            } ?>

                            <input type="text" class="form-control" placeholder="Contoh: 3112" maxlength="4" autofocus name="auth" required>
                            <small style="font-style: italic;">* Format, 2 angka tanggal dan 2 angka bulan jadi satu</small>
                        </div>

                        <!-- Ini adalah Bagian Footer Modal -->
                        <div class="modal-footer">
                            <a type="button" class="btn btn-danger" href="<?= BASE_URL; ?>">Close</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#modalku').modal({
                show: true,
                backdrop: 'static',
            });
        });
    </script>

</body>

</html>