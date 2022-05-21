<?php

$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
$pasienID = isset($_GET['pasienID']) ? $_GET['pasienID'] : '';

if ($idTransaction != '') {
    # code...
    $select_trx = $conn->query("select d.transaksiID, d.pasienID, a.nik,  a.name name_pasien, b.name name_tindakan, b.typeTindakan, b.spesimen, c.name name_outlet from transaksi_rawat_jalan d join master_pasien a on d.pasienID=a.id join master_tindakan b on d.tindakanID= b.id join master_outlet c on d.outletID=c.id where d.transaksiID = '$idTransaction' && d.pasienID='$pasienID'");
    $fetch      = $select_trx->fetch_array();
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
                            <h1 class="m-0">Laporan Hasil Antigen</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/admin.php' ?>">Home</a></li>
                                <li class="breadcrumb-item active">Input Hasil Antigen</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Form Hasil Antigen</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="<?= BASE_URL . 'admin/faskes/save_hasil_antigen.php' ?>" method="POST" onsubmit="var r = confirm('Apakah data hasil sudah benar ?'); if (r == true){return true;} else {event.preventDefault; return false;}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="text-sm">NIK/Passport</label>
                                        <input type="text" class="form-control form-control-sm" value="<?= $fetch['transaksiID'] ?>" name="idTransaction" hidden />
                                        <input type="text" class="form-control form-control-sm" value="<?= $fetch['pasienID'] ?>" name="pasienID" hidden />
                                        <input type="text" class="form-control form-control-sm" value="<?= $fetch['nik'] ?>" name="nik" id="nik" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Nama Pasien</label>
                                        <input type="text" class="form-control form-control-sm" id="name" value="<?= $fetch['name_pasien'] ?>" name="name" placeholder="Nama Pasien" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Nama Tindakan</label>
                                        <input type="text" class="form-control form-control-sm" id="name_tindakan" value="<?= $fetch['name_tindakan'] ?>" name="name_tindakan" placeholder="Nama Tindakan" disabled />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Nama Outlet</label>
                                        <input type="text" class="form-control form-control-sm" name="Name" value="<?= $fetch['name_outlet'] ?>" placeholder="Name Outlet" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Pemeriksaan <span class="text-warning">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="pemeriksaan" name="pemeriksaan" value="<?php if($fetch['typeTindakan'] == "Antigen") {echo "SARS-CoV-2 Antigen";} else {echo "SARS-CoV-2 Nucleic Acid Test (RT-PCR)";} ?>" readonly />
                                        <!--<select type="text" class="custom-select custom-select-sm" name="pemeriksaan" required>-->
                                        <!--    <option value="">Pilih pemeriksaan</option>-->
                                        <!--    <option value="SARS-CoV-2 Nucleic Acid Test (RT-PCR)">SARS-CoV-2 Nucleic Acid Test (RT-PCR)</option>-->
                                        <!--    <option value="SARS-CoV-2 Antigen">SARS-CoV-2 Antigen</option>-->
                                        <!--</select>-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Jenis Spesimen <span class="text-warning">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="spesimen" value="<?= $fetch['spesimen'] ?>" readonly />
                                        <!--<select type="text" class="custom-select custom-select-sm" name="spesimen" required>-->
                                        <!--    <option value="">Pilih spesimen</option>-->
                                        <!--    <option value="AasbphaoyenNal & OobphaoyenNal">AasbphaoyenNal & OobphaoyenNal</option>-->
                                        <!--</select>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-sm">Hasil Pemeriksaan <span class="text-warning">*</span></label>
                                        <select type="text" class="custom-select custom-select-sm" name="hasil_pemeriksaan" required>
                                            <option value="">Pilih hasil pemeriksaan</option>
                                            <option value="Positif">Positif</option>
                                            <option value="Negatif">Negatif</option>
                                            <option value="Inkonklusif">Inkonklusif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-sm">Keterangan</label>
                                        <textarea type="text" class="form-control form-control-sm" name="keterangan" required placeholder="Keterangan"> </textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                </div>
                <div class="card-footer">
                    <!--<a onclick="javascript:history.back()" class="btn btn-secondary btn-sm">Back</a>-->
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    </div>
</section>