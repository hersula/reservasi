<?php
$date = date('ymdmis');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Barcode_Sample_".$date.".xls");
?>
<?php

include('../../connection.php');
session_start();
$email = $_SESSION['email'];

$sql = "SELECT master_outlet.id, master_karyawan.name name_karyawan, master_karyawan.email email_karyawan, master_karyawan.status, 
master_roles.roleName, master_outlet.name name_outlet, master_outlet.address FROM karyawan_role_list JOIN master_karyawan on karyawan_role_list.karyawanID = master_karyawan.id JOIN master_roles on karyawan_role_list.rolesID = master_roles.id 
JOIN master_outlet on master_outlet.id = master_karyawan.outletID where master_karyawan.email ='$email'";

$result = mysqli_fetch_array(mysqli_query($conn, $sql));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mt-3">
                                    <?= $result['name_outlet'] ?>
                                </h4>
                                <h6><?= $result['address'] ?></h6>
                            </div>
                            <!-- /.col -->
                        </div>

                        <!-- Table row -->
                        <div class="row mt-4">
                            <div class=" col-12 table-responsive">
                                <table class="table table-bordered" border="1">
                                    <thead>
                                        <tr>
                                            <th>No Urut</th>
                                            <th>Barcode Lab</th>
                                            <th>Nama Pasien</th>
                                            <th>Tindakan</th>
                                            <th>Time Barcode Lab</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('../../connection.php');
                                        $no = 1;
                                        $query = "SELECT transaksi_rawat_jalan.barcodeLab, master_pasien.name,
                                master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime FROM `transaksi_rawat_jalan` 
                                join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.barcodeLab='Belum dibarcode' and master_tindakan.typeTindakan = 'PCR' order by transaksi_rawat_jalan.id desc";
                                        $fetch = mysqli_query($conn, $query);
                                        $no = 1;
                                        while ($result = mysqli_fetch_array($fetch)) { ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $result['barcodeLab'] ?></td>
                                                <td><?= $result['name'] ?></td>
                                                <td><?= $result['name_tindakan'] ?></td>
                                                <td><?= $result['barcodeLabTime'] ?></td>
                                            </tr>

                                        <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>