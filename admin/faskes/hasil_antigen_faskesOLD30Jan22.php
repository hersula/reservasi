<?php 
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

?>
<section class="content">
    <div class="container-fluid">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Sampel Hasil Antigen</h1>
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
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Sample Antigen</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Antigen Periode</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-xs" id="tableSamplePCRfaskes">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th>No Transaksi</th>
                                            <th>NIK/Passport</th>
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
                                            $querySamplePCR = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.nik, master_pasien.name, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'Antigen' AND master_outlet.id = '$outletID' AND master_outlet.isFaskes = '1'");
                                            while ($fetchSampleBarcode = $querySamplePCR->fetch_array()) { ?>
                                                <?php

                                                $idTransaction  = $fetchSampleBarcode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcode['pasienID'];
                                                $phone          = $fetchSampleBarcode['phone'];
                                                $substr_phone   = substr($phone, '1');
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
                                                    <td><?= $fetchSampleBarcode['nik']; ?></td>
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
                                                    <td><?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            echo '<a href="admin.php?page=input-hasil-antigen-faskes&idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                        <?php if ($fetchSampleBarcode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62'.$substr_phone.'&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$result['name_pasien'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20PCR%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] .'%26noPasien='.$result['pasienID'].'" class="btn btn-success btn-xs title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-md" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] .'%26noPasien='.$fetchSampleBarcode['pasienID'].'" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?></td>
                                                </tr>
                                            <?php  }
                                        } else {
                                            $querySamplePCR = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.tglTindakan, master_pasien.name, master_pasien.nik, master_pasien.phone, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.status status_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.sampleTime FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan = 'Antigen' AND master_outlet.isFaskes = '1'");
                                            while ($fetchSampleBarcode = $querySamplePCR->fetch_array()) { ?>
                                                <?php

                                                $idTransaction  = $fetchSampleBarcode['transaksiID'];
                                                $pasienID       = $fetchSampleBarcode['pasienID'];
                                                $phone          = $fetchSampleBarcode['phone'];
                                                $substr_phone   = substr($phone, '1');
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
                                                    <td><?= $fetchSampleBarcode['nik']; ?></td>
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
                                                    <td><?php if ($num_rows <= 0) {
                                                            // <!-- # code... -->
                                                            // echo '<p class="text-danger text-xs text-bold">X</p>';
                                                            echo '<a href="admin.php?page=input-hasil-antigen-faskes&idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                        <?php if ($fetchSampleBarcode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] . '&noPasien=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcode['transaksiID'] .'%26noPasien='.$fetchSampleBarcode['pasienID'].'" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?></td>
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
                                    <!--<div class="col-md-2">-->
                                    <!--    <div class="form-group mb-3">-->
                                    <!--        <label class="text-xs">Status Barcode</label>-->
                                    <!--        <select type="text" class="form-control form-control-sm" id="barcodeLab" name="barcodeLab">-->
                                    <!--            <option value="Semua">Semua</option>-->
                                    <!--            <option value="Belum dibarcode">Belum dibarcode</option>-->
                                    <!--            <option value="Sudah dibarcode">Sudah dibarcode</option>-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
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
                                            <th>NIK/Passport</th>
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
                                            // if ($barcodeLab != 'Semua') {
                                            //     # code...
                                            //     $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            // FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            // WHERE master_tindakan.typeTindakan ='Antigen' AND master_outlet.id='$outletID' AND master_outlet.isFaskes= '1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter' AND 
                                            // (CASE WHEN transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' THEN 'Belum dibarcode' WHEN transaksi_rawat_jalan.barcodeLab != 'Belum dibarcode' THEN 'Sudah dibarcode' END) IN ('$barcodeLab')") or die($conn->error);
                                            // } else {
                                            //     $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime
                                            // FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            // WHERE master_tindakan.typeTindakan ='Antigen' AND transaksi_rawat_jalan.outletID='$outletID' AND master_outlet.isFaskes= '1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'") or die($conn->error);
                                            // }
                                            
                                            $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan ='Antigen' AND transaksi_rawat_jalan.outletID='$outletID' AND master_outlet.isFaskes= '1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'") or die($conn->error);

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
                                                        <td><?= $fetchSampleBarcodePeriode['nik']; ?></td>
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
                                                            // echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            echo '<a href="admin.php?page=input-hasil-antigen-faskes&idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&pasienID=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                            <?php if ($fetchSampleBarcodePeriode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcodePeriode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] .'%26noPasien='.$fetchSampleBarcodePeriode['pasienID'].'" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
                                                        </td>
                                                    </tr>
                                        <?php  }
                                            }
                                        } else {
                                            // if ($barcodeLab != 'Semua') {
                                            //     # code...
                                            //     $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            // FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            // WHERE master_tindakan.typeTindakan ='Antigen' AND master_outlet.isFaskes='1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter' AND 
                                            // (CASE WHEN transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' THEN 'Belum dibarcode' WHEN transaksi_rawat_jalan.barcodeLab != 'Belum dibarcode' THEN 'Sudah dibarcode' END) IN ('$barcodeLab')");
                                            // } else {
                                            //     $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            // FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            // WHERE master_tindakan.typeTindakan ='Antigen' AND master_outlet.isFaskes='1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'");
                                            // }
                                            
                                            $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.nik, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.sampleTime 
                                            FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                            WHERE master_tindakan.typeTindakan ='Antigen' AND master_outlet.isFaskes='1' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'");

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
                                                        <td><?= $fetchSampleBarcodePeriode['nik']; ?></td>
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
                                                            // echo '<p class="text-danger text-xs text-bold d-inline">X</p>';
                                                            echo '<a href="admin.php?page=input-hasil-antigen-faskes&idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&pasienID=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                            // echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $fetchSampleBarcode['idTransaction'] . '&pasienID=' . $fetchSampleBarcode['pasienID'] . '" class="btn btn-warning btn-sm" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                        } else {
                                                            echo '<a href="' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" target="blank" class="btn btn-info btn-sm" title="Lihat Detail"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>

                                                            <?php if ($fetchSampleBarcodePeriode['status_tindakan'] == 'Close') {
                                                            # code...
                                                            // echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] . '&noPasien=' . $fetchSampleBarcodePeriode['pasienID'] . '" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                            echo '<a href="https://api.whatsapp.com/send?phone=62' . $substr_phone . '&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$fetchSampleBarcodePeriode['name'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $fetchSampleBarcodePeriode['transaksiID'] .'%26noPasien='.$fetchSampleBarcodePeriode['pasienID'].'" class="btn btn-success btn-sm" title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-sm" aria-hidden="true"></i></a>';
                                                        } ?>
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