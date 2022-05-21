<?php

$nik = $_SESSION['nik'];
$query = mysqli_query($conn, "select * from temp_cart where nik='$nik' && registerTo='Sendiri'");
$fetchSendiri = mysqli_num_rows($query);

$orangLain = mysqli_query($conn, "select * from temp_cart where nik='$nik' && registerTo='Orang Lain'");
$fetchOrangLain = mysqli_num_rows($query);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pilihan Pendaftaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Registration For</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mendaftarkan Untuk ?</h3>
        </div>
        <div class="card-body col-md-6">
            <a type="button" href="../main/index.php?page=epidemiologi&toRegister=Sendiri" class="btn <?php if ($fetchSendiri == 1) {
                                                                                                            echo 'btn-secondary disabled';
                                                                                                        } else {
                                                                                                            echo 'btn-info';
                                                                                                        } ?> btn-block">Sendiri</a>
            <a type="button" href="../main/index.php?page=reservation&toRegister=Orang Lain" class="btn btn-info btn-block">Orang Lain</a>
        </div>
        <?php

        // if ($fetchSendiri == 1 && $fetchOrangLain == 1) {
        //     # code...
        //     echo '<div class="card-footer">
        //     <p class=" text-danger text-sm">*Mohon maaf, kamu sudah mendaftarkan diri dan orang lain! Silahkan lanjutkan transaksi kamu  <strong><a href="index.php?page=cart" class="text-danger">Disini</a></strong></p>
        // </div>';
        // }

        ?>
    </div>