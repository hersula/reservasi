<?php

include('../../connection.php');

$nik = $_GET['nik_pasien'];
$data = $conn->query(" SELECT * from master_pasien where(nik= $nik) ");
$dataPasien = $data->fetch_row();

if (!empty($dataPasien)) {

    $idpasien = $dataPasien[0];
    $tgl = DATE('Y-m-d');
    $rawat_jalan = $conn->query("SELECT nik,name FROM transaksi_rawat_jalan t INNER JOIN master_pasien ON master_pasien.id=t.pasienID WHERE pasienID='$idpasien' AND DATE(t.createdAT)='$tgl' GROUP BY pasienID ORDER BY pasienID ");
    $pasien_rawat_jalan = $rawat_jalan->fetch_row();
    echo json_encode($pasien_rawat_jalan);
} else {
    return false;
}