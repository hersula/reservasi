<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lokasi Outlet/Faskes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Location</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pilih Lokasi Outlet atau Faskes</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="datatablepasien" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select * from master_outlet WHERE isFaskes = '0'";
                    $fetch = mysqli_query($conn, $query);
                    $no = 1;
                    while ($result = mysqli_fetch_array($fetch)) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['address'] ?></td>
                            <td><a href="../../helper/session_outlet_id.php?outletID=<?= $result['id'] ?>" class="btn btn-info btn-sm">Pilih Lokasi</a></td>
                        </tr>
                        
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>