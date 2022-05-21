<?php

require '../../../connection.php';

$nik = isset($_POST['nik']) ? $_POST['nik'] : '';
$idTransaction = isset($_POST['idTransaction']) ? $_POST['idTransaction'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$barcodeLab = isset($_POST['barcodeLab']) ? $_POST['barcodeLab'] : '';
$pasienID = isset($_POST['pasienID']) ? (int)$_POST['pasienID'] : '';
$pemeriksaan = isset($_POST['pemeriksaan']) ? $_POST['pemeriksaan'] : '';
$spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : '';
$hasil_pemeriksaan = isset($_POST['hasil_pemeriksaan']) ? $_POST['hasil_pemeriksaan'] : '';
$keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
$idTarget = isset($_POST['idTarget']) ? $_POST['idTarget'] : '';
$nameTargetGen = isset($_POST['nameTarget']) ? $_POST['nameTarget'] : '';
$valueTarget = isset($_POST['valueTarget']) ? $_POST['valueTarget'] : '';
$nameGen = isset($_POST['nameTargetGen']) ? $_POST['nameTargetGen'] : '';
$idKaryawan = $_SESSION['idKaryawan'];

if ($pemeriksaan == '' || $spesimen == '' || $hasil_pemeriksaan == '' || $valueTarget == '') {
    # code...
    echo '<script>alert("Mohon untuk melengkapi field yang tersedia !");history.go(-1);</script>';
} else {
    $cek_barcode = $conn->query("select * from master_hasil_tes where idTransaction='$idTransaction' and idPasien='$pasienID'");

    if ($cek_barcode->num_rows > 0) {
        # code...
        echo '<script>alert("Maaf NIK/Passport ' . $nik . ' sudah ada hasil !");history.go(-1);</script>';
    } else {
        $query = $conn->query("insert into master_hasil_tes (id, idTransaction, idPasien, pemeriksaan, spesimen, hasil, keterangan, createdAt) 
                                values (null, '$idTransaction', $pasienID, '$pemeriksaan', '$spesimen', '$hasil_pemeriksaan', '$keterangan', NOW())") or die(mysqli_error($conn));

        if ($query) {
            # code...
                $query_update_gen = $conn->query("update master_hasil_tes set nameTargetGen='$nameTargetGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                for ($i = 0; $i < count($valueTarget); $i++) {
                    # code...
                    $stringGen = $valueTarget[$i].'#'.$nameGen[$i];
                    if ($i == 0) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen0='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    } else if ($i == 1) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen1='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    } else if ($i == 2) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen2='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    } else if ($i == 3) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen3='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    } else if ($i == 4) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen4='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    } else if ($i == 5) {
                        # code...
                        $query_update_gen_list = $conn->query("update master_hasil_tes set gen5='$stringGen' where idTransaction='$idTransaction' and idPasien='$pasienID'");
                    }
                }
            $query_update = $conn->query("update transaksi_rawat_jalan set status='Close', resultTime=NOW()  where transaksiID = '$idTransaction' and pasienID='$pasienID'") or die($conn->error);
            // echo '<script>alert("Data NIK/Passport ' . $nik . ' Hasil berhasil ditambahkan !");history.go(-2);</script>';
            
            $conn->query("INSERT INTO log_file (id, karyawanID, waktu, infoActivity) VALUES (null, 'idKaryawan', NOW(), 'Input hasil PCR sample barcode $barcodeLab')");
            
            echo '<script>alert("Data hasil dari '.$name.'  dengan kode barcode ' . $barcodeLab . ' berhasil ditambahkan !");window.location.href="https://reservasi.norbumedika.id/admin/admin.php?page=hasil-lab-pcr";</script>';
           
            /*log file*/
            // $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
            //                 values ('$_SESSION[idKaryawan]',NOW(),'Input hasil PCR dengan barcode nomor $barcodeLab') ";
            //   mysqli_query($conn, $sql_query1);
            /*log file*/
            
            
            
        }
    }
}
