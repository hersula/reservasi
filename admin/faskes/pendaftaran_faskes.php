<?php 

    include "../../helper/base_url.php";

    function directAdmin() {
        echo '<script>window.location = "admin.php"</script>';
    }
    
    $outletID = $_SESSION['outletID'];
    $isFaskes = $_SESSION['isFaskes'];
    
    $arrayRoleName = $_SESSION['rolesName'];
    
    if($isFaskes != '1' && !in_array("Superadmin", $arrayRoleName) && !in_array("Faskes", $arrayRoleName)) {
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
                        <li class="breadcrumb-item"><a href="<?=BASE_URL?>admin/admin.php">Home</a></li>
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
                        <form action="<?= BASE_URL . 'admin/faskes/transaction_proses.php' ?>" method="POST"  onsubmit="return send()">
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
                                            <select type="text" class="form-control select2 form-control-sm" id="isWNA" name="isWNA" required>
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
                                            <select type="text" class="form-control select2 form-control-sm" id="gender" name="gender" required>
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
                                    <h4 class="my-3">Data Transaksi</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-sm">Nama Outlet/Faskes <span class="text-warning">*</span></label>
                                            <?php
                                            if ($isFaskes != '0') {
                                                # code...
                                                $query = "SELECT * FROM master_outlet WHERE id='$outletID'";
                                                $fetch = mysqli_query($conn, $query);
                                                while ($result = mysqli_fetch_array($fetch)) { ?>
                                                    <input type="hidden" class="form-control form-control-sm" id="outletID" name="outletID" value="<?= $result['id'] ?>" readonly />
                                                    <input type="text" class="form-control form-control-sm" value="<?= $result['name'] ?>" readonly />
                                                <?php }
                                            } else { ?>
                                                <select id="outletID" name="outletID" class="custom-select custom-select-sm outletID" required>
                                                    <option value="">Pilih Tindakan</option>
                                                    <?php
                                                    $query = "SELECT * FROM master_outlet WHERE isFaskes ='1'";
                                                    $fetch = mysqli_query($conn, $query);
                                                    while ($result = mysqli_fetch_array($fetch)) { ?>

                                                        <option value="<?= $result['id'] ?>"><?= $result['name'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-sm">Jenis Tindakan</label>
                                                <?php
                                            if ($isFaskes != '0') { ?>
                                                <select id="tindakanID" name="tindakanID" class="custom-select custom-select-sm" required>
                                                    <option value="">Pilih Tindakan</option>
                                                    <?php
                                                    $outletID = $_SESSION['outletID'];
                                                    $query = "SELECT outlet_tindakan_list.id, outlet_tindakan_list.outletID, outlet_tindakan_list.outletTindakan, master_tindakan.name as name_tindakan, master_tindakan.id tindakanID, master_tindakan.price FROM outlet_tindakan_list JOIN master_tindakan ON outlet_tindakan_list.outletTindakan = master_tindakan.id LEFT JOIN master_outlet ON outlet_tindakan_list.outletID = master_outlet.id WHERE master_outlet.id = $outletID";
                                                    $fetch = mysqli_query($conn, $query);
                                                    while ($result = mysqli_fetch_array($fetch)) { ?>

                                                        <option value="<?= $result['tindakanID'] ?>"><?= $result['name_tindakan']?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } else { ?>
                                                <select id="tindakanID" name="tindakanID" class="custom-select custom-select-sm" required>
                                                </select>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name='nikToday' id="nikToday">
                            <input type="hidden" name='nameToday' id="nameToday">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <script>
    $(document).ready(function() {
        $('#nik').change(function() {


            var nik = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?= BASE_URL . 'admin/faskes/search.php' ?>",
                data: {
                    nik_pasien: nik
                },
                dataType: "JSON",
                success: function(sub) {
                    let nikPasien = sub[0];
                    let namePasien = sub[1];
                    $('#nikToday').val(nikPasien);
                    $('#nameToday').val(namePasien);
                }

            });

        });

    });

    function send() {
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];

        var date = new Date();

        var day = date.getDate();

        var month = date.getMonth();

        var thisDay = date.getDay(),

            thisDay = myDays[thisDay];

        var yy = date.getYear();

        var year = (yy < 1000) ? yy + 1900 : yy;
        let nikPasien = $('#nikToday').val();
        const namaPasien = $('#nameToday').val();
        if (nikPasien !== "") {
            // let nik2 = $('#nikToday').val();
            /*
            var r = confirm(
                ` info? Data pasien dengan nik ${nikPasien} nama ${namaPasien} sudah terdaftar di sistem pada hari ini tanggal ${day} ${months[month]} ${year}`
            );
            if (r == true) {
                return true;
            } else {
                event.preventDefault;
                return false;
            }
            */
            
            alert(`Data pasien dengan nik ${nikPasien} nama ${namaPasien} sudah terdaftar di sistem pada hari ini tanggal ${day} ${months[month]} ${year}. Silahkan hubungi admin.`);
            return false;
        } else {
            var r = confirm(`yakin data sudah benar?`);
            if (r == true) {
                return true;
            } else {
                event.preventDefault;
                return false;
            }

        }
    }
    </script>