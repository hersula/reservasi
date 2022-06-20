<?php

function directAdmin() {
    echo '<script>window.location = "admin.php"</script>';
}

$outletID = $_SESSION['outletID'];
$queryGetFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outlet_id'");
$isFaskes       = $queryGetFaskes->fetch_array();

$arrayRoleName = $_SESSION['rolesName'];
$targetGenID="";

if($isFaskes['isFaskes'] == '1' || in_array("Faskes", $arrayRoleName)) { 
    directAdmin();
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pendaftaran Tes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= BASE_URL . 'admin/' ?>">Home</a></li>
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
            <form action="<?= BASE_URL. 'admin/reservasi/back_proses_pendaftaran.php' ?>" method="POST" onsubmit="var r = confirm('Apakah data pasien dan tindakan sudah benar ?'); if (r == true){return true;} else {event.preventDefault; return false;}">
              <div class="card-body">
                  <div class="alert alert-info d-none" role="alert" id='alertdatapasien'>
                      Data pasien ditemukan ...
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <h4 class="mb-3">Data Pasien</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">NIK (Nomor Induk Kependudukan)</label>
                      <input type="number" class="form-control form-control-sm" name="nik" minlength="16" maxlength="16" placeholder="Identity Number (KTP/Passport)" id="nik" onkeyup="isi_otomatis()" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Passport (Opsional)</label>
                      <input type="text" class="form-control form-control-sm" id="passport" name="passport" placeholder="Identity Number (Passport)" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="name" name="name" required placeholder="Full Name" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Handphone</label>
                      <input type="text" class="form-control form-control-sm" id="phone" name="phone" required placeholder="Example: 08581928xxxx" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Kewarganegaraan</label>
                      <!--
                      <select type="text" class="custom-select custom-select-sm" id="isWNA" name="isWNA" required>
                      -->
                      <select class="form-control select2 form-control-sm" id="isWNA" name="isWNA" required>
                        <option value="">Your Citizenship</option>
                        <option value="0">WNI</option>
                        <option value="1">WNA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Country</label>
                      <select class="select2bs4 form-control form-control-sm" id="country" name="country" placeholder="Country">
                        <option value="">Country</option>
                        <?php
                        $query = "SELECT * FROM master_countries";
                        $fetch = mysqli_query($conn, $query);
                        while ($result = mysqli_fetch_array($fetch)) { ?>
                          <option value="<?= $result['country_name'] ?>"><?= $result['country_name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Jenis Kelamin <span class="text-warning">*</span></label>
                      <!--
                      <select type="text" class="custom-select custom-select-sm" id="gender" name="gender" required>
                      -->
                      <select class="form-control select2 form-control-sm" id="gender" name="gender" required>
                        <option value="">Your Gender</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Alamat <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="address" name="address" required placeholder="Address" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tempat Lahir (Kota) <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="placeOfBirth" name="placeOfBirth" required placeholder="Place of Birth (City)" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tanggal Lahir <span class="text-warning">*</span></label>
                      <input type="date" class="form-control form-control-sm" id="dateOfBirth" name="dateOfBirth" required placeholder="Date of Birth" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <h4 class="my-3">Penyelidikan Epidemiologi</h4>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="text-sm">Apakah pasien memiliki gejala? <span class="text-warning">*</span></label>
                      <select id="gejala" name="gejala" class="custom-select custom-select-sm" required>
                        <option value="">Pilih pernyataan</option>
                        <option value="Iya">Iya</option>
                        <option value="Tidak">Tidak</option>
                      </select>
                    </div>
                    <div class="form-group" id="penjelasanGejala" style="display:none;">
                      <label class="text-sm">Jelaskan gejala yang pasien alami ! <small class="text-sm text-disable">(mohon isi penjelasan jika memiliki gejala)</small></label>
                      <textarea class="form-control form-control-sm" id="tulisanGejala" placeholder="Tuliskan Gejala yang pasien alami disini" name="deskripsiGejala"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <h4 class="my-3">Data Transaksi Covid</h4>
                </div>
                <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-sm">Nama Outlet/Faskes <span class="text-warning">*</span></label>
                      <select id="outletID" name="outletID" class="custom-select custom-select-sm outletID" required >
                        <option value="">Pilih Outlet/Faskes</option>
                        <?php
                        $query = "SELECT * FROM master_outlet WHERE isFaskes='0'";
                        $fetch = mysqli_query($conn, $query);
                        while ($result = mysqli_fetch_array($fetch)) { ?>
                          <?php if ($result['id'] == $outletID) { ?>
                            <option value="<?= $result['id'] ?>" selected><?= $result['name'] ?></option>
                          <?php    } else { ?>
                            <option value="<?= $result['id'] ?>"><?= $result['name'] ?></option>
                        <?php }} ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-sm">Jenis Tindakan</label>
                      <select id="tindakanID" name="tindakanID" class="custom-select custom-select-sm" required onchange="testPrice()">
                          <option value="">Pilih Tindakan</option>
                          <?php
                        $query = "SELECT master_tindakan.id, master_tindakan.name FROM outlet_tindakan_list JOIN master_tindakan on outlet_tindakan_list.outletTindakan=master_tindakan.id WHERE outlet_tindakan_list.outletID = '$outletID'";
                        $fetch = mysqli_query($conn, $query);
                         
                        while ($result = mysqli_fetch_array($fetch)) { ?>
                            <option value="<?= $result['id'] ?>"><?= $result['name'] ?></option>
                        <?php 
                        } ?>
                      </select>
                    </div>
                  </div>
                  
                  </div>                  

                <!-- Penambahan Transaksi Lab -->
                <div class="row">
                  <h4 class="my-3">Data Transaksi Laboratorium</h4>
                </div>  
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Pemeriksaan Lab <span class="text-warning">*</span></label>
                      <select multiple="multiple" class="custom-select custom-select-sm" id="targetGenID" name="targetGenID[]" onchange="getPrice()">
                        <option value="">--Pilih Pemeriksaan Lab--</option>
                        <?php
                          $query= "select * from master_pemeriksaan where status='1'";
                          $resultTargetGen = mysqli_query($conn,$query);
                            while($rowTargetGen = mysqli_fetch_array($resultTargetGen)){
                            ?> 
                        <option value="<?php echo $rowTargetGen["id"]; ?>"
                            <?php
                              if($rowTargetGen["id"] == $targetGenID){
                                echo "selected";
                              } ?>
                              ><?php echo $rowTargetGen["name"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                </div>
                  <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="text-sm">Diskon (Nominal) </label>
                      <input type="number" class="form-control form-control-sm" id="diskon" name="diskon" placeholder="Contoh: 10000" onkeyup="testPrice()" />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="text-sm">Pajak (%) </label>
                      <input type="number" class="form-control form-control-sm" id="tax" name="tax" onkeyup="testPrice()" />
                    </div>
                  </div>
                      <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tipe Pembayaran <span class="text-warning">*</span></label>
                      <select id="paymentType" name="paymentType" class="custom-select custom-select-sm" required>
                        <option value="">Pilih pembayaran</option>
                        <?php
                        $query = "SELECT * FROM master_payment";
                        $fetch = mysqli_query($conn, $query);
                        while ($result = mysqli_fetch_array($fetch)) { ?>
                          <option value="<?= $result['id'] ?>"><?= $result['namePayment'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="penjelasanBillTo" style="display:none;">
                      <label class="text-sm">Pembayaran City Ledger Untuk </label>
                      <input type="text" class="form-control form-control-sm" id="billTo" name="billTo" placeholder="Pembayaran Untuk" />
                    </div>
                  </div>
                 </div>
                </div>
                <!-- Akhir Penambahan Transaksi Lab -->
                 <div class="row mt-5">
                  <div class="col-4">
                    <table class="table text-left ">
                      <tr>
                        <th style="width:50%">Subtotal Covid:</th>
                        <td>Rp <span id="textprice"></span>
                        </td>
                      </tr>
                      <tr>
                        <th style="width:50%">Subtotal Lab:</th>
                        <td>Rp <span id="labprice"></span>
                        </td>
                      </tr>
                      <tr>
                        <th>Tax:</th>
                        <td>Rp <span id="textTax"></span></td>
                      </tr>
                      <tr>
                        <th>Discount:</th>
                        <td>Rp <span id="textdiskon"></span></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>Rp <span id="texthasil"></span></td>
                      </tr>
                    </table>
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