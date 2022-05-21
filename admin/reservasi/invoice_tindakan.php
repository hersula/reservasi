<?php

include('../../connection.php');

$idTransaction  = $_GET['idTransaction'];
$pasienID       = $_GET['idPasien'];

$query = $conn->query("SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.price, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, master_payment.namePayment, transaksi_rawat_jalan.createdAt, master_pasien.name, master_pasien.phone, master_outlet.name name_outlet, master_tindakan.name name_tindakan FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' AND transaksi_rawat_jalan.pasienID='$pasienID'");
$fetch = $query->fetch_array();

$price      = $fetch['price'];
$Tax        = $fetch['Tax'];
$totalDisc  = $fetch['totalDisc'];
$grandTotal = $fetch['grandTotal'];

$totalTax   = (int)$price * ((int)$Tax/100);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <style>
        @media print 
        {
            .margin-paper{
                 margin: 2cm 2cm 2cm 2cm;
            }
           @page
           {
            size: A5 landscape;
            margin: auto;
          }
        }
    </style>
</head>

<body>
    <div class="wrapper mt-4 margin-paper">
        <!-- Main content -->
            <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-8">
                    <h4 class="page-header">
                        <img src="../../images/LogoNorbuMedika.png" width="80" alt=""><br><br>
                        LABORATORIUM KHUSUS<br>
                        Jl. Pluit Permai Raya Mall Pluit Village No 30
                    </h4>
                </div>
                <div class="col-4">
                    <h5 class="float-right">
                        <?= $fetch['transaksiID'] ?>
                        <br>
                        <?= $fetch['createdAt'] ?>
                    </h5>
                </div>
                <!-- /.col -->
            </div>
            <br>
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Nama Tindakan</th>
                                <th>Nama Outlet</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?= $fetch['name'] ?></td>
                                <td><?= $fetch['name_tindakan'] ?></td>
                                <td><?= $fetch['name_outlet'] ?></td>
                                <td class="text-right">Rp <?= number_format($price) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <br>
            <div class="row">
                <!-- accepted payments column -->
                <div class="col-4">
                    <p class="lead">Payment Methods:</p>

                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                        <button type="button" id="pay-button" class="btn btn-default" disabled><i class="far fa-credit-card fa-sm mr-2"></i> <?= $fetch['namePayment'] ?>
                        </button>

                    </p>
                </div>
                <!-- /.col -->
               <div class="col-4">
                    <p class="lead">
                       <img src="../../images/Stempel_Lab_Norbu.png" width="120" height="120" alt="">
                    </p>
                </div>
                <div class="col-4">
                    <table class="table text-right">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>Rp <?= number_format($price) ?></td>
                        </tr>
                        <tr>
                            <th>Tax:</th>
                            <td>Rp <?= number_format($totalTax) ?></td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td class="text-danger">- Rp <?= number_format($totalDisc) ?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>Rp <?= number_format($grandTotal) ?></td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        </div>
        <!-- /.content -->
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>