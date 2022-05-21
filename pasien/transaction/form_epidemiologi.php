<?php

$typeRegistration = isset($_GET['toRegister']) ? $_GET['toRegister'] : $_SESSION['type-registration'];

if ($typeRegistration == 'Sendiri') {
    # code...
    $_SESSION['type-registration'] = $typeRegistration;
} else if ($typeRegistration == 'Orang Lain') {
    # code...
    $_SESSION['type-registration'] = $typeRegistration;
} else {
    $_SESSION['type-registration'] = 'null';
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penyelidikan Epidemiologi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                        <li class="breadcrumb-item active">Epidemiologi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container">
        <div class="card card-primary">
            <!-- <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
        </div> -->
            <!-- /.card-header -->
            <!-- form start -->
            <form action="../../helper/session_form_pe.php" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Apakah kamu memiliki gejala ? <span class="text-warning">*</span></label>
                        <select id="gejala" name="gejala" class="custom-select rounded-0" required>
                            <option value="">Pilih pernyataan</option>
                            <option value="Iya">Iya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group" id="penjelasanGejala" style="display:none;">
                        <label for="exampleInputPassword1">Jelaskan gejala yang kamu alami ! <small class="text-sm text-disable">(mohon isi penjelasan jika memiliki gejala)</small></label>
                        <textarea type="password" class="form-control" id="tulisanGejala" placeholder="Tuliskan Gejala yang kamu alami disini"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
  