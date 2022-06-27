<?php 

    unset($_SESSION['outletSelected']);

    $date_filter = "";
    
    function directAdmin() {
        echo '<script>window.location = "admin.php"</script>';
    }
    
    $selected_outlet = isset($_POST['select_outlet']) ? $_POST['select_outlet'] : '';
    $select_outlet_periode = isset($_POST['select_outlet_periode']) ? $_POST['select_outlet_periode'] : '';
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
    $date_filter2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';
    
    if ($date_filter > $date_filter2) {
        # code...
        $_SESSION['errorDateMessageAntigen'] = "Maaf tanggal pertama tidak boleh melewati tanggal kedua !";
    } 
    else {
        unset($_SESSION['errorDateMessageAntigen']);
    }
    
    // $outletID = $_SESSION['outletID'];
    // if($selected_outlet != '0') {
    //     if($selected_outlet == '') {
    //     $get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id = '$outletID'");    
    //     } else {
    //     $get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id = '$selected_outlet'");    
    //     }
    //     $fetch_name_outlet = $get_name_outlet->fetch_array();
    //     $name_outlet_is = $fetch_name_outlet['name'];
    // } 
    
    $queryGetFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outlet_id'");
    $isFaskes       = $queryGetFaskes->fetch_array();
    
    $arrayRoleName = $_SESSION['rolesName'];
    
    if($isFaskes['isFaskes'] == '1' || in_array("Faskes", $arrayRoleName)) { 
        directAdmin();
    }
    $karyawanID = $_SESSION['idKaryawan'];
    
    function customDateFormat($dateTimeSample) {
    
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d-m-Y H:i:s', $strtime);
        
        return $formatTimeSample;
    }
    function customDate($dateTimeSample) {
    
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d/m/Y', $strtime);
        
        return $formatTimeSample;
    }
    function customTime($dateTimeSample) {
    
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d/m/Y H:i:s', $strtime);
        
        return $formatTimeSample;
    }
?>
<section class="content">
    <div class="container-fluid">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Riwayat Tindakan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
                                <li class="breadcrumb-item active">History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Riwayat Hari Ini</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Riwayat Periode</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form action="" method="POST">
                        <div class="row ml-1">
                        <div class="col-xs-4">
                        <div class="input-group">
                        <select name="select_outlet" id="select_outlet" class="custom-select custom-select-sm">
                        <option value="">Pilih Outlet</option>
                        <option value="0" <?php
                        if($selected_outlet == '0'){
                        echo "selected";
                        } ?>>Semua Outlet</option>
                        <?php
                        $queryOutlet = $conn->query("SELECT * FROM master_outlet WHERE status='Aktif'");
                        while ($fetchOutlet = $queryOutlet->fetch_array()) { ?>
                        <option value="<?= $fetchOutlet['id'] ?>"<?php
                        if($fetchOutlet['id'] == $selected_outlet){
                        echo "selected";
                        } else if($selected_outlet == '') {
                        if($fetchOutlet['id'] == $outletID){
                        echo "selected";
                        }
                        }?>><?= $fetchOutlet['name'] ?></option>
                        <?php  } ?>
                        </select>
                        </div>
                        </div>
                        <div class="col-xs-4">
                        <div class="input-group">
                        <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                        </div>
                        </div>
                        </div>
                        
                        </form>
                        <div class="table-responsive">
                        <table id="dataRiwayatTindakan" class="table table-bordered table-striped text-xs" style="width:100%">
                        <thead>
                        <tr>
                        <th>No.</th>
                        <th>Transaksi ID</th>
                        <th>NIK/Passport</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Tindakan</th>
                        <th>Tanggal Tindakan</th>
                        <th>Dibuat Pada</th>
                        <th>Nama Outlet</th>
                        <th>Harga</th>
                        <th>Pembayaran</th>
                        <th>Hasil Tes</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $nomor=0;
                        $date_now = date('Y-m-d');
                        $date_filter_now = '%' . $date_filter . '%';
                        // $selected_outlet = isset($_SESSION['outletSelected']) ? $_SESSION['outletSelected'] : '';
                        // if($date_filter != '' && $date_filter2 != '') {
                        //     if($selected_outlet == '') {
                        //     $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                        //     master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_payment.namePayment, master_outlet.name name_outlet, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt FROM `transaksi_rawat_jalan` 
                        //     join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                        //     on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND
                        //     transaksi_rawat_jalan.outletID like '$outletID' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.transaksiID desc  ";
                        //     } else if ($selected_outlet == '0') {
                        //     $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                        //     master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_payment.namePayment, master_outlet.name name_outlet, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt FROM `transaksi_rawat_jalan` 
                        //     join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                        //     on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.transaksiID desc";
                        //     }
                        //     else {
                        //     $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                        //     master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_outlet.name name_outlet, master_payment.namePayment, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt FROM `transaksi_rawat_jalan` 
                        //     join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                        //     on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND
                        //     transaksi_rawat_jalan.outletID = '$selected_outlet' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.transaksiID desc ";
                        //     }
                        // }else {
                            
                        // }
                        
                        if($selected_outlet == '') {
                            $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                            master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_payment.namePayment, master_outlet.name name_outlet, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt, master_tindakan.typeTindakan FROM `transaksi_rawat_jalan` 
                            join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                            on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND
                            transaksi_rawat_jalan.outletID like '$outletID' and transaksi_rawat_jalan.tglTindakan like '%$date_now%' order by transaksi_rawat_jalan.transaksiID desc";
                        } else if ($selected_outlet == '0') {
                            $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                            master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_payment.namePayment, master_outlet.name name_outlet, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt, master_tindakan.typeTindakan FROM `transaksi_rawat_jalan` 
                            join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                            on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND transaksi_rawat_jalan.tglTindakan like '%$date_now%' order by transaksi_rawat_jalan.transaksiID desc";
                        }
                        else {
                            $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                            master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_outlet.name name_outlet, master_payment.namePayment, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt, master_tindakan.typeTindakan FROM `transaksi_rawat_jalan` 
                            join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                            on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND
                            transaksi_rawat_jalan.outletID = '$selected_outlet' and transaksi_rawat_jalan.tglTindakan like '%$date_now%' order by transaksi_rawat_jalan.transaksiID desc";
                        }
                        
                        
                        $fetch = mysqli_query($conn, $query);
                        
                        while ($result = mysqli_fetch_array($fetch)) { 
                        $nomor++;   
                        ?>
                        
                        <?php
                        
                        $idTransaction  = $result['transaksiID'];
                        $pasienID       = $result['pasienID'];
                        // $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
                        // join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction' and b.pasienID = '$pasienID'");
                        $cek_row = $conn->query("select a.* from master_hasil_tes a join master_pasien c on a.idPasien = c.id 
                        where a.idTransaction ='$idTransaction' and a.idPasien = '$pasienID'");
                        
                        $num_rows = !empty($cek_row) ? $cek_row->num_rows : 0;
                        if ($num_rows > 0) {
                        # code...
                        $fetch_row = $cek_row->fetch_array();
                        }
                        
                        ?>
                        <tr>
                        <td><?php echo $nomor ?></td>
                        <td><?= $result['transaksiID'] ?></td>
                        <td><?= $result['nik'] ?></td>
                        <td><?= $result['name_pasien'] ?></td>
                        <td><?= $result['name_tindakan'] ?></td>
                        <td><?= customDate($result['tglTindakan']) ?></td>
                        <td><?= customTime($result['createdAt']) ?></td>
                        <td><?= $result['name_outlet'] ?></td>
                        <td style="text-align:right;">Rp <?= number_format($result['grandTotal']) ?></td>
                        <td><?= $result['namePayment'] ?></td>
                        <td class='text-center'>
                        <?php if ($num_rows > 0) { ?>
                        <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                    # code...
                                    echo 'btn-info';
                                } else if ($fetch_row['hasil'] == 'Inkonklusif') {
                                    echo 'btn-secondary';
                                } else {
                                    echo 'btn-danger';
                                } ?> btn-xs"><?= $fetch_row['hasil'] ?></div>
                        <?php } else if ($result['typeTindakan'] == 'Non Result') { ?> <div class="btn btn-default btn-xs">Non Result</div> <?php } else { ?> <div class="btn btn-warning btn-xs">Waiting</div> <?php }  ?>
                        </td>
                        <td><?= $result['status'] ?></td>
                        <td>
                        <?php if(in_array("Superadmin", $arrayRoleName)) : ?>
                        <button class="btn btn-danger btn-xs" title="Hapus Tindakan" data-toggle="modal" data-target="#removeTindakan<?= $result['id'] ?>"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="removeTindakan<?= $result['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <form action="../admin/reservasi/remove_tindakan.php" method="POST">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Tindakan !</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <input type="hidden" value="<?= $result['id']  ?>" name="transactionID" readonly>
                              <h6>Apakah tindakan ini ingin dihapus?</h6>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                          </div>
                            </form>
                        </div>
                        
                        </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($result['status'] == 'Open' || $result['status'] == 'Paid') { ?>
                        <button class="btn btn-info btn-xs" title="Perubahan Outlet" data-toggle="modal" data-target="#changeOutlet<?= $result['id'] ?>"><i class="fa fa-store fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="changeOutlet<?= $result['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <form action="../admin/reservasi/change_outlet.php" method="POST">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perubahan Outlet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                          <div class="alert alert-warning" role="alert">
                              Perubahan outlet ini hanya diperlukan sesuai permintaan <strong>Pasien !</strong>
                            </div>
                              <div class="form-group ">
                                  <input type="hidden" value="<?= $result['id']  ?>" name="transactionID" readonly>
                                  <label class="text-sm">Pilih Outlet Tindakan</label>
                                  <select type="text" class="form-control form-control-sm" name="outletTindakan" id="outletTindakan">
                                      <option value="">Pilih outlet tindakan</option>
                                      <?php
                                        $query_get_outlet = $conn->query("SELECT id, name FROM master_outlet WHERE status='Aktif' AND isFaskes='0'");
                                        
                                        while($rowData = $query_get_outlet->fetch_array()) { ?>
                                            <option value="<?= $rowData['id'] ?>"><?= $rowData['name'] ?></option>
                                        <?php }
                                      ?>
                                  </select>
                              </div>
                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </div>
                        </form>
                        </div>
                        </div>
                        <?php } ?>
                        <a href="../admin/reservasi/invoice_tindakan.php?idTransaction=<?= $result['transaksiID'] ?>&idPasien=<?= $result['pasienID'] ?>" target="blank" class="btn btn-secondary btn-xs" title="Print Invoice"><i class="fa fa-file-invoice fa-sm" aria-hidden="true"></i></a>
                        <?php if ($result['paymentType'] != 4 && $result['paymentType'] != 5 && $result['status'] == 'Open') { ?>
                        <!--<a href="../admin/reservasi/confirm_payment_ots.php?idTransaction=<?= $result['transaksiID'] ?>&idPasien=<?= $result['pasienID'] ?>&tglTindakan=<?= $result['tglTindakan'] ?>" class="btn btn-success btn-xs" title="Konfirmasi Pembayaran" onclick="var r = confirm('Apakah pasien sudah melakukan pembayaran ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-check fa-sm" aria-hidden="true"></i></a>-->
                        <button type="button" class="btn btn-success btn-xs d-inline" title="Konfirmasi Pembayaran" data-toggle="modal" data-target="#confirmPayment<?= $result['id'] ?>"><i class="fa fa-check fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="confirmPayment<?= $result['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <form action="../admin/reservasi/confirm_payment_ots.php" method="POST">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Komfirmasi Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                          
                              <div class="form-group ">
                                  <input type="hidden" value="<?= $result['id']  ?>" name="transactionID" readonly>
                                  <label class="text-sm">Jenis Pembayaran Yang Digunakan ?</label>
                                  <select type="text" class="form-control form-control-sm" name="typePayment" id="typePayment">
                                      <option value="">Pilih tipe pembayaran</option>
                                      <?php
                                        $query_get_payment = $conn->query("SELECT id, namePayment FROM master_payment WHERE status='Aktif'");
                                        
                                        while($rowData = $query_get_payment->fetch_array()) { ?>
                                            <option value="<?= $rowData['id'] ?>"><?= $rowData['namePayment'] ?></option>
                                        <?php }
                                      ?>
                                  </select>
                              </div>
                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                        </div>
                        </form>
                        </div>
                        </div>
                        <?php } ?>
                        <?php if($result['status'] == 'Open' && in_array("Admin", $arrayRoleName)) { ?>
                        <a href="../admin/reservasi/cancel_tindakan.php?id=<?= $result['id'] ?>&karyawanID=<?= $karyawanID ?>" class="btn btn-danger btn-xs" title="Batalkan Tindakan" onclick="var r = confirm('Apakah ingin membatalkan tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-window-close fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($result['status'] == 'Paid') { ?>
                        <a href="../admin/reservasi/confirm_get_sample.php?idTransaction=<?= $result['transaksiID'] ?>&idPasien=<?= $result['pasienID'] ?>&tglTindakan=<?= $result['tglTindakan'] ?>" class="btn btn-warning btn-xs" title="Ambil Sample" onclick="var r = confirm('Apakah sample pasien sudah diambil ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-inbox fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($result['typeTindakan'] == 'PCR' && $result['status'] != 'Close' && $result['status'] != 'Open' && $result['status'] != 'Failed' && $result['status'] == 'On Process') { ?>
                        <a href="../admin/reservasi/barcode_transaksi_pcr.php?idTransaction=<?= $result['transaksiID'] ?>&name_pasien=<?= $result['name_pasien'] ?>&dateOfBirth=<?= $result['dateOfBirth'] ?>&name_tindakan=<?= $result['name_tindakan'] ?>&name_outlet=<?= $result['name_outlet'] ?>&tglTindakan=<?= $result['tglTindakan'] ?>&sampleTime=<?= $result['sampleTime'] ?>" target="blank" class="btn btn-default btn-xs" title="Print Barcode Tindakan"><i class="fa fa-print fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($num_rows == 1) {
                        echo '<a href="'.BASE_URL. 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] . '&noPasien=' . $result['pasienID'] . '" target="blank" class="btn btn-info btn-xs" title="Lihat atau Cetak Hasil"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                        }?>
                        </td>
                        </tr>
                        
                        <?php   } ?>
                        </tbody>
                        </table>
                        </div>
                        </div>
                        
                        
                        <div class="tab-pane" id="tab_2" mt-2>
                            <form action="" method="POST">
                            <div class="row ml-1">
                            <div class="col-xs-4">
                            <div class="input-group">
                            <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter" value="<?= $date_filter; ?>" required>
                            </div>
                            </div>
                            <div class="col-xs-4">
                            <div class="input-group">
                            <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter2" value="<?= $_POST['date_filter2'] ?>" required>
                            </div>
                            </div>
                            <div class="col-xs-4">
                            <div class="input-group">
                            <select name="select_outlet_periode" id="select_outlet_periode" class="custom-select custom-select-sm mr-3" required>
                            <option value="">Pilih Outlet</option>
                            <option value="0" <?php
                            if($select_outlet_periode == '0'){
                            echo "selected";
                            } ?>>Semua Outlet</option>
                            <?php
                            $queryOutlet = $conn->query("SELECT * FROM master_outlet WHERE status='Aktif'");
                            while ($fetchOutlet = $queryOutlet->fetch_array()) { ?>
                            <option value="<?= $fetchOutlet['id'] ?>" <?php
                            if($fetchOutlet['id'] == $select_outlet_periode){
                            echo "selected";
                            } else if($select_outlet_periode == '') {
                            if($fetchOutlet['id'] == $outletID){
                            echo "selected";
                            }
                            }?>><?= $fetchOutlet['name'] ?></option>
                            <?php  } ?>
                            </select>
                            </div>
                            </div>
                            <div class="col-xs-4">
                            <div class="input-group">
                            <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                            </div>
                            </div>
                            </div>
                            
                            </form>
                            <div class="row mt-3">
                            <?php
                                $sessionError =  isset($_SESSION['errorDateMessageAntigen']) ? $_SESSION['errorDateMessageAntigen'] : '';
                                if ($sessionError != '') {
                                # code...
                                echo '<div class="alert alert-warning alert-dismissible fade show text-sm" role="alert">
                                ' . $sessionError . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>';
                                } ?>
                            </div>
                        <div class="table-responsive">
                        <table id="dataRiwayatTindakanPeriode" class="table table-bordered table-striped text-xs" style="width:100%">
                        <thead>
                        <tr>
                        <th>No.</th>
                        <th>Transaksi ID</th>
                        <th>NIK/Passport</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Tindakan</th>
                        <th>Tanggal Tindakan</th>
                        <th>Dibuat Pada</th>
                        <th>Nama Outlet</th>
                        <th>Harga</th>
                        <th>Pembayaran</th>
                        <th>Hasil Tes</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $nomor=0;
                        $date_now = date('Y-m-d');
                        $date_filter_now = '%' . $date_filter . '%';
                        if($date_filter != '' && $date_filter2 != '') {
                            if ($select_outlet_periode == '0') {
                                $queryPeriode = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                                master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_payment.namePayment, master_outlet.name name_outlet, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt, master_tindakan.typeTindakan FROM `transaksi_rawat_jalan` 
                                join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                                on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.transaksiID desc";
                            }
                            else {
                                $queryPeriode = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.paymentType, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.name name_pasien, transaksi_rawat_jalan.status,
                                master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime, master_outlet.name name_outlet, master_payment.namePayment, master_tindakan.typeTindakan, transaksi_rawat_jalan.grandTotal, transaksi_rawat_jalan.createdAt, master_tindakan.typeTindakan FROM `transaksi_rawat_jalan` 
                                join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet
                                on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id join master_payment on transaksi_rawat_jalan.paymentType = master_payment.id WHERE NOT transaksi_rawat_jalan.status = 'Failed' AND
                                transaksi_rawat_jalan.outletID = '$select_outlet_periode' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.transaksiID desc ";
                            }
                        }
            
                        $fetch = mysqli_query($conn, $queryPeriode);
                        
                        while ($resultPeriode = mysqli_fetch_array($fetch)) { 
                        $nomor++;   
                        ?>
                        
                        <?php
                        
                        $idTransaction  = $resultPeriode['transaksiID'];
                        $pasienID       = $resultPeriode['pasienID'];
                        // $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
                        // join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction' and b.pasienID = '$pasienID'");
                        $cek_row = $conn->query("select a.* from master_hasil_tes a join master_pasien c on a.idPasien = c.id 
                        where a.idTransaction ='$idTransaction' and a.idPasien = '$pasienID'");
                        
                        $num_rows = !empty($cek_row) ? $cek_row->num_rows : 0;
                        if ($num_rows > 0) {
                        # code...
                        $fetch_row = $cek_row->fetch_array();
                        }
                        
                        ?>
                        <tr>
                        <td><?php echo $nomor ?></td>
                        <td><?= $resultPeriode['transaksiID'] ?></td>
                        <td><?= $resultPeriode['nik'] ?></td>
                        <td><?= $resultPeriode['name_pasien'] ?></td>
                        <td><?= $resultPeriode['name_tindakan'] ?></td>
                        <td><?= customDate($resultPeriode['tglTindakan']) ?></td>
                        <td><?= customTime($resultPeriode['createdAt']) ?></td>
                        <td><?= $resultPeriode['name_outlet'] ?></td>
                        <td style="text-align:right;">Rp <?= number_format($resultPeriode['grandTotal']) ?></td>
                        <td><?= $resultPeriode['namePayment'] ?></td>
                        <td class='text-center'>
                        <?php if ($num_rows > 0) { ?>
                        <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                    # code...
                                    echo 'btn-info';
                                } else if ($fetch_row['hasil'] == 'Inkonklusif') {
                                    echo 'btn-secondary';
                                } else {
                                    echo 'btn-danger';
                                } ?> btn-xs"><?= $fetch_row['hasil'] ?></div>
                        <?php } else if ($resultPeriode['typeTindakan'] == 'Non Result') { ?> <div class="btn btn-default btn-xs">Non Result</div> <?php } else { ?> <div class="btn btn-warning btn-xs">Waiting</div> <?php }  ?>
                        </td>
                        <td><?= $resultPeriode['status'] ?></td>
                        <td>
                        <?php if(in_array("Superadmin", $arrayRoleName)) : ?>
                        <button class="btn btn-danger btn-xs" title="Hapus Tindakan" data-toggle="modal" data-target="#removeTindakan<?= $resultPeriode['id'] ?>"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="removeTindakan<?= $resultPeriode['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <form action="../admin/reservasi/remove_tindakan.php" method="POST">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Tindakan !</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <input type="hidden" value="<?= $resultPeriode['id']  ?>" name="transactionID" readonly>
                              <h6>Apakah tindakan ini ingin dihapus?</h6>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                          </div>
                        </div>
                        </form>
                        </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($resultPeriode['status'] == 'Open' || $resultPeriode['status'] == 'Paid') { ?>
                        <button class="btn btn-info btn-xs" title="Perubahan Outlet" data-toggle="modal" data-target="#changeOutlet<?= $resultPeriode['id'] ?>"><i class="fa fa-store fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="changeOutlet<?= $resultPeriode['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <form action="../admin/reservasi/change_outlet.php" method="POST">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perubahan Outlet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                          <div class="alert alert-warning" role="alert">
                              Perubahan outlet ini hanya diperlukan sesuai permintaan <strong>Pasien !</strong>
                            </div>
                              <div class="form-group ">
                                  <input type="hidden" value="<?= $resultPeriode['id']  ?>" name="transactionID" readonly>
                                  <label class="text-sm">Pilih Outlet Tindakan</label>
                                  <select type="text" class="form-control form-control-sm" name="outletTindakan" id="outletTindakan">
                                      <option value="">Pilih outlet tindakan</option>
                                      <?php
                                        $query_get_outlet = $conn->query("SELECT id, name FROM master_outlet WHERE status='Aktif' AND isFaskes='0'");
                                        
                                        while($rowData = $query_get_outlet->fetch_array()) { ?>
                                            <option value="<?= $rowData['id'] ?>"><?= $rowData['name'] ?></option>
                                        <?php }
                                      ?>
                                  </select>
                              </div>
                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </div>
                        </form>
                        </div>
                        </div>
                        <?php } ?>
                        <a href="../admin/reservasi/invoice_tindakan.php?idTransaction=<?= $resultPeriode['transaksiID'] ?>&idPasien=<?= $resultPeriode['pasienID'] ?>" target="blank" class="btn btn-secondary btn-xs" title="Print Invoice"><i class="fa fa-file-invoice fa-sm" aria-hidden="true"></i></a>
                        <?php if ($resultPeriode['paymentType'] != 4 && $resultPeriode['paymentType'] != 5 && $resultPeriode['status'] == 'Open') { ?>
                        <!--<a href="../admin/reservasi/confirm_payment_ots.php?idTransaction=<?= $resultPeriode['transaksiID'] ?>&idPasien=<?= $resultPeriode['pasienID'] ?>&tglTindakan=<?= $resultPeriode['tglTindakan'] ?>" class="btn btn-success btn-xs" title="Konfirmasi Pembayaran" onclick="var r = confirm('Apakah pasien sudah melakukan pembayaran ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-check fa-sm" aria-hidden="true"></i></a>-->
                        <button type="button" class="btn btn-success btn-xs d-inline" title="Konfirmasi Pembayaran" data-toggle="modal" data-target="#confirmPayment<?= $resultPeriode['id'] ?>"><i class="fa fa-check fa-sm" aria-hidden="true"></i></button>
                        <div class="modal fade" id="confirmPayment<?= $resultPeriode['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <form action="../admin/reservasi/confirm_payment_ots.php" method="POST">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Komfirmasi Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                          
                              <div class="form-group ">
                                  <input type="hidden" value="<?= $resultPeriode['id']  ?>" name="transactionID" readonly>
                                  <label class="text-sm">Jenis Pembayaran Yang Digunakan ?</label>
                                  <select type="text" class="form-control form-control-sm" name="typePayment" id="typePayment">
                                      <option value="">Pilih tipe pembayaran</option>
                                      <?php
                                        $query_get_payment = $conn->query("SELECT id, namePayment FROM master_payment WHERE status='Aktif'");
                                        
                                        while($rowData = $query_get_payment->fetch_array()) { ?>
                                            <option value="<?= $rowData['id'] ?>"><?= $rowData['namePayment'] ?></option>
                                        <?php }
                                      ?>
                                  </select>
                              </div>
                          
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                        </div>
                        </form>
                        </div>
                        </div>
                        <?php } ?>
                        <?php if($resultPeriode['status'] == 'Open' && in_array("Admin", $arrayRoleName)) { ?>
                        <a href="../admin/reservasi/cancel_tindakan.php?id=<?= $resultPeriode['id'] ?>&karyawanID=<?= $karyawanID ?>" class="btn btn-danger btn-xs" title="Batalkan Tindakan" onclick="var r = confirm('Apakah ingin membatalkan tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-window-close fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($resultPeriode['status'] == 'Paid') { ?>
                        <a href="../admin/reservasi/confirm_get_sample.php?idTransaction=<?= $resultPeriode['transaksiID'] ?>&idPasien=<?= $resultPeriode['pasienID'] ?>&tglTindakan=<?= $resultPeriode['tglTindakan'] ?>" class="btn btn-warning btn-xs" title="Ambil Sample" onclick="var r = confirm('Apakah sample pasien sudah diambil ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-inbox fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($resultPeriode['typeTindakan'] == 'PCR' && $resultPeriode['status'] != 'Close' && $resultPeriode['status'] != 'Open' && $resultPeriode['status'] != 'Failed' && $resultPeriode['status'] == 'On Process') { ?>
                        <a href="../admin/reservasi/barcode_transaksi_pcr.php?idTransaction=<?= $resultPeriode['transaksiID'] ?>&name_pasien=<?= $resultPeriode['name_pasien'] ?>&dateOfBirth=<?= $resultPeriode['dateOfBirth'] ?>&name_tindakan=<?= $resultPeriode['name_tindakan'] ?>&name_outlet=<?= $resultPeriode['name_outlet'] ?>&tglTindakan=<?= $resultPeriode['tglTindakan'] ?>&sampleTime=<?= $resultPeriode['sampleTime'] ?>" target="blank" class="btn btn-default btn-xs" title="Print Barcode Tindakan"><i class="fa fa-print fa-sm" aria-hidden="true"></i></a>
                        <?php } ?>
                        <?php if ($num_rows == 1) {
                        echo '<a href="'.BASE_URL. 'PDF/hasil_pasien.php?idTransaction=' . $resultPeriode['transaksiID'] . '&noPasien=' . $resultPeriode['pasienID'] . '" target="blank" class="btn btn-info btn-xs" title="Lihat atau Cetak Hasil"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                        }?>
                        </td>
                        </tr>
                        
                        <?php   } ?>
                        </tbody>
                        </table>
                        </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>