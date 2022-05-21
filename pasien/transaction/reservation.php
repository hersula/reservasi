<?php

$typeRegistration = isset($_GET['toRegister']) ? $_GET['toRegister'] : 'null';

if ($typeRegistration) {
  # code...
  $_SESSION['type-registration'] = $typeRegistration;
}

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pendaftaran untuk <?=  $_SESSION['type-registration']; ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item active">Pendaftaran</li>
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
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Form Pendaftaran</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="../../helper/reservation_another_pasien.php" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">NIK (Nomor Induk Kependudukan)</label>
                      <input type="text" class="form-control form-control-sm" name="nik2" placeholder="Identity Number (KTP/Passport)" maxlength="16"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Passport (Opsional)</label>
                      <input type="text" class="form-control form-control-sm" name="passport" placeholder="Identity Number (Passport)"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="name" required placeholder="Full Name" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Handphone</label>
                      <input type="text" class="form-control form-control-sm" name="phone" placeholder="Example: 08581928xxxx"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Kewarganegaraan</label>
                      <select type="text" class="custom-select custom-select-sm" name="isWNA" required>
                        <option value="">Your Citizenship</option>
                        <option value="0">WNI</option>
                        <option value="1">WNA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Country</label>
                      <input type="text" class="form-control form-control-sm" name="country" placeholder="Country"/>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Jenis Kelamin <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm" name="gender" required>
                        <option value="">Your Gender</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Alamat <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="address" required placeholder="Address" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tempat Lahir <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="placeOfBirth" required placeholder="Place of Birth"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tanggal Lahir <span class="text-warning">*</span></label>
                      <input type="date" class="form-control form-control-sm" name="dateOfBirth" required placeholder="Date of Birth" />
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>