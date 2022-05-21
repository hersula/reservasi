<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Paket Tes <?= $_SESSION['type-registration']; ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item active">Package</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="container pricing" data-aos="fade-up">
    <div class="row mb-5 pb-5 px-3">
      <?php

      $outletID = $_SESSION['outletID'];
      $query = "SELECT outlet_tindakan_list.id, outlet_tindakan_list.outletID, outlet_tindakan_list.outletTindakan, master_tindakan.name as name_tindakan, master_tindakan.id idTindakan, outlet_tindakan_list.price FROM outlet_tindakan_list JOIN master_tindakan ON outlet_tindakan_list.outletTindakan = master_tindakan.id LEFT JOIN master_outlet ON outlet_tindakan_list.outletID = master_outlet.id WHERE master_outlet.id = $outletID && outlet_tindakan_list.isVisibleToPasien = 1" ;
      $fetch = mysqli_query($conn, $query);
      while ($result = mysqli_fetch_array($fetch)) { ?>
        <div class="col-lg-3 col-md-6 <?php for ($i = 1; $i <= $result['id']; $i++) {
                                        # code...
                                        if ($i % $result['id'] == 0) {
                                          echo 'mt-4';
                                        }
                                      } ?>" data-aos="fade-up" data-aos-delay="100">
          <div class="box featured box-heig">
            <h3><?= $result['name_tindakan']; ?></h3>
            <h4><sup>Rp</sup><?= number_format($result['price']); ?></h4>
            <div class="btn-wrap">
              <a href="../transaction/session_tindakan.php?tindakanID=<?= $result['idTindakan'] ?>" class="btn-buy">Pilih Tindakan</a>
            </div>
          </div>
        </div>

      <?php } ?>
    </div>
  </div>