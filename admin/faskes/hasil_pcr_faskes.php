<?php 

    $date_now   = date('Y-m-d');

    function directAdmin() {
        echo '<script>window.location = "admin.php"</script>';
    }
    
    $outletID = $_SESSION['outletID'];
    $isFaskes = $_SESSION['isFaskes'];
    
    $arrayRoleName = $_SESSION['rolesName'];
    
    if($isFaskes != '1' && !in_array("Superadmin", $arrayRoleName) && !in_array("Faskes", $arrayRoleName)) {
        directAdmin();
    }
    
   function customDate($dateTimeSample) {
    
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d/m/Y', $strtime);
        
        return $formatTimeSample;
   }
   function customDateFormat($dateTimeSample) {
    
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d/m/Y H:i:s', $strtime);
        
        return $formatTimeSample;
   }
   
   function get_waiting($conn, $isFaskes, $outletID, $date_now){
        $i_waiting = 0;
        if ($isFaskes == '1') {
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.id = '$outletID' and transaksi_rawat_jalan.status != 'Failed' AND master_outlet.isFaskes = '1' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }else{
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes = '1' and transaksi_rawat_jalan.status != 'Failed' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }
                            //var_dump($querySamplePCR_);
                            $i_wait = 1;
                            while ($fetchSampleBarcode_ = $querySamplePCR_->fetch_array()) {
                                //var_dump($fetchSampleBarcode_);
                                                $idTransaction_  = $fetchSampleBarcode_['transaksiID'];
                                                $pasienID_       = $fetchSampleBarcode_['pasienID'];
                                                $cek_row_ = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction_' and b.pasienID = '$pasienID_'");

                                                $num_rows_ = $cek_row_->num_rows;
                                                if ($num_rows_ <= 0) {
                                                    # code...
                                                    $i_waiting = $i_wait++;
                                                    //echo $i_waiting;
                                                }
                            }
        return $i_waiting;
    }

    function get_negatif($conn, $isFaskes, $outletID, $date_now){
        $i_negatif = 0;
        if ($isFaskes == '1') {
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.id = '$outletID' and transaksi_rawat_jalan.status != 'Failed' AND master_outlet.isFaskes = '1' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }else{
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes = '1' and transaksi_rawat_jalan.status != 'Failed' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }
                            //var_dump($querySamplePCR_);
                            $i_min = 1;
                            while ($fetchSampleBarcode_ = $querySamplePCR_->fetch_array()) {
                                //var_dump($fetchSampleBarcode_);
                                                $idTransaction_  = $fetchSampleBarcode_['transaksiID'];
                                                $pasienID_       = $fetchSampleBarcode_['pasienID'];
                                                $cek_row_ = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction_' and b.pasienID = '$pasienID_'");

                                                $fetch_row_ = $cek_row_->fetch_array();
                                                $num_rows_ = $cek_row_->num_rows;
                                                if ($num_rows_ > 0) {
                                                    # code...
                                                    if ($fetch_row_['hasil'] == 'Negatif') {
                                                        $i_negatif = $i_min++;
                                                    }
                                                }
                            }
        return $i_negatif;
    }

    function get_positif($conn, $isFaskes, $outletID, $date_now){
        $i_positif = 0;
        if ($isFaskes == '1') {
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.id = '$outletID' and transaksi_rawat_jalan.status != 'Failed' AND master_outlet.isFaskes = '1' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }else{
            $querySamplePCR_ = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes = '1' and transaksi_rawat_jalan.status != 'Failed' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
        }
                            //var_dump($querySamplePCR_);
                            $i_plus = 1;
                            while ($fetchSampleBarcode_ = $querySamplePCR_->fetch_array()) {
                                //var_dump($fetchSampleBarcode_);
                                                $idTransaction_  = $fetchSampleBarcode_['transaksiID'];
                                                $pasienID_       = $fetchSampleBarcode_['pasienID'];
                                                $cek_row_ = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction_' and b.pasienID = '$pasienID_'");

                                                $fetch_row_ = $cek_row_->fetch_array();
                                                $num_rows_ = $cek_row_->num_rows;
                                                if ($num_rows_ > 0) {
                                                    # code...
                                                    if ($fetch_row_['hasil'] == 'Positif') {
                                                        $i_positif = $i_plus++;
                                                    }
                                                }
                            }
        return $i_positif;
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
                            <h1 class="m-0">Sampel Hasil PCR</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
                                <li class="breadcrumb-item active">Sample</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav nav-pills ml-auto p-2" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Sample PCR</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">PCR Periode</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                             
                                <!-- ./col -->
                                <div class="col-lg-2 col-3">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <?php
                                        //$sql = "select count(*) as jml_, status from transaksi_rawat_jalan where status='Paid' and outletID='$outletID' and tglTindakan = '$date'";
                                        //$result = mysqli_query($conn, $sql);
                                        //if ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="inner">
                                                <center>
                                                    <p>Negatif</p>
                                                    <h3><?=get_negatif($conn, $isFaskes, $outletID, $date_now);?></h3>
                                                </center>
                                            </div>
                                        <?php
                                        //}

                                        ?>
                                      

                                    </div>
                                </div>
                                <!-- ./col -->

                                   <div class="col-lg-2 col-3">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <?php
                                        //$sql = " select count(*) as jml_trx_fail, status from transaksi_rawat_jalan where status='Close' and outletID='$outletID' and tglTindakan = '$date'";
                                        //$result = mysqli_query($conn, $sql);
                                        //if ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="inner">
                                                <center>
                                                    <p>Positif</p>
                                                    <h3><?=get_positif($conn, $isFaskes, $outletID, $date_now);?></h3>
                                                </center>
                                            </div>
                                        <?php
                                        //}

                                        ?>
                                      

                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-2 col-3">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <?php
                                        //$sql = "select count(*) as jml_trx_close, status from transaksi_rawat_jalan where status='On Process' and outletID='$outletID' and tglTindakan = '$date'";
                                        //$result = mysqli_query($conn, $sql);
                                        //if ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="inner">
                                                <center>
                                                    <p>Waiting</p>
                                                    <h3><?=get_waiting($conn, $isFaskes, $outletID, $date_now);?></h3>
                                                </center>
                                            </div>
                                        <?php
                                        //}

                                        ?>
                                        
                                  
                                    </div>
                                </div>
                                <!-- ./col -->
                             
                            </div>
                            <!-- /.row -->
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-xs" id="tableSamplePCRfaskes">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>No Transaksi</th>
                                            <th>Barcode Lab</th>
                                            <th>Nama Pasien</th>
                                            <th>Nama Tindakan</th>
                                            <th>Nama Outlet/Faskes</th>
                                            <th>Tanggal Tindakan</th>
                                            <th>Waktu Sample</th>
                                            <th>Hasil Tes</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $date_now   = date('Y-m-d');
                                        if ($isFaskes == '1') {
                                            # code...
                                            $querySamplePCR = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.id = '$outletID' AND master_outlet.isFaskes = '1' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
                                            while ($fetchSampleBarcode = $querySamplePCR->fetch_array()) { ?>
                                                <?php

                                                $idTransaction  = $fetchSampleBarcode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcode['pasienID'];
                                                $phone          = $fetchSampleBarcode['phone'];
                                                $substr_phone   = (substr(trim($phone), 0, 1)=='0') ? '62' .substr($phone, '1') : $phone;
//                                                 $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
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
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $fetchSampleBarcode['transaksiID']; ?></td>
                                                    <td><?= $fetchSampleBarcode['barcodeLab']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name_tindakan']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name_outlet']; ?></td>
                                                    <td><?= customDate($fetchSampleBarcode['tglTindakan']); ?></td>
                                                    <td><?= customDateFormat($fetchSampleBarcode['sampleTime']); ?></td>
                                                    <td><?php if ($num_rows > 0) { ?>
                                                            <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                                # code...
                                                                                echo 'btn-info';
                                                                            } else {
                                                                                echo 'btn-danger';
                                                                            } ?> btn-xs text-xs"><?= $fetch_row['hasil'] ?></div>
                                                        <?php } else { ?> <div class="btn btn-warning btn-xs text-xs">Waiting</div> <?php }  ?>
                                                    </td>
                                                    <td>
                                                    <?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                        <?php if ($fetchSampleBarcode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62'.$substr_phone.'&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$result['name_pasien'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20PCR%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] .'%26noPasien='.$result['pasienID'].'" class="btn btn-success btn-xs title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-md" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] .'%26noPasien='.$fetchSampleBarcode['pasienID'].'%0AGunakan%20tanggal%20lahir%20Anda%20dalam%20bentuk%20DDMM%20(dua%20digit%20tanggal%20lahir%20dan%20dua%20digit%20bulan)%20untuk%20membuka%20file%20tersebut.%0A%0ABilamana%20Anda%20membuka%20alamat%20diatas%20menggunakan%20ponsel%20tipe%20ANDROID%2C%20maka%20hasil%20test%20akan%20langsung%20terunduh%20ke%20dalam%20folder%20Document%20%2F%20Download%20di%20ponsel%20Anda" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
                                                        <?php if(in_array("Superadmin", $arrayRoleName)) { ?>
                                                            <?php if($num_rows > 0) { ?>
                                                                <a href="../admin/laboratorium/cancel_hasil.php?id=<?= $fetchSampleBarcode['transaksiID'] ?>&pasienID=<?= $fetchSampleBarcode['pasienID'] ?>" class="btn bg-dark btn-sm" title="Batalkan Hasil" onclick="var r = confirm('Apakah ingin membatalkan hasil tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                      </td>
                                                </tr>
                                            <?php  }
                                        } else {
                                            $querySamplePCR = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes = '1' AND transaksi_rawat_jalan.tglTindakan = '$date_now'");
                                            while ($fetchSampleBarcode = $querySamplePCR->fetch_array()) { ?>
                                                <?php

                                                $idTransaction  = $fetchSampleBarcode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcode['pasienID'];
                                                $phone          = $fetchSampleBarcode['phone'];
                                                $substr_phone   = (substr(trim($phone), 0, 1)=='0') ? '62' .substr($phone, '1') : $phone;
//                                                 $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
// join master_pasien c on a.idPasien = c.id where b.transaksiID ='$idTransaction' and b.pasienID = '$pasienID'") or die($conn->error);
                                                
                                                $cek_row = $conn->query("select a.* from master_hasil_tes a join master_pasien c on a.idPasien = c.id 
                                                where a.idTransaction ='$idTransaction' and a.idPasien = '$pasienID'");
                                                
                                                $fetch_row = $cek_row->fetch_array();
                                                $num_rows = $cek_row->num_rows;

                                                ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $fetchSampleBarcode['transaksiID']; ?></td>
                                                    <td><?= $fetchSampleBarcode['barcodeLab']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name_tindakan']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name_outlet']; ?></td>
                                                    <td><?= customDate($fetchSampleBarcode['tglTindakan']); ?></td>
                                                    <td><?= customDateFormat($fetchSampleBarcode['sampleTime']); ?></td>
                                                    <td><?php if ($num_rows > 0) { ?>
                                                            <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                                # code...
                                                                                echo 'btn-info';
                                                                            } else {
                                                                                echo 'btn-danger';
                                                                            } ?> btn-xs text-xs"><?= $fetch_row['hasil'] ?></div>
                                                        <?php } else { ?> <div class="btn btn-warning btn-xs text-xs">Waiting</div> <?php }  ?>
                                                    </td>
                                                    <td>
                                                    <?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            echo '<p class="text-danger text-xs text-bold">X</p>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                        <?php if ($fetchSampleBarcode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] .'%26noPasien='.$fetchSampleBarcode['pasienID'].'%0AGunakan%20tanggal%20lahir%20Anda%20dalam%20bentuk%20DDMM%20(dua%20digit%20tanggal%20lahir%20dan%20dua%20digit%20bulan)%20untuk%20membuka%20file%20tersebut.%0A%0ABilamana%20Anda%20membuka%20alamat%20diatas%20menggunakan%20ponsel%20tipe%20ANDROID%2C%20maka%20hasil%20test%20akan%20langsung%20terunduh%20ke%20dalam%20folder%20Document%20%2F%20Download%20di%20ponsel%20Anda" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
                                                        <?php if(in_array("Superadmin", $arrayRoleName)) { ?>
                                                            <?php if($num_rows > 0) { ?>
                                                                <a href="../admin/laboratorium/cancel_hasil.php?id=<?= $fetchSampleBarcode['transaksiID'] ?>&pasienID=<?= $fetchSampleBarcode['pasienID'] ?>" class="btn bg-dark btn-sm" title="Batalkan Hasil" onclick="var r = confirm('Apakah ingin membatalkan hasil tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </td>
                                                </tr>
                                        <?php  }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <?php
                            $dateFrom = isset($_POST['dateFirst']) ? $_POST['dateFirst'] : '';
                            $dateAfter = isset($_POST['dateSecond']) ? $_POST['dateSecond'] : '';
                            $barcodeLab = isset($_POST['barcodeLab']) ? $_POST['barcodeLab'] : '';

                            if ($dateFrom > $dateAfter) {
                                # code...
                                $_SESSION['errorDateMessage'] = "Maaf tanggal pertama tidak boleh melewati tanggal kedua";
                            } else {
                                unset($_SESSION['errorDateMessage']);
                            }
                            ?>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="text-xs">Tanggal Pertama</label>
                                            <input type="date" class="form-control form-control-sm" id="dateFirst" name="dateFirst" required value="<?= $dateFrom ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="text-xs">Tanggal Kedua</label>
                                            <input type="date" class="form-control form-control-sm" id="dateSecond" name="dateSecond" required value="<?= $dateAfter ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="text-xs">Status Barcode</label>
                                            <select type="text" class="form-control form-control-sm" id="barcodeLab" name="barcodeLab">
                                                <option value="Semua">Semua</option>
                                                <option value="Belum dibarcode">Belum dibarcode</option>
                                                <option value="Sudah dibarcode">Sudah dibarcode</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label class="text-xs mb-4"></label><br>
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" id="filter" name="filter"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    $sessionError =  isset($_SESSION['errorDateMessage']) ? $_SESSION['errorDateMessage'] : '';
                                    if ($sessionError != '') {
                                        # code...
                                        echo '<div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                        ' . $_SESSION['errorDateMessage'] . '
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>';
                                    } ?>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-xs" id="tableSamplePeriodeFaskes">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>Barcode Lab</th>
                                            <th>Nama Pasien</th>
                                            <th>Nama Tindakan</th>
                                            <th>Nama Outlet/Faskes</th>
                                            <th>Tanggal Tindakan</th>
                                            <th>Waktu Sample</th>
                                            <th>Hasil Tes</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if ($isFaskes == '1') {
                                            # code...
                                            if ($barcodeLab != 'Semua') {
                                                # code...
                                                $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.id='$outletID' AND master_outlet.isFaskes= '1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter' AND 
                                            (CASE WHEN transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' THEN 'Belum dibarcode' WHEN transaksi_rawat_jalan.barcodeLab != 'Belum dibarcode' THEN 'Sudah dibarcode' END) IN ('$barcodeLab')") or die($conn->error);
                                            } else {
                                                $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND transaksi_rawat_jalan.outletID='$outletID' AND master_outlet.isFaskes= '1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'") or die($conn->error);
                                            }

                                            if ($queryGetBarcodePeriode->num_rows > 0) {
                                                # code...
                                                while ($fetchSampleBarcodePeriode = $queryGetBarcodePeriode->fetch_array()) { ?>
                                                
                                                <?php

                                                $idTransaction  = $fetchSampleBarcodePeriode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcodePeriode['pasienID'];
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
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['barcodeLab']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name_tindakan']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name_outlet']; ?></td>
                                                        <td><?= customDate($fetchSampleBarcodePeriode['tglTindakan']); ?></td>
                                                        <td><?= customDateFormat($fetchSampleBarcodePeriode['sampleTime']); ?></td>
                                                        <td><?php if ($num_rows > 0) { ?>
                                                                <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                                    # code...
                                                                                    echo 'btn-info';
                                                                                } else {
                                                                                    echo 'btn-danger';
                                                                                } ?> btn-xs text-xs"><?= $fetch_row['hasil'] ?></div>
                                                            <?php } else { ?> <div class="btn btn-warning btn-xs text-xs">Waiting</div> <?php }  ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                            <?php if ($fetchSampleBarcodePeriode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            echo '<a href="https://api.whatsapp.com/send?phone=' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcodePeriode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] .'%26noPasien='.$fetchSampleBarcodePeriode['pasienID'].'%0AGunakan%20tanggal%20lahir%20Anda%20dalam%20bentuk%20DDMM%20(dua%20digit%20tanggal%20lahir%20dan%20dua%20digit%20bulan)%20untuk%20membuka%20file%20tersebut.%0A%0ABilamana%20Anda%20membuka%20alamat%20diatas%20menggunakan%20ponsel%20tipe%20ANDROID%2C%20maka%20hasil%20test%20akan%20langsung%20terunduh%20ke%20dalam%20folder%20Document%20%2F%20Download%20di%20ponsel%20Anda" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
                                                        <?php if(in_array("Superadmin", $arrayRoleName)) { ?>
                                                            <?php if($num_rows > 0) { ?>
                                                                <a href="../admin/laboratorium/cancel_hasil.php?id=<?= $fetchSampleBarcodePeriode['transaksiID'] ?>&pasienID=<?= $fetchSampleBarcodePeriode['pasienID'] ?>" class="btn bg-dark btn-sm" title="Batalkan Hasil" onclick="var r = confirm('Apakah ingin membatalkan hasil tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                        <?php  }
                                            }
                                        } else {
                                            if ($barcodeLab != 'Semua') {
                                                # code...
                                                $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes='1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter' AND 
                                            (CASE WHEN transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' THEN 'Belum dibarcode' WHEN transaksi_rawat_jalan.barcodeLab != 'Belum dibarcode' THEN 'Sudah dibarcode' END) IN ('$barcodeLab')");
                                            } else {
                                                $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'PCR' AND master_outlet.isFaskes='1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'");
                                            }

                                            if ($queryGetBarcodePeriode->num_rows > 0) {
                                                # code...
                                                while ($fetchSampleBarcodePeriode = $queryGetBarcodePeriode->fetch_array()) { ?>
                                                <?php

                                                $idTransaction  = $fetchSampleBarcodePeriode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcodePeriode['pasienID'];
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
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['barcodeLab']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name_tindakan']; ?></td>
                                                        <td><?= $fetchSampleBarcodePeriode['name_outlet']; ?></td>
                                                        <td><?= customDate($fetchSampleBarcodePeriode['tglTindakan']); ?></td>
                                                        <td><?= customDateFormat($fetchSampleBarcodePeriode['sampleTime']); ?></td>
                                                        <td><?php if ($num_rows > 0) { ?>
                                                                <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                                    # code...
                                                                                    echo 'btn-info';
                                                                                } else {
                                                                                    echo 'btn-danger';
                                                                                } ?> btn-xs text-xs"><?= $fetch_row['hasil'] ?></div>
                                                            <?php } else { ?> <div class="btn btn-warning btn-xs text-xs">Waiting</div> <?php }  ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                            <?php if ($fetchSampleBarcodePeriode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcodePeriode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] .'%26noPasien='.$fetchSampleBarcodePeriode['pasienID'].'%0AGunakan%20tanggal%20lahir%20Anda%20dalam%20bentuk%20DDMM%20(dua%20digit%20tanggal%20lahir%20dan%20dua%20digit%20bulan)%20untuk%20membuka%20file%20tersebut.%0A%0ABilamana%20Anda%20membuka%20alamat%20diatas%20menggunakan%20ponsel%20tipe%20ANDROID%2C%20maka%20hasil%20test%20akan%20langsung%20terunduh%20ke%20dalam%20folder%20Document%20%2F%20Download%20di%20ponsel%20Anda" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
                                                        <?php if(in_array("Superadmin", $arrayRoleName)) { ?>
                                                            <?php if($num_rows > 0) { ?>
                                                                <a href="../admin/laboratorium/cancel_hasil.php?id=<?= $fetchSampleBarcodePeriode['transaksiID'] ?>&pasienID=<?= $fetchSampleBarcodePeriode['pasienID'] ?>" class="btn bg-dark btn-sm" title="Batalkan Hasil" onclick="var r = confirm('Apakah ingin membatalkan hasil tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                        <?php  }
                                            }
                                        }
                                        ?>
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