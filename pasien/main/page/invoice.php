<?php

$invoice = '';
if (isset($_GET['invoice_id'])) {
    # code...
    $invoice = $_GET['invoice_id'];
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoice</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                $nik = $_SESSION['nik'];
                $query = "SELECT master_pasien.name as name_pasien, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.transaksiID, master_tindakan.name as name_tindakan, master_outlet.name as name_outlet, transaksi_rawat_jalan.price, transaksi_rawat_jalan.paymentType, transaksi_rawat_jalan.status, 
                transaksi_rawat_jalan.createdAt, transaksi_rawat_jalan.id id_uniq_trx FROM transaksi_rawat_jalan JOIN master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id 
                JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND transaksi_rawat_jalan.nikAccount = '$nik' && transaksi_rawat_jalan.transaksiID = '$invoice'";
                $fetch = mysqli_query($conn, $query) or die($conn->error);
                $no = 1;

                if (mysqli_num_rows($fetch) > 0) { ?>
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <?php $querys = mysqli_query($conn, "select createdAt, paymentURL, paymentType, status from transaksi_rawat_jalan where NOT transaksi_rawat_jalan.status = 'Failed' AND transaksiID='$invoice'");
                                        $fetchCreatedAt = mysqli_fetch_array($querys); ?>
                                        <img src="/norbu-medika/images/LogoNorbuMedika.png" alt="" style="width: 26px; margin-right: 10px;"> Norbu Medika
                                        <small class="float-right"><?= $fetchCreatedAt['createdAt'] ?><button type="button" disabled class="btn <?php if ($fetchCreatedAt['status'] == 'Open') {
                                                                                                                                                    # code...
                                                                                                                                                    echo 'btn-primary';
                                                                                                                                                } else if ($fetchCreatedAt['status'] == 'Paid') {
                                                                                                                                                    # code...
                                                                                                                                                    echo 'btn-success';
                                                                                                                                                } else if ($fetchCreatedAt['status'] == 'Pending' || $fetchCreatedAt['status'] == 'On Process' ) {
                                                                                                                                                    # code...
                                                                                                                                                    echo 'btn-warning';
                                                                                                                                                } else {
                                                                                                                                                    echo 'btn-danger';
                                                                                                                                                }
                                                                                                                                                ?> btn-sm ml-3"><?= $fetchCreatedAt['status'] ?></button> </small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>

                            <!-- Table row -->
                            <div class="row mt-3">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered table-striped text-xs" >
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pasien</th>
                                                <th>Nama Tindakan</th>
                                                <th>Nama Outlet</th>
                                                <th>Price</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <?php while ($result = mysqli_fetch_array($fetch)) { ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $result['name_pasien'] ?></td>
                                                    <td><?= $result['name_tindakan'] ?></td>
                                                    <td><?= $result['name_outlet'] ?></td>
                                                    <td>IDR <?= number_format($result['price']) ?></td>
                                                    <td><?php if ($result['status'] == 'Open') { ?>
                                                            <a href='../main/page/canceled_single_tindakan.php?id=<?= $result['id_uniq_trx'] ?>' class="btn btn-xs btn-danger" onclick="var r = confirm('Apakah tindakan ini ingin dibatalkan ?'); if (r == true){return true;} else {event.preventDefault; return false;}">Batal</a>
                                                        <?php } else if ($result['status'] == 'Close') { 
                                                            echo '<a href="'.BASE_URL. 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] . '&noPasien=' . $result['pasienID'] . '" target="blank" class="btn btn-info btn-xs" title="Lihat Detail"><i class="fa fa-eye fa-sm" aria-hidden="true"></i></a>';
                                                         } else {
                                                        echo '<p class="text-danger text-xs text-bold">X</p>';
                                                        } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php $no++;
                                        } ?>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row mt-5">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <div class="col-6">
                                        <?php if($fetchCreatedAt['status'] == 'Open' && $querys->num_rows > 1) {?> 
                                            <a href='../main/page/canceled_all_tindakan.php?idTransaction=<?= $invoice ?>' class="btn btn-sm btn-danger" onclick="var r = confirm('Apakah tindakan ini ingin dibatalkan ?'); if (r == true){return true;} else {event.preventDefault; return false;}">Batalkan Semua Tindakan</a>
                                        <?php } ?>
                                
                                </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <?php
                                    $query_count = mysqli_query($conn, "select sum(price) as total from transaksi_rawat_jalan where transaksiID='$invoice' AND not status ='Failed'");
                                    $fetchTotal = mysqli_fetch_array($query_count);

                                    ?>


                                    <div class="float-right mb-2">
                                        <table class="table">
                                            <tr class="lead">
                                                <th style="width:50%">Total:</th>
                                                <td><b class="float-right">IDR <?= number_format($fetchTotal['total']) ?></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <!-- <button rel="noopener" target="_blank" class="btn btn-default" onclick="window.print()"><i class="fas fa-print"></i> Print</button> -->
                                    <?php
                                    if ($fetchCreatedAt['status'] == 'Open' && $fetchCreatedAt['paymentType'] != '1') { ?>
                        
                                        <button type="button" id="pay-button" class="btn btn-success float-right"><i class="far fa-credit-card fa-sm mr-2"></i> Lanjutkan Pembayaran</button>
                        <?php } else if ($fetchCreatedAt['status'] == 'Pending' && $fetchCreatedAt['paymentType'] != '1') { ?>
                            <button type="button" id="pay-button" class="btn btn-success float-right"><i class="far fa-credit-card fa-sm mr-2"></i> Lanjutkan Pembayaran</button>
                        <?php }?>
                                    <!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div>
                <?php }
                ?>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('<?= $fetchCreatedAt['paymentURL'] ?>')
            // customer will be redirected after completing payment pop-up
        });
    </script>