<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Roles Karyawan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
            <li class="breadcrumb-item active">Data Roles</li>
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
            <a href="admin.php?page=tambah-roles-data" class="btn btn-primary" title="Tambah Data"> <i class="fas fa-plus"></i> <b>Roles </b></a>     
            <div class="table-responsive">
              <table id="dataRiwayatTindakan" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="text-align:center;">NO.</th>
                    <th style="text-align:center;">NAMA ROLE</th>
                    <th style="text-align:center;">AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no=0;
                    $sql = "select * from master_roles where status='Aktif'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                      $no++;
                  ?>
                    <tr>
                      <td style="text-align:center;"><?php echo $no ?></td>
                      <td><?php echo $row["roleName"]; ?></td>
                      <td align="center">
                        <a href="admin.php?page=lihat-roles-data&id=<?php echo $row["id"]; ?>" class="btn btn-info btn-xs" title="Lihat Data">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="admin.php?page=ubah-roles-data&id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-xs" title="Ubah Data">
                          <i class="fas fa-edit"></i>
                        </a>                 
                         <a href="admin.php?page=hapus-roles-data&id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-xs" title="Hapus Data" onclick="return confirm('Data akan dihapus ?')"><i class="fas fa-trash"></i>
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