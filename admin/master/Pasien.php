<?php

function customDate($dateTimeSample) {
    
    $strtime = strtotime($dateTimeSample);
    $formatTimeSample = date('d/m/Y', $strtime);
    
    return $formatTimeSample;
   }

$nik      = isset($_POST['nik']) ? $_POST['nik'] : '';
$name     = isset($_POST['name']) ? $_POST['name'] : '';


?>

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Pasien</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
            <li class="breadcrumb-item active">Data Pasien</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md">
          <br />
          <div class="col-lg-12">
            <form action="" method="POST">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label class="text-xs">NIK Pasien</label>
                    <input type="text" class="form-control form-control-sm" id="nik" name="nik" value="<?= $nik; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label class="text-xs">Nama Pasien</label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name" value="<?= $name; ?>">
                  </div>
                </div>
              </div>
              <button class="btn btn-outline-secondary btn-sm" type="submit" name="submit" id="button-addon2"><i class="fas fa-filter fa-sm"></i> Tampilkan</button>
            </form>
            <br/>
            <div class="table-responsive">
              <table id="dataRiwayatTindakanPeriode2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="text-align:center;">NO.</th>
                    <th style="text-align:center;">NIK</th>
                    <th style="text-align:center;">NAMA </th>
                    <th style="text-align:center;">ALAMAT</th>
                    <th style="text-align:center;">TANGGAL LAHIR</th>
                    <th style="text-align:center;">AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  if ($nik != '' && $name == '') {
                 
                    $sql = "select * from master_pasien where nik like '%$nik%' and status='Aktif'";
                  } else if ($nik == '' && $name != '') {
                    
                    $sql = "select * from master_pasien where name like '%$name%' and status='Aktif'";
                  } else if ($nik != '' && $name != '') {
                    
                    $sql = "select * from master_pasien where nik like '%$nik%' and name like '%$name%' and status='Aktif'";
                  } else {
                    $sql = "select * from master_pasien where status='Aktif' order by id desc limit 10";
                  }
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                    $no++;
                  ?>
                    <tr>
                      <td style="text-align:center;"><?php echo $no ?></td>
                      <td><?php echo $row["nik"]; ?></td>
                      <td><?php echo $row["name"]; ?></td>
                      <td><?php echo $row["address"]; ?></td>
                      <td><?php echo customDate($row["dateOfBirth"]); ?></td>
                      <td align="center">
                        <a href="admin.php?page=lihat-pasien-data&id=<?php echo $row["id"]; ?>" class="btn btn-info btn-xs" title="Lihat Data"> <i class="fas fa-eye"></i>
                        </a>
                        <a href="admin.php?page=ubah-pasien-data&id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-xs" title="Ubah Data">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="admin.php?page=hapus-pasien-data&id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-xs" title="Hapus Data" onclick="return confirm('Data akan dihapus ?')"><i class="fas fa-trash"></i>
                        </a>
                         <a href="admin.php?page=account-pasien-data&id=<?php echo $row["id"]; ?>" class="btn btn-success btn-xs" title="Buat Account Baru" style="background-color:#cc3399;border-color:#cc3399;"><i class="fas fa-address-card"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <!--end of div class="table-responsive"> -->
          </div>
          <!--end of form start-->
          <!-- 
          </div>
          -->
          <!--end of  div class="card card-success"-->
        </div>
      </div>
    </div>
  </div>
  <!-- /.content -->
</div>