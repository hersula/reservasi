<?php

include('../connection.php');
include('../helper/base_url.php');

$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
$pasienID = isset($_GET['noPasien']) ? $_GET['noPasien'] : '';

if ($idTransaction =='' || $pasienID == '') {
    # code...
    header('location:' . BASE_URL);
}

$query = $conn->query("SELECT transaksi_rawat_jalan.transaksiID, transaksi_rawat_jalan.resultTime, master_hasil_tes.hasil, master_pasien.nik, master_pasien.passport, master_pasien.name, master_pasien.gender, master_pasien.dateOfBirth, master_pasien.passport FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_hasil_tes ON master_hasil_tes.idTransaction = transaksi_rawat_jalan.transaksiID WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' AND transaksi_rawat_jalan.pasienID ='$pasienID'");
$fetch = $query->fetch_array();

function numberID($nik, $passport) {
    if($nik != '' && $passport == '') {
        return $nik;
    } else if ($nik != $passport && $passport != '') {
        return $nik . ' / ' . $passport;
    } else if ($nik == $passport) {
        return $passport;
    } else if ($nik == '' && $passport != '') {
        return $passport;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="../images/LogoNorbuMedika.png">
</head>
<body style="background-color: #17AE9D;">
    <div class="container py-5 my-5">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Laporan Hasil Tindakan / <span style="font-style: italic">Examination Result For</span> <?= $fetch['name'] ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>ID Transaksi / <span style="font-style: italic">Transaction ID</span></th>
                            <td><?= $fetch['transaksiID'] ?></td>
                        </tr>
                        <tr>
                            <th>NIK / <span style="font-style: italic">ID Number</span></th>
                            <td>
                                <?php 
                                
                                // if($fetch['nik'] == '') {echo $fetch['passport'];} else {echo $fetch['nik'];} 
                                $nik        = isset($fetch['nik']) ? $fetch['nik'] : '';
                                $passport   = isset($fetch['passport']) ? $fetch['passport'] : '';
                                
                                echo numberID($nik, $passport)
                                
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin / <span style="font-style: italic">Gender</span></th>
                            <td><?= $fetch['gender'] ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir / <span style="font-style: italic">Date of Birth</span></th>
                            <td><?= $fetch['dateOfBirth'] ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Hasil / <span style="font-style: italic">Date Result</span></th>
                            <td><?= $fetch['resultTime'] ?></td>
                        </tr>
                        <tr>
                            <th>Hasil Tes / <span style="font-style: italic">Test Result</span></th> 	
                            <td><span class="<?php if($fetch['hasil'] == 'Positif') {echo 'text-danger';} ?>" style="font-weight: bold; <?php if($fetch['hasil'] == 'Negatif') {echo 'color: #98FB98';} ?>"><?= $fetch['hasil'] ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>