<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">History</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="table-responsive">
        	<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tgl Tindakan</th>
                        <th>Outlet</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select distinct master_outlet.name, transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.status, transaksi_rawat_jalan.tglTindakan
                    FROM transaksi_rawat_jalan JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id WHERE NOT transaksi_rawat_jalan.status ='Failed' AND transaksi_rawat_jalan.nikAccount = '$nik' ORDER BY transaksiID DESC;";
                    $fetch = mysqli_query($conn, $query);
                    while ($result = mysqli_fetch_array($fetch)) { ?>
                        <tr>
                            <td><?= $result['transaksiID'] ?></td>
                            <td><?= $result['tglTindakan'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['status'] ?></td>
                            <td><a href="../main/index.php?page=invoice&invoice_id=<?= $result['transaksiID'] ?>" class="btn btn-info btn-sm">Lihat Detail</a></td>
                        </tr>

                    <?php }
                    ?>


                </tbody>
            </table>

        </div>
        </div>
        <!-- /.card-body -->
    </div>