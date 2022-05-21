<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Hasil Tes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
            <li class="breadcrumb-item active">Data Hasil Tes</li>
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
            <div class="table-responsive">
              <table id="dataRiwayatTindakan" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="text-align:center;">NO.</th>
                    <th style="text-align:center;">ID TRANSAKSI</th>
                    <th style="text-align:center;">NAMA PASIEN</th>
                    <th style="text-align:center;">PEMERIKSAAN</th>
                    <th style="text-align:center;">SPESIMEN</th>
                    <th style="text-align:center;">HASIL</th>
                    <th style="text-align:center;">AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no=0;
                    $sql = "select mht.*, p.name as
                            'NamaPasien' from master_hasil_tes mht
                           join master_pasien p on p.id=mht.idPasien";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                      $no++;
                  ?>
                    <tr>
                      <td style="text-align:center;"><?php echo $no ?></td>
                      <td><?php echo $row["idTransaction"]; ?></td>
                      <td><?php echo $row["NamaPasien"]; ?></td>
                      <td><?php echo $row["pemeriksaan"]; ?></td>
                      <td><?php echo $row["spesimen"]; ?></td>
                      <td><?php echo $row["hasil"]; ?></td>
                      <td align="center">
                        <a href="admin.php?page=lihat-hasil-tes-data&id=<?php echo $row["id"]; ?>" class="btn btn-info btn-xs" title="Lihat Detail"> <i class="fas fa-eye"></i>
                        </a>
                        <a href="admin.php?page=ubah-hasil-tes-data&id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-xs" title="Ubah Data">
                          <i class="fas fa-edit"></i>
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