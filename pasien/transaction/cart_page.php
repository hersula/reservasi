<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Keranjang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container">
            <div class="col-md-12 col-xs-6">

        <div class="card">
            <div class="card-header">
                <!-- <h3 class="card-title">Pilih Lokasi Outlet atau Faskes</h3> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <?php
                $nik = $_SESSION['nik'];
                $query = "SELECT temp_cart.id, master_pasien.nik, master_pasien.name, mp2.name as name_to, master_outlet.id outletID, master_outlet.name as outlet_name, master_tindakan.name as tindakan_name, temp_cart.nikTo, temp_cart.price FROM `temp_cart` 
                JOIN master_pasien on temp_cart.nik = master_pasien.nik JOIN master_outlet on master_outlet.id = temp_cart.outletID JOIN master_tindakan on master_tindakan.id = temp_cart.tindakanID JOIN master_pasien as mp2 ON mp2.nik = temp_cart.nikTo 
                WHERE master_pasien.nik ='$nik';";
                $fetch = mysqli_query($conn, $query);
                $no = 1;

                if (mysqli_num_rows($fetch) > 0) { ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Pendaftaran Untuk</th>
                                <th>Nama</th>
                                <th>Lokasi Faskes</th>
                                <th>Tindakan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php while ($result = mysqli_fetch_array($fetch)) { ?>
                            <?php $outletID = $result['outletID'] ?>
                            <tbody>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $result['nikTo'] ?></td>
                                    <td><?= $result['name_to'] ?></td>
                                    <td><?= $result['outlet_name'] ?></td>
                                    <td><?= $result['tindakan_name'] ?></td>
                                    <td><?= number_format($result['price']) ?></td>
                                    <td><a href="../transaction/delete_temp_cart.php?id=<?= $result['id'] ?>" class="btn btn-danger btn-xs" onclick="var r = confirm('Apakah tindakan ini ingin dibatalkan ?'); if (r == true){return true;} else {event.preventDefault; return false;}"><i class="fas fa-trash fa-xs"></i> Batal</a></td>
                                </tr>
                            </tbody>
                        <?php $no++;
                        } ?>

                    </table>
                    </div>
                    <?php
                    $query_total = mysqli_query($conn, "SELECT SUM(price) as sub_total FROM temp_cart WHERE nik='$nik'");
                    $fetch_total = mysqli_fetch_array($query_total);

                    ?>
                    <div class="row mt-3">
                        <div class="col-md-10"></div>
                        <div class="col-md-2 nav-link">
                            <b>Sub Total : </b>
                            <h3 style="font-size: 24px;"><?= "Rp " . number_format($fetch_total['sub_total']) ?></h3>
                        </div>
                    </div>
                    <form method="POST" action="../transaction/checkout.php?total=<?= $fetch_total['sub_total'] ?>&outletID=<?= $outletID ?>">
                        <div class="form-group mt-3 text-xs">
                                    <label for="exampleInputEmail1">Pilih tanggal tindakan <span class="text-warning">*</span></label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_tindakan" id="datepicker" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                        <div class="form-group mt-3 ">
                            <label for="exampleInputEmail1">Pilih metode pembayaran <span class="text-warning">*</span></label>
                            <select id="payment" name="payment" class="custom-select rounded-0 custom-select-sm" required>
                                <option value="4">Pembayaran Lainnya (Go-Pay, Transfer, dll)</option>
                                <option value="1">Tunai</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-sm mt-5" type="submit" onclick="var r = confirm('Apakah kamu yakin untuk melanjutkan Checkout ?'); if (r == true){return true;} else {event.preventDefault; return false;}">
                            <i class="fas fa-paper-plane fa-xs mr-2"></i>
                            Checkout Sekarang
                        </button>
                        <a class="btn btn-warning btn-sm mt-5" href="<?= BASE_URL ?>" type="submit">
                            <i class="fas fa-plus fa-xs mr-2"></i>
                            Tambahkan Tindakan Lain
                        </a>
                    </form>
                <?php    } else { ?>
                    <div class="ml-2 container">
                        <div class="row">
                            <h2>Mohon maaf anda belum memiliki Tindakan saat ini !</h2>
                        </div>
                        <div class="row">
                            <a class="btn btn-warning btn-md mt-5" href="<?= BASE_URL  ?>" type="submit">
                                <i class="fas fa-paper-plane fa-sm mr-2"></i>
                                Reservasi Tindakan PCR/Antigen
                            </a>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
        </div>
    </div>