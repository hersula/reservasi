<?php

$roleIDlist = $_SESSION['roleID'];
$query = $conn->query("select * from master_roles join karyawan_role_list on master_roles.id = karyawan_role_list.rolesID where karyawan_role_list.id = '$roleIDlist'");

$fetchRole = $query->fetch_array();

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
    $formatTimeSample = date('d/m/Y H:i:s', $strtime);
    
    return $formatTimeSample;
 }
 
 $filter_outlet = "";

$submit = isset($_POST['name_outlet_filter']) ? $_POST['name_outlet_filter'] : '';

if ($submit != '') {
    # code...
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : ''; 
    $date_filter2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';
    $filter_outlet = isset($_POST['name_outlet_filter']) ? $_POST['name_outlet_filter'] : '';
    
    if ($date_filter > $date_filter2) {
            # code...
            $_SESSION['errorDateMessageAntigen'] = "Maaf tanggal pertama tidak boleh melewati tanggal kedua";
    } else {
        unset($_SESSION['errorDateMessageAntigen']);
    }
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
                                <li class="breadcrumb-item active">Hasil PCR</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-md mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter" value="<?= $_POST['date_filter'] ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-md mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter2" value="<?= $_POST['date_filter2'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <select class="select2bs4 form-control form-control-sm" id="name_outlet_filter" name="name_outlet_filter">
                                                <option value="Semua" <?php if($filter_outlet == 'Semua') {echo 'selected';} ?>>Semua Outlet</option>
                                                <?php
                                                $query = "SELECT * FROM master_outlet";
                                                $fetch = mysqli_query($conn, $query);
                                                while ($result = mysqli_fetch_array($fetch)) { ?>
                                                    <option value="<?= $result['id'] ?>" <?php if($result['id'] == $filter_outlet) {echo 'selected';} ?>><?= $result['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="table-responsive">
                        <table id="dataRiwayatTindakan" class="table table-bordered table-striped text-xs">
                            <thead>
                                <tr>
                                    <th>Kode Barcode</th>
                                    <th>NIK</th>
                                    <th>Nama Pasien</th>
                                    <th>Nama Outlet/Faskes</th>
                                    <th>Jenis Tindakan</th>
                                    <th>Input Time</th>
                                    <th>Hasil Tes</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $filter_outlet_now = '%' . $filter_outlet . '%';
                                if($date_filter != '' && $date_filter2 != '') {
                                    if ($submit == '' || $submit == 'Semua') {
                                    $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.phone, master_pasien.name name_pasien, master_outlet.name,
                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.createdAt waktu_tindakan, transaksi_rawat_tindakan.sampleTime FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id  AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'  WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'PCR' and not transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' order by transaksi_rawat_jalan.transaksiID desc";
                                    } else {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.phone, master_pasien.name name_pasien, master_outlet.name,
                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.createdAt waktu_tindakan, transaksi_rawat_tindakan.sampleTime FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id  AND transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2'  WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'PCR' and not transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' and master_outlet.id like '$filter_outlet_now' order by transaksi_rawat_jalan.transaksiID desc";
                                    }
                                } else {
                                    if ($submit == '' || $submit == 'Semua') {
                                    $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.phone, master_pasien.name name_pasien, master_outlet.name,
                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.createdAt waktu_tindakan, transaksi_rawat_tindakan.sampleTime FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'PCR' and not transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' order by transaksi_rawat_jalan.transaksiID desc";
                                    } else {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.status status_tindakan, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.phone, master_pasien.name name_pasien, master_outlet.name,
                                    master_tindakan.name name_tindakan, transaksi_rawat_jalan.createdAt waktu_tindakan, transaksi_rawat_tindakan.sampleTime FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'PCR' and not transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode' and master_outlet.id like '$filter_outlet_now' order by transaksi_rawat_jalan.transaksiID desc";
                                    }
                                }
                                $fetch = mysqli_query($conn, $query);
                                $no = 1;
                                while ($result = mysqli_fetch_array($fetch)) { ?>

                                    <?php
                                    $idTransaction  = $result['transaksiID'];
                                    $pasienID       = $result['pasienID'];
                                    $phone          = $result['phone'];
                                    $substr_phone   = substr($phone, '1');
                                    $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
         join master_pasien c on a.idPasien = c.id where a.idTransaction ='$idTransaction' and a.idPasien = '$pasienID'");

                                    $fetch_row = $cek_row->fetch_array();
                                    $num_rows = $cek_row->num_rows;

                                    ?>
                                    <tr>
                                        <td><?= $result['barcodeLab'] ?></td>
                                        <td><?= $result['nik'] ?></td>
                                        <td><?= $result['name_pasien'] ?></td>
                                        <td><?= $result['name'] ?></td>
                                        <td><?= $result['name_tindakan'] ?></td>
                                        <td><?= customDateFormat($result['waktu_tindakan']) ?></td>
                                        <td>
                                            <?php if ($num_rows > 0) { ?>
                                                <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                    # code...
                                                                    echo 'btn-info';
                                                                } else {
                                                                    echo 'btn-danger';
                                                                } ?> btn-xs"><?= $fetch_row['hasil'] ?></div>
                                            <?php } else { ?> <div class="btn btn-warning btn-xs">Waiting</div> <?php }  ?>
                                        </td>
                                        <td>
                                            <?php if ($num_rows <= 0) {
                                                // <!-- # code... -->
                                                if($result['status_tindakan'] =='On Process') {
                                                    echo '<a href="admin.php?page=input-hasil-pcr&idTransaction=' . $result['transaksiID'] . '&pasienID=' . $result['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';    
                                                }
                                                
                                            } else {
                                                echo '<a href="'.BASE_URL. 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] . '&noPasien=' . $result['pasienID'] . '" target="blank" class="btn btn-info btn-xs" title="Lihat atau Cetak Hasil"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                            }?>
                                            <?php if ($result['status_tindakan'] == 'Close') {
                                                # code...
                                                // echo '<a href="" target="blank" class="btn btn-success btn-xs" title="Kirim Hasil"><i class="fa fa-paper-plane fa-sm" aria-hidden="true"></i></a>';
                                                echo '<a href="https://api.whatsapp.com/send?phone=62'.$substr_phone.'&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$result['name_pasien'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20PCR%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] .'%26noPasien='.$result['pasienID'].'" class="btn btn-success btn-xs title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-md" aria-hidden="true"></i></a>';
                                            } ?>
                                        </td>
                                        
                                    </tr>

                                <?php   } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>