<?php
    
     function directAdmin() {
        echo '<script>window.location = "admin.php"</script>';
    }
    $_SESSION['date_more'] = 'error';
    
    if (isset($_POST['submit'])) {
        # code...
        $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : ''; 
        $date_filter2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';
        $select_outlet = isset($_POST['select_outlet']) ? $_POST['select_outlet'] : '';
        $_SESSION['outletSelectedAntigen'] = $select_outlet;
        
        if ($date_filter > $date_filter2) {
            # code...
            $_SESSION['errorDateMessageAntigen'] = "Maaf tanggal pertama tidak boleh melewati tanggal kedua";
        } else {
            unset($_SESSION['errorDateMessageAntigen']);
        }
    }
    
    $outletID = $_SESSION['outletID'];
    $selected_outlet = isset($_SESSION['outletSelectedAntigen']) ? $_SESSION['outletSelectedAntigen'] : '';
    if($selected_outlet != '0') {
        if($selected_outlet == '') {
        $get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id = '$outletID'");    
        } else {
        $get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id = '$selected_outlet'");    
        }
        $fetch_name_outlet = $get_name_outlet->fetch_array();
        $name_outlet_is = $fetch_name_outlet['name'];
    } 
    
    $queryGetFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outlet_id'");
    $isFaskes       = $queryGetFaskes->fetch_array();
    
    $arrayRoleName = $_SESSION['rolesName'];
    
    if($isFaskes['isFaskes'] == '1' || in_array("Faskes", $arrayRoleName)) { 
        directAdmin();
    }
     /*log file*/
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
        values ('$_SESSION[idKaryawan]',NOW(),'Lihat halaman hasil antigen') ";
    mysqli_query($conn, $sql_query1);
    /*log file*/

?>
<section class="content">
    <div class="container-fluid">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Sampel Hasil Antigen <?php if($selected_outlet == '0') {echo 'Semua Outlet';} else {echo $name_outlet_is;}?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
                                <li class="breadcrumb-item active">Antigen</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter" value="<?= $_POST['date_filter'] ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm mr-3" placeholder="Input outlet name" aria-label="Recipient's username" aria-describedby="button-addon2" name="date_filter2" value="<?= $_POST['date_filter2'] ?>">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <select name="select_outlet" id="select_outlet" class="custom-select custom-select-sm mr-3" required>
                                        <option value="">Pilih Outlet</option>
                                        <option value="0" <?php
                                              if($selected_outlet == '0'){
                                                echo "selected";
                                              } ?>>Semua Outlet</option>
                                        <?php
                                        $queryOutlet = $conn->query("SELECT * FROM master_outlet WHERE isFaskes='0' AND status='Aktif'");
                                        while ($fetchOutlet = $queryOutlet->fetch_array()) { ?>
                                            <option value="<?= $fetchOutlet['id'] ?>" <?php
                                              if($fetchOutlet['id'] == $selected_outlet){
                                                echo "selected";
                                              } ?>><?= $fetchOutlet['name'] ?></option>
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
                        <table id="dataHasilTesAntigen" class="table table-striped text-xs">
                            <thead>
                                <tr>
                                    <th>Id Transaction</th>
                                    <th>NIK</th>
                                    <th>Nama Pasien</th>
                                    <th>Jenis Tindakan</th>
                                    <th>Tanggal Tindakan</th>
                                    <th>Nama Outlet</th>
                                    <th>Status</th>
                                    <th>Hasil Tes</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $dateNow = date('Y-m-d');
                                if($date_filter != '' && $date_filter2 != '') {
                                    if($selected_outlet  == '') {
                                    $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and 
                                    transaksi_rawat_jalan.outletID = '$outletID' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.id desc";
                                    } else if ($selected_outlet == '0') {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.id desc";
                                    } else {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet,transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and 
                                    transaksi_rawat_jalan.outletID = '$selected_outlet' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan BETWEEN '$date_filter' AND '$date_filter2' order by transaksi_rawat_jalan.id desc";
                                    }
                                } else {
                                    if($selected_outlet  == '') {
                                    $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and 
                                    transaksi_rawat_jalan.outletID = '$outletID' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan like '%$dateNow%' order by transaksi_rawat_jalan.id desc";
                                    } else if ($selected_outlet == '0') {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet, transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan like '%$dateNow%' order by transaksi_rawat_jalan.id desc";
                                    } else {
                                        $query = "SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.pasienID, transaksi_rawat_jalan.barcodeLab, master_pasien.nik, master_pasien.name name_pasien, master_pasien.phone, transaksi_rawat_jalan.status,
                                    master_tindakan.name name_tindakan, master_outlet.name name_outlet,transaksi_rawat_jalan.tglTindakan FROM `transaksi_rawat_jalan` 
                                    join master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id join master_outlet 
                                    on master_outlet.id = transaksi_rawat_jalan.outletID join master_tindakan on transaksi_rawat_jalan.tindakanID = master_tindakan.id WHERE not transaksi_rawat_jalan.status = 'Paid' and 
                                    transaksi_rawat_jalan.outletID = '$selected_outlet' and master_tindakan.typeTindakan = 'Antigen' and transaksi_rawat_jalan.tglTindakan like '%$dateNow%' order by transaksi_rawat_jalan.id desc";
                                    }
                                }
                                
                                //echo $query;
                                
                                $fetch = mysqli_query($conn, $query);
                                $no = 1;
                                while ($result = mysqli_fetch_array($fetch)) { ?>
                                    <?php
                                    $idTransaction  = $result['transaksiID'];
                                    $pasienID       = $result['pasienID'];
                                    $phone          = $result['phone'];
                                    $substr_phone   = (substr(trim($phone), 0, 1)=='0') ? '62' .substr($phone, '1') : $phone;;
                                    $cek_row = $conn->query("select a.* from master_hasil_tes a join transaksi_rawat_jalan b on a.idTransaction = b.transaksiID 
                                    join master_pasien c on a.idPasien = c.id where a.idTransaction ='$idTransaction' and a.idPasien = '$pasienID'");

                                    $num_rows = !empty($cek_row) ? $cek_row->num_rows : 0;
                                    if ($num_rows > 0) {
                                        # code...
                                        $fetch_row = $cek_row->fetch_array();
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $result['transaksiID'] ?></td>
                                        <td><?= $result['nik'] ?></td>
                                        <td><?= $result['name_pasien'] ?></td>
                                        <td><?= $result['name_tindakan'] ?></td>
                                        <td><?= $result['tglTindakan'] ?></td>
                                        <td><?= $result['name_outlet'] ?></td>
                                        <td><?= $result['status'] ?></td>
                                        <td>
                                            <?php if ($num_rows > 0) { ?>
                                                <div class="btn <?php if ($fetch_row['hasil'] == 'Negatif') {
                                                                    # code...
                                                                    echo 'btn-info';
                                                                } else {
                                                                    echo 'btn-danger';
                                                                } ?> btn-xs"><?= $fetch_row['hasil'] ?></div>
                                            <?php } else if($result['status'] == 'Failed') {?> <div class="btn btn-danger btn-xs">Failed</div> <?php }  else { ?> <div class="btn btn-warning btn-xs">Waiting</div> <?php }  ?>
                                        </td>
                                        <td>
                                            <?php if ($num_rows <= 0) {
                                                // <!-- # code... -->
                                                if ($result['status'] =='On Process') {
                                                    echo '<a href="admin.php?page=input-hasil-antigen&idTransaction=' . $result['transaksiID'] . '&pasienID=' . $result['pasienID'] . '" class="btn btn-warning btn-xs" title="Input Hasil"><i class="fa fa-edit fa-sm" aria-hidden="true"></i></a>';
                                                }
                                                } else {
                            
                                                echo '<a href="'.BASE_URL. 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] . '&noPasien=' . $result['pasienID'] . '" target="blank" class="btn btn-info btn-xs mr-1" title="Lihat atau Cetak Hasil"><i class="fa fa-file-pdf fa-sm" aria-hidden="true"></i></a>';
                                                
                                                echo '<a href="https://api.whatsapp.com/send?phone='.$substr_phone.'&text=Halo%2C%20%0AYth%20Mr%2FMrs%20'.$result['name_pasien'].'.%0AKami%20dari%20Norbu%20Medika%20ingin%20memberikan%20informasi%20bahwa%20hasil%20tes%20Antigen%20sudah%20selesai.%20Silahkan%20kunjungi%20halaman%20berikut%20ini%20%3A%20%0A' . BASE_URL . 'PDF/hasil_pasien.php?idTransaction=' . $result['transaksiID'] .'%26noPasien='.$result['pasienID'].'%0AGunakan%20tanggal%20lahir%20Anda%20dalam%20bentuk%20DDMM%20(dua%20digit%20tanggal%20lahir%20dan%20dua%20digit%20bulan)%20untuk%20membuka%20file%20tersebut.%0A%0ABilamana%20Anda%20membuka%20alamat%20diatas%20menggunakan%20ponsel%20tipe%20ANDROID%2C%20maka%20hasil%20test%20akan%20langsung%20terunduh%20ke%20dalam%20folder%20Document%20%2F%20Download%20di%20ponsel%20Anda" class="btn btn-success btn-xs title="Kirim Hasil" target="blank"><i class="fab fa-whatsapp fa-md" aria-hidden="true"></i></a>';
                                                
                                            
                                            } ?>
                                            <?php if(in_array("Superadmin", $arrayRoleName)) { ?>
                                                <?php if($num_rows > 0) { ?>
                                                    <a href="../admin/laboratorium/cancel_hasil.php?id=<?= $result['transaksiID'] ?>&pasienID=<?= $result['pasienID'] ?>" class="btn btn-xs bg-dark" title="Batalkan Hasil" onclick="var r = confirm('Apakah ingin membatalkan hasil tindakan ini ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fa fa-trash fa-sm" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            <?php } ?>
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