<?php

$roleIDlist = $_SESSION['roleID'];
$query = $conn->query("select * from master_roles join karyawan_role_list on master_roles.id = karyawan_role_list.rolesID where karyawan_role_list.id = '$roleIDlist'");

$fetchRole = $query->fetch_array();

$query   = $conn->query("SELECT MAX(batchNumber) as kode_terakhir FROM transaksi_rawat_jalan");
$data    = $query->fetch_array();
$batchNo = $data['kode_terakhir'];

$urutan  = (int)$batchNo;

$urutan++;

$batchNo = $urutan;

function directAdmin() {
    echo '<script>window.location = "admin.php"</script>';
}

$outletID = $_SESSION['outletID'];
$isFaskes = $_SESSION['isFaskes'];

$arrayRoleName = $_SESSION['rolesName'];

if(!in_array("Superadmin", $arrayRoleName) && !in_array("Laboratorium", $arrayRoleName)) {
    directAdmin();
}

function customDateFormat($dateTimeSample) {
    
    $strtime = strtotime($dateTimeSample);
    $formatTimeSample = date('H:i:s', $strtime);
    
    return $formatTimeSample;
}

function customDate($dateTimeSample) {
    
    $strtime = strtotime($dateTimeSample);
    $formatTimeSample = date('d/m/Y', $strtime);
    
    return $formatTimeSample;
}

function customDateTime($dateTimeSample) {
    
    if($dateTimeSample == '') {
        $formatTimeSample = '-';
    } else {
        $strtime = strtotime($dateTimeSample);
        $formatTimeSample = date('d/m/Y H:i:s', $strtime);
    }
    
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
                            <h1 class="m-0">Sampel Laboratorium</h1>
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
                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Belum Dibarcode</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Sample Barcode</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Barcode Periode</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php
                        $filter_outlet = "";
                        $submit = isset($_POST['name_outlet_filter']) ? $_POST['name_outlet_filter'] : '';
                        $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
                        $date_filter2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';
 
                        if ($submit != '') {
                            # code...
                            $filter_outlet = $_POST['name_outlet_filter'];
                        }
                        ?>
                        <div class="tab-pane active" id="tab_1">
                            <form action="" method="POST">
                                <div class="row ml-1">
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter" value="<?= $_POST['date_filter']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter2" value="<?= $_POST['date_filter2'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <select class="select2bs4 form-control form-control-sm" id="name_outlet_filter" name="name_outlet_filter">
                                                <option value="Semua" <?php if($submit == 'Semua') {echo 'selected';} ?>>Semua Outlet</option>
                                                <?php
                                                $query = "SELECT * FROM master_outlet";
                                                $fetch = mysqli_query($conn, $query);
                                                while ($result = mysqli_fetch_array($fetch)) { ?>
                                                    <option value="<?= $result['id'] ?>" <?php if($result['id'] == $submit) {echo 'selected';} ?>><?= $result['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <form action="../admin/laboratorium/generate_multiple_barcodelab.php" method="post" target="blank" onsubmit="var r = confirm('Apakah anda yakin untuk generate barcode ?'); if (r == true){setTimeout(function () { window.location.reload(); }, 2000); return true;} else {event.preventDefault; return false;}">
                                    <input type="hidden" name="batchnumber" value="<?= $batchNo ?>">
                                    <button type="submit" class="btn btn-warning btn-sm mt-3 ml-1"><i class="fas fa-barcode fa-xs"></i> Generate Barcode</button>
                                    <table id="dataSampleLab" class="table table-bordered table-striped text-xs">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID Transaksi</th>
                                                <th>Tgl Tindakan</th>
                                                <th>Waktu Sample</th>
                                                <th>NIK/Passport</th>
                                                <th>Nama Pasien</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Nama Outlet/Faskes</th>
                                                <th>Jenis Tindakan</th>
                                                <th>Kode Barcode</th>
                                                <!--<th>Aksi</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $filter_outlet_now = '%' . $filter_outlet . '%';
                                            if($date_filter != '' && $date_filter2 != '') {
                                                if ($submit == '' || $submit == 'Semua') {
                                                $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.dateOfBirth tglLahir, master_outlet.name, master_tindakan.typeTindakan,
                                                master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime FROM `transaksi_rawat_jalan` 
                                                join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                                on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE transaksi_rawat_jalan.status = 'On Process' and master_tindakan.typeTindakan = 'PCR' and transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.id desc";
                                                } else {
                                                    $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.dateOfBirth tglLahir, master_outlet.name, master_tindakan.typeTindakan,
                                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime FROM `transaksi_rawat_jalan` 
                                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE transaksi_rawat_jalan.status = 'On Process' and master_tindakan.typeTindakan = 'PCR' and transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' and master_outlet.id like '$filter_outlet_now' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.id desc";
                                                }
                                            } else {
                                                if ($submit == '' || $submit == 'Semua') {
                                                $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.dateOfBirth tglLahir, master_outlet.name, master_tindakan.typeTindakan,
                                                master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime FROM `transaksi_rawat_jalan` 
                                                join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                                on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE transaksi_rawat_jalan.status = 'On Process' and master_tindakan.typeTindakan = 'PCR' and transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' order by transaksi_rawat_jalan.id desc";
                                                } else {
                                                    $query = "SELECT transaksi_rawat_jalan.id, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.dateOfBirth tglLahir, master_outlet.name, master_tindakan.typeTindakan,
                                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.sampleTime FROM `transaksi_rawat_jalan` 
                                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE transaksi_rawat_jalan.status = 'On Process' and master_tindakan.typeTindakan = 'PCR' and transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' and master_outlet.id like '$filter_outlet_now' order by transaksi_rawat_jalan.id desc";
                                                }
                                            }
                                            $fetch = mysqli_query($conn, $query);
                                            $no = 1;
                                            while ($result = mysqli_fetch_array($fetch)) { ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($result['barcodeLab'] == 'Belum dibarcode') { ?>
                                                            <input type="checkbox" name="generate[]" value="<?php echo $result['id']; ?>">
                                                        <?php  } ?>
                                                    </td>
                                                    <td><?= $result['transaksiID'] ?></td>
                                                    <td><?= customDate($result['tglTindakan']) ?></td>
                                                    <td><?php if ($result['sampleTime'] == null) {echo 'Sampel belum diambil';} else {echo customDateFormat($result['sampleTime']);} ?></td>
                                                    <td><?= $result['nik'] ?></td>
                                                    <td><?= $result['name_pasien'] ?></td>
                                                    <td><?= customDate($result['tglLahir']); ?></td>
                                                    <td><?= $result['name'] ?></td>
                                                    <td><?= $result['name_tindakan'] ?></td>
                                                    <td><?= $result['barcodeLab'] ?></td>
                                                    <!--<td>-->
                                                        <!-- <a href="../admin/laboratorium/generate_barcode_lab.php?idTransaction=<?= $result['transaksiID'] ?>&nik=<?= $result['nik'] ?>" class="btn btn-info btn-sm <?php if ($result['barcodeLab'] != 'Belum dibarcode') {
                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                            } ?>" title="Generate Barcode" onclick="var r = confirm('Apakah kamu yakin sudah menerima sample ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-barcode fa-sm" aria-hidden="true"></i></a> -->
                                                        <?php if ($fetchRole['roleName'] == 'Superadmin') { ?>
                                                            <!--<a href="../admin/laboratorium/canceled_barcode_lab.php?idTransaction=<?= $result['transaksiID'] ?>&nik=<?= $result['nik'] ?>" class="btn btn-danger btn-xs <?php if ($result['barcodeLab'] == 'Belum dibarcode') {
                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                            } ?>" title="Batalkan Barcode" onclick="var r = confirm('Apakah kamu yakin membatalkan sampel barcode ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-barcode fa-sm" aria-hidden="true"></i></a> -->

                                                        <?php   } ?>
                                                    <!--</td>-->


                                                </tr>

                                            <?php   } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <?php
                            $filter_batch_number = "";

                            if (isset($_POST['batchNumber'])) {
                                # code...
                                $filter_batch_number = $_POST['batchNumber'];
                            }
                            ?>
                            <form action="" method="POST">
                                <div class="row justify-content-between">
                                    <div class="col-md-4">
                                        <div class="input-group mb-3">
                                            <select id="batchNumber" name="batchNumber" class="custom-select custom-select-sm" size="1">
                                                <option value="">Pilih Batch Number Export</option>
                                                <?php
                                                $query = "SELECT DISTINCT batchNumber FROM transaksi_rawat_jalan WHERE batchNumber IS NOT NULL ORDER BY batchNumber ASC";
                                                $fetch = mysqli_query($conn, $query);
                                                while ($result = mysqli_fetch_array($fetch)) { ?>
                                                    <option value="<?= $result['batchNumber'] ?>" <?php if($result['batchNumber'] == $filter_batch_number) {echo 'selected';} ?>><?= $result['batchNumber'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn btn-outline-secondary btn-sm" type="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-xs" id="tableSampleBarcode">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barcode Lab</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Nama Tindakan</th>
                                            <th>Barcode Lab Time</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $filter_batch_number_now = '%' . $filter_batch_number . '%';
                                        $no = 1;
                                        $queryGetSampleBarcode = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.transaksiID, master_pasien.name, master_pasien.nik, master_pasien.dateOfBirth tglLahir, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime FROM transaksi_rawat_jalan 
                                        JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE NOT transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' AND transaksi_rawat_jalan.batchNumber LIKE '$filter_batch_number_now' order by transaksi_rawat_jalan.barcodeLab desc limit 500");
                                        if ($queryGetSampleBarcode->num_rows > 0) {
                                            # code...
                                            while ($fetchSampleBarcode = $queryGetSampleBarcode->fetch_array()) { ?>

                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $fetchSampleBarcode['barcodeLab']; ?></td>
                                                    <td><?= $fetchSampleBarcode['name']; ?></td>
                                                    <td><?= customDate($fetchSampleBarcode['tglLahir']); ?></td>
                                                    <td><?= $fetchSampleBarcode['name_tindakan']; ?></td>
                                                    <td><?=  customDateTime($fetchSampleBarcode['barcodeLabTime']); ?></td>
                                                    <td>
                                                        <!-- <a href="../admin/laboratorium/generate_barcode_lab.php?idTransaction=<?= $result['transaksiID'] ?>&nik=<?= $result['nik'] ?>" class="btn btn-info btn-sm <?php if ($result['barcodeLab'] != 'Belum dibarcode') {
                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                            } ?>" title="Generate Barcode" onclick="var r = confirm('Apakah kamu yakin sudah menerima sample ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-barcode fa-sm" aria-hidden="true"></i></a> -->
                                                        <?php if (in_array("Superadmin", $arrayRoleName)) { ?>
                                                            <a href="../admin/laboratorium/canceled_barcode_lab.php?idTransaction=<?= $fetchSampleBarcode['transaksiID'] ?>&nik=<?= $fetchSampleBarcode['nik'] ?>" class="btn btn-danger btn-xs <?php if ($result['barcodeLab'] == 'Belum dibarcode') {
                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                            } ?>" title="Batalkan Barcode" onclick="var r = confirm('Apakah kamu yakin membatalkan sampel barcode ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-barcode fa-sm" aria-hidden="true"></i></a>
                                                        <?php   } ?>
                                                        
                                                        <?php if(in_array("Superadmin", $arrayRoleName) || in_array("Admin", $arrayRoleName)) { ?>
                                                            <a href="../admin/laboratorium/print_single_barcode_lab.php?barcodeLab=<?= $fetchSampleBarcode['barcodeLab'] ?>" target="blank" class="btn btn-default btn-xs <?php if ($result['barcodeLab'] == 'Belum dibarcode') {
                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                            } ?>" title="Print Barcode Lab"><i class="fa fa-print fa-sm" aria-hidden="true"></i></a>
                                                        <?php    } ?>
                                                   </td>
                                                </tr>
                                        <?php  }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
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
                                                <option value="Semua" <?php if($barcodeLab == 'Semua') {echo 'selected';} ?>>Semua</option>
                                                <option value="Belum dibarcode" <?php if($barcodeLab == 'Belum dibarcode') {echo 'selected';} ?>>Belum dibarcode</option>
                                                <option value="Sudah dibarcode" <?php if($barcodeLab == 'Sudah dibarcode') {echo 'selected';} ?>>Sudah dibarcode</option>
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
                            </form>
                            <div class="row">
                                    <?php
                                    $sessionError =  isset($_SESSION['errorDateMessage']) ? $_SESSION['errorDateMessage'] : '';
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
                                <table class="table table-bordered table-striped text-xs" id="tableBarcodePeriode">
                                    <thead>
                                        <tr>
                                            <th>Tgl Tindakan</th>
                                            <th>Barcode Lab</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Nama Outlet</th>
                                            <th>Nama Tindakan</th>
                                            <th>Barcode Lab Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if ($barcodeLab != 'Semua') {
                                            # code...
                                            $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.dateOfBirth tglLahir, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet 
                                        FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                        WHERE NOT transaksi_rawat_jalan.status = 'Open' AND NOT transaksi_rawat_jalan.status = 'Paid' AND master_tindakan.typeTindakan = 'PCR' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter' AND 
                                        (CASE WHEN transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' THEN 'Belum dibarcode' WHEN transaksi_rawat_jalan.barcodeLab != 'Belum dibarcode' THEN 'Sudah dibarcode' END) IN ('$barcodeLab')");
                                        } else {
                                            $queryGetBarcodePeriode = $conn->query("SELECT transaksi_rawat_jalan.tglTindakan, transaksi_rawat_jalan.barcodeLab, master_pasien.name, master_pasien.dateOfBirth tglLahir, master_tindakan.name name_tindakan, transaksi_rawat_jalan.barcodeLabTime, master_outlet.name name_outlet 
                                        FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id 
                                        WHERE NOT transaksi_rawat_jalan.status = 'Open' AND NOT transaksi_rawat_jalan.status = 'Paid' AND master_tindakan.typeTindakan = 'PCR' AND transaksi_rawat_jalan.tglTindakan BETWEEN '$dateFrom' AND '$dateAfter'");
                                        }

                                        if ($queryGetBarcodePeriode->num_rows > 0) {
                                            # code...
                                            while ($fetchSampleBarcodePeriode = $queryGetBarcodePeriode->fetch_array()) { ?>

                                                <tr>
                                                    <td><?= customDate($fetchSampleBarcodePeriode['tglTindakan']); ?></td>
                                                    <td><?= $fetchSampleBarcodePeriode['barcodeLab']; ?></td>
                                                    <td><?= $fetchSampleBarcodePeriode['name']; ?></td>
                                                    <td><?= customDate($fetchSampleBarcodePeriode['tglLahir']); ?></td>
                                                    <td><?= $fetchSampleBarcodePeriode['name_outlet']; ?></td>
                                                    <td><?= $fetchSampleBarcodePeriode['name_tindakan']; ?></td>
                                                    <td><?=  customDateTime($fetchSampleBarcodePeriode['barcodeLabTime']); ?></td>
                                                </tr>
                                        <?php  }
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