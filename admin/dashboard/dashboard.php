<?php
$isFaskes = $_SESSION['isFaskes'];
$date = date('Y-m-d');

$outletID = $_SESSION['outletID'];

if (isset($_POST['submit'])) {
        # code...
    $outlet_selected = isset($_POST['selected_outlet']) ? $_POST['selected_outlet'] : '';
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
    $date_filter2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';

} else {
    $outlet_selected = 0;
    $date_filter = date('Y-m-d');
    $date_filter2 = date('Y-m-d');
}

$access_control = '';
//var_dump(in_array("Superadmin", $arrayRoleName));

if (in_array("Superadmin", $arrayRoleName) || in_array("Accounting", $arrayRoleName)) {
    $access_control = 'Tampil';
  } else {
    $access_control = '';
  }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Main Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <?php
                        
                        $sql = "select count(*) as jml_trx_open, status from transaksi_rawat_jalan where status='Open' and outletID='$outletID' and tglTindakan = '$date'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="inner">
                                <h3><?php echo $row["jml_trx_open"]; ?></h3>
                                <p>Open</p>
                            </div>
                        <?php
                        }

                        ?>
                        <div class="icon">
                            <i class="ion-ios-cart-outline"></i>
                        </div>

                        <?php
                        if ($isFaskes == 1) { ?>
                            <a href="../admin/admin.php?page=report-faskes-dashboard&status=<?php if ($row['status'] == '') {echo 'Open';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            <!--
                            <a href="" class="small-box-footer"><i class="fas fa-ban"></i>
                            </a>
                            -->
                        <?php } else { ?>
                            <a href="../admin/admin.php?page=report-dashboard&status=<?php if ($row['status'] == '') {echo 'Open';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <?php
                        $sql = "select count(*) as jml_trx_paid, status from transaksi_rawat_jalan where status='Paid' and outletID='$outletID' and tglTindakan = '$date'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="inner">
                                <h3>
                                    <?php echo $row["jml_trx_paid"]; ?>
                                </h3>
                                <p>Paid</p>
                            </div>
                        <?php
                        }

                        ?>
                        <div class="icon">
                            <i class="ion-cash"></i>
                        </div>
                        <?php
                        if ($isFaskes == 1) { ?>
                            <!--
                            <a href="" class="small-box-footer"><i class="fas fa-ban"></i>
                            </a>
                            -->
                            <a href="../admin/admin.php?page=report-faskes-dashboard&status=<?php if ($row['status'] == '') {echo 'Paid';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } else { ?>
                            <a href="../admin/admin.php?page=report-dashboard&status=<?php if ($row['status'] == '') {echo 'Paid';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <?php
                        $sql = "select count(*) as jml_trx_close, status from transaksi_rawat_jalan where status='On Process' and outletID='$outletID' and tglTindakan = '$date'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="inner">
                                <h3><?php echo $row["jml_trx_close"]; ?></h3>

                                <p>On Process</p>
                            </div>
                        <?php
                        }

                        ?>
                        <div class="icon">
                            <i class="ion-ios-checkmark"></i>
                        </div>
                        <?php
                        if ($isFaskes == 1) { ?>
                            <!--
                            <a href="" class="small-box-footer"><i class="fas fa-ban"></i>
                            </a>
                            -->
                            <a href="../admin/admin.php?page=report-faskes-dashboard&status=<?php if ($row['status'] == '') {echo 'On Process';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } else { ?>
                            <a href="../admin/admin.php?page=report-dashboard&status=<?php if ($row['status'] == '') {echo 'On Process';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <?php
                        $sql = "select count(*) as jml_trx_fail, status from transaksi_rawat_jalan where status='Close' and outletID='$outletID' and tglTindakan = '$date'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                        ?>
                            <div class="inner">
                                <h3><?php echo $row["jml_trx_fail"]; ?></h3>
                                <p>Close</p>
                            </div>
                        <?php
                        }

                        ?>
                        <div class="icon">
                            <i class="ion-android-remove-circle"></i>
                        </div>
                        <?php
                        if ($isFaskes == 1) { ?>
                            <!--
                            <a href="" class="small-box-footer"><i class="fas fa-ban"></i>
                            </a>
                            -->
                            <a href="../admin/admin.php?page=report-faskes-dashboard&status=<?php if ($row['status'] == '') {echo 'Close';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } else { ?>
                            <a href="../admin/admin.php?page=report-dashboard&status=<?php if ($row['status'] == '') {echo 'Close';} else {echo $row['status'];} ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

        <?php
            if (!empty($access_control)) {
        ?>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="m-0 pb-4">Laporan Transaksi <?= get_name_outlet($outlet_selected, $conn) ?></h3>
                        <form action="" method="POST">
                                <div class="row pb-4 pl-2">
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control form-control-sm mr-3" value='<?= $date_filter ?>' name="date_filter" >
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control form-control-sm mr-3" value='<?= $date_filter2 ?>' name="date_filter2" >
                                        </div>
                                    </div>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <select name="selected_outlet" id="selected_outlet" class="custom-select custom-select-sm mr-3">
                                            <option value="">Pilih Outlet</option>
                                            <option value="0" <?php
                                              if($outlet_selected == '0'){
                                                echo "selected";
                                              } ?> >Semua Outlet</option>
                                                        <?php
                                            $queryOutlet = $conn->query("SELECT * FROM master_outlet WHERE status='Aktif'");
                                            while ($fetchOutlet = $queryOutlet->fetch_array()) { ?>
                                                <option value="<?= $fetchOutlet['id'] ?>" <?php
                                              if($fetchOutlet["id"] == $outlet_selected){
                                                echo "selected";
                                              } ?>><?= $fetchOutlet['name'] ?></option>
                                                        <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-xs-6">
                                    <div class="input-group">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="dataLaporanTindakan" class="table table-bordered table-striped text-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Jenis Tindakan</th>
                                        <th>Nama Outlet</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal Tindakan</th>
                                        <th>Status</th>
                                        <th>Harga Satuan</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                        
                                       if($date_filter != '' && $date_filter2 != ''){
                                        if($outlet_selected == '' || $outlet_selected == '0') {
                                            $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'  ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        } else {
                                            $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        }
                                       }else {
                                        if($outlet_selected == '' || $outlet_selected == '0') {
                                            $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan= '$date'  ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        } else {
                                            $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan= '$date' ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        }
                                       }
                                        
                                        // if ($outlet_selected == '' || $outlet_selected == '0' && $date_filter == '') {
                                        //     $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        // transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        // transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed'  ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        // } else if ($date_filter == '') {
                                        //     $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        // transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        // transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        // } else if ($date_filter != '' && $outlet_selected == '0') {
                                        //     $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        // transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        // transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan LIKE '$date_filter' ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        // } else {
                                        //     $queryDefault = $conn->query("SELECT master_pasien.name name_pasien, master_tindakan.name jenis_tindakan, master_outlet.name nama_outlet, master_payment.namePayment, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.status, 
                                        // transaksi_rawat_jalan.price, transaksi_rawat_jalan.totalDisc, transaksi_rawat_jalan.Tax, transaksi_rawat_jalan.grandTotal FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON 
                                        // transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' ORDER BY transaksi_rawat_jalan.tglTindakan DESC");
                                        // }
                                        
                                        while($result = $queryDefault->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $result['name_pasien'] ?></td>
                                                <td><?= $result['jenis_tindakan'] ?></td>
                                                <td><?= $result['nama_outlet'] ?></td>
                                                <td><?= $result['namePayment'] ?></td>
                                                <td><?= $result['tglTindakan'] ?></td>
                                                <td><?= $result['status'] ?></td>
                                                <td class="text-right"><?= number_format($result['price']) ?></td>
                                                <td class="text-right"><?= number_format($result['totalDisc']) ?></td>
                                                <td class="text-right"><?= $result['Tax'] . '%' ?></td>
                                                <td class="text-right"><?= number_format($result['grandTotal']) ?></td>
                                            </tr>
                                    <?php    }
                                        
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9"><center><label style="visibility: hidden;">&nbsp;</label></center></td>
                                        <td style="font-weight:bold;"><center>TOTAL</center></td>
                                        <td class="text-right"><h6><?= number_format(get_sum_price($conn, $outlet_selected, $date_filter, $date_filter2, $date)); ?></h6></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
              </div>
               <!--/.col -->
            </div>
             <!--/.row -->
             <div class="row">
              <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="m-0 pb-4">Laporan Transaksi Tindakan <?= get_name_outlet($outlet_selected, $conn) ?></h3>
                        <div class="table-responsive">
                            <table id="dataLaporanTindakanNew" class="table table-bordered table-striped text-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Tindakan</th>
                                        <th>Jumlah Tindakan</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                        $no = 1;
                                        $query_tindakan = get_group_tindakan($conn, $outlet_selected, $date_filter, $date_filter2, $date);
                                        while($result = $query_tindakan->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $result['nama_tindakan'] ?></td>
                                                <td><?= $result['totalTindakan'] ?></td>
                                                <td class="text-right">Rp <?= number_format($result['totalPrice']) ?></td>
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
             <!--/.row -->

             <!--/.row -->
             <div class="row">

              <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="m-0 pb-4">Laporan Transaksi Pembayaran <?= get_name_outlet($outlet_selected, $conn) ?></h3>
                        <div class="table-responsive">
                            <table id="dataLaporanPembayaran" class="table table-bordered table-striped text-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                        $no = 1;
                                        $query_pembayaran = get_group_pembayaran($conn, $outlet_selected, $date_filter, $date_filter2, $date) or die($conn->error);
                                        while($result = $query_pembayaran->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $result['nama_payment'] ?></td>
                                                <td><?= $result['totalPayment'] ?></td>
                                                <td class="text-right">Rp <?= number_format($result['totalPrice']) ?></td>
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

               <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="m-0 pb-4">Laporan Transaksi Status <?= get_name_outlet($outlet_selected, $conn) ?></h3>
                        <div class="table-responsive">
                            <table id="dataLaporanStatus" class="table table-bordered table-striped text-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Status</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                        $no = 1;
                                        $query_status = get_group_status($conn, $outlet_selected, $date_filter, $date_filter2, $date);
                                        while($result = $query_status->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $result['nama_status'] ?></td>
                                                <td><?= $result['totalStatus'] ?></td>
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
             <!--/.row -->
        <?php
            }
        ?>

        </div><!-- /.container-fluid -->
    </section>
    
    
    <?php 
    function get_sum_price($conn, $outlet_selected, $date_filter, $date_filter2, $date)
    {
        
        if($date_filter != '' && $date_filter2 != ''){
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'");
            } else {
                $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'");
            }
           }else {
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND transaksi_rawat_jalan.tglTindakan = '$date'");
            } else {
                $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan = '$date'");
            }
           }
        
        // if( $outlet_selected == '' || $outlet_selected == '0' && $date_filter == '') {
        //     $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed'");
        // } else if ($date_filter == '') {
        //     $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND outletID LIKE '$outlet_selected'");
        // } else if ($date_filter != '' && $outlet_selected == '0') {
        //     $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND tglTindakan LIKE '%$date_filter%'");
        // } else {
        //     $query = $conn->query("SELECT SUM(grandTotal) as total FROM transaksi_rawat_jalan WHERE NOT status ='Failed' AND outletID = '$outlet_selected' AND tglTindakan LIKE '%$date_filter%'");
        // }
         
        $fetch = $query->fetch_array();
        $total = $fetch['total'];
        return $total;
    }
    
    function get_group_tindakan($connection, $outlet_selected, $date_filter, $date_filter2, $date) {
        
        if($date_filter != '' && $date_filter2 != ''){
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice 
                FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
                WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' GROUP BY master_tindakan.name");
            } else {
                $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice 
                FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
                WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' GROUP BY master_tindakan.name");
            }
           }else {
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice 
                FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
                WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY master_tindakan.name");
            } else {
                $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice 
                FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
                WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY master_tindakan.name");
           }
         }
        
        // if( $outlet_selected == '' || $outlet_selected == '0' && $date_filter == '') {
        //     $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE NOT transaksi_rawat_jalan.status ='Failed' GROUP BY master_tindakan.name");
        // }  else if ($date_filter == '') { 
        //     $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID LIKE '$outlet_selected' GROUP BY master_tindakan.name");
        // } else if ($date_filter != '' && $outlet_selected == '0') {
        //     $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY master_tindakan.name");
        // } else {
        //     $query = $connection->query("SELECT COUNT(master_tindakan.name ) as totalTindakan, master_tindakan.name as nama_tindakan, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice FROM transaksi_rawat_jalan JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY master_tindakan.name");
        // }
        return $query;
    }

    function get_group_pembayaran($connection, $outlet_selected, $date_filter, $date_filter2, $date) {
        
        if($date_filter != '' && $date_filter2 != ''){
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice  
                FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' 
                AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' GROUP BY master_payment.namePayment");
            } else {
                $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice  
                FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id 
                WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'
                GROUP BY master_payment.namePayment");
             }
           }else {
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice  
                FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' 
                AND transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY master_payment.namePayment");
            } else {
                $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment, SUM(transaksi_rawat_jalan.grandTotal ) as totalPrice  
                FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' 
                AND transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY master_payment.namePayment");
            }
         }
        
        // if( $outlet_selected == '' || $outlet_selected == '0' && $date_filter == '') {
        //     $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' GROUP BY master_payment.namePayment");
        // }  else if ($date_filter == '') { 
        //     $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID LIKE '$outlet_selected' GROUP BY master_payment.namePayment");
        // } else if ($date_filter != '' && $outlet_selected == '0') {
        //     $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY master_payment.namePayment");
        // } else {
        //     $query = $connection->query("SELECT COUNT(master_payment.namePayment ) as totalPayment, master_payment.namePayment as nama_payment FROM transaksi_rawat_jalan JOIN master_payment ON transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY master_payment.namePayment");
        // }
        return $query;
    }

    function get_group_status($connection, $outlet_selected, $date_filter, $date_filter2, $date) {
        
        if($date_filter != '' && $date_filter2 != ''){
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status 
                FROM transaksi_rawat_jalan WHERE transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'  GROUP BY transaksi_rawat_jalan.status");
            } else {
                $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan 
                WHERE transaksi_rawat_jalan.outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' GROUP BY transaksi_rawat_jalan.status");
             }
           }else {
            if($outlet_selected == '' || $outlet_selected == '0') {
                $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status 
                FROM transaksi_rawat_jalan WHERE transaksi_rawat_jalan.tglTindakan = '$date' GROUP BY transaksi_rawat_jalan.status");
            } else {
                $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan 
                WHERE transaksi_rawat_jalan.outletID LIKE '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan ='$date' GROUP BY transaksi_rawat_jalan.status");
            }
         }
        
        // if( $outlet_selected == '' || $outlet_selected == '0' && $date_filter == '') {
        //     $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan GROUP BY transaksi_rawat_jalan.status");
        // }  else if ($date_filter == '') { 
        //     $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan WHERE transaksi_rawat_jalan.outletID LIKE '$outlet_selected' GROUP BY transaksi_rawat_jalan.status");
        // } else if ($date_filter != '' && $outlet_selected == '0') {
        //     $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan WHERE transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY transaksi_rawat_jalan.status");
        // } else {
        //     $query = $connection->query("SELECT COUNT(transaksi_rawat_jalan.status ) as totalStatus, transaksi_rawat_jalan.status as nama_status FROM transaksi_rawat_jalan WHERE transaksi_rawat_jalan.outletID = '$outlet_selected' AND transaksi_rawat_jalan.tglTindakan LIKE '%$date_filter%' GROUP BY transaksi_rawat_jalan.status");
        // }
        return $query;
    }
    
    function get_name_outlet($id, $conn) {
        $name_outlet = '';
        if ($id == '' || $id == '0') {
           return $name_outlet = 'Semua Outlet';
        } else {
            $query = $conn->query("SELECT name FROM master_outlet WHERE id='$id'");
            $fetch = $query->fetch_array();
            $name_outlet = $fetch['name'];
            return $name_outlet;
        }
    }
    
    
    ?>
    
    
    
    
    
    
    
    