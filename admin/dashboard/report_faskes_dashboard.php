<?php

function directAdmin()
{
    echo '<script>window.location = "admin.php"</script>';
    // return false;
}
$status = $_GET['status'];
$outletID = $_SESSION['outletID'];
$queryGetFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outlet_id'");
$isFaskes       = $queryGetFaskes->fetch_array();

$arrayRoleName = $_SESSION['rolesName'];

if (!$isFaskes['isFaskes'] == '1') {
    directAdmin();
}

$date_filter = "";
$date = date('Y-m-d');


if (isset($_POST['submit'])) {
    # code...
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
}

var_dump($arrayRoleName);
?>

<section class="content">
    <div class="container-fluid">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <h1 class="m-0">Laporan Tindakan dengan Status <b><?= $_GET['status'] ?></b></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
                                <li class="breadcrumb-item active">Status Report</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row justify-content-between">
                            <div class="col-xs-4">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control form-control-sm"
                                        placeholder="Input outlet name" aria-label="Recipient's username"
                                        aria-describedby="button-addon2" name="date_filter"
                                        value="<?= $_POST['date_filter'] ?>">
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit"
                                        id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="table-responsive">
                        <table id="dataReportDashboard" class="table table-striped text-xs text-center">
                            <thead>
                                <tr>
                                    <th>Id Transaction</th>
                                    <th>NIK/Passport</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal lahir</th>
                                    <th>Nama Tindakan</th>
                                    <th>Nama Outlet</th>
                                    <th>Tanggal Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date_filter_now = '%' . $date_filter . '%';


                                if ($date_filter == '') {
                                    $query = $conn->query("SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, master_pasien.nik,master_pasien.dateOfBirth, master_pasien.name name_pasien, master_pasien.passport, master_tindakan.name name_tindakan, master_outlet.name name_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id
                                JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE transaksi_rawat_jalan.status='$status' AND transaksi_rawat_jalan.outletID='$outletID' 
                                AND transaksi_rawat_jalan.tglTindakan = '$date' order by id desc") or die($conn->error);
                                } else {
                                    $query = $conn->query("SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, master_pasien.nik,master_pasien.dateOfBirth, master_pasien.name name_pasien, master_pasien.passport, master_pasien.name name_pasien, master_tindakan.name name_tindakan, master_outlet.name name_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id
                                JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE transaksi_rawat_jalan.status='$status' AND transaksi_rawat_jalan.outletID='$outletID' 
                                AND transaksi_rawat_jalan.tglTindakan like '$date_filter_now' order by id desc") or die($conn->error);
                                }

                                while ($result = $query->fetch_array()) { ?>

                                <tr>
                                    <td><?= $result['transaksiID'] ?></td>
                                    <td>
                                        <?php if ($result['nik'] == '') {
                                                echo $result['passport'];
                                            } else {
                                                echo $result['nik'];
                                            } ?>
                                    </td>
                                    <td><?= $result['name_pasien'] ?></td>
                                    <td><?= $result['dateOfBirth'] ?></td>
                                    <td><?= $result['name_tindakan'] ?></td>
                                    <td><?= $result['name_outlet'] ?></td>
                                    <td><?= $result['tglTindakan'] ?></td>
                                </tr>

                                <?php   } ?>

                            </tbody>
                            <tfooter>
                                <td colspan="6">
                                    <center><label style="visibility: hidden;">&nbsp;</label></center>
                                </td>
                                <td class="text-left" style="font-weight:bold;">

                                </td>

                            </tfooter>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

            <!--/.row -->
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-0 pb-4">Laporan Transaksi Pembayaran</h3>
                            <div class="table-responsive">
                                <table id="dataLaporanPembayaran" class="table table-bordered table-striped text-xs">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Jumlah Jenis Pembayaran</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $no = 1;
                                        $query_pembayaran = get_group_pembayaran($conn, $status, $outletID, $date_filter, $date);
                                        while ($result = $query_pembayaran->fetch_array()) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $result['nama_payment'] ?></td>
                                            <td class="text-center"><?= $result['totalPayment'] ?></td>
                                            
                                        </tr>
                                        <?php }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col -->
            </div>
        </div>
</section>

<?php

function get_sum_price($conn, $status, $outletID, $date_filter, $date)
{
    if ($date_filter == "") {
        $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE status='$status' AND outletID='$outletID' AND tglTindakan = '$date'");
    } else {
        $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE status='$status' AND outletID='$outletID' AND tglTindakan like '%$date_filter%'");
    }
    $fetch = $query->fetch_array();
    $total = $fetch['total'];
    return $total;
}

function get_group_pembayaran($connection, $status, $outletID, $date_filter, $date)
{

    if ($date_filter == "") {
        $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal) as grandTotal 
        FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id 
        WHERE transaksi_rawat_jalan.status='$status' AND transaksi_rawat_jalan.outletID='$outletID' AND transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY master_payment.namePayment") or die($conn->error);
    } else {
        $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal) as grandTotal 
        FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id 
        WHERE transaksi_rawat_jalan.status='$status' AND transaksi_rawat_jalan.outletID='$outletID' AND transaksi_rawat_jalan.tglTindakan like '%$date_filter%' GROUP BY master_payment.namePayment") or die($conn->error);
    }

    return $query;
}

?>