<?php

require '../../connection.php';

$nik = isset($_POST['nik']) ? $_POST['nik'] : '';
$idTransaction = isset($_POST['idTransaction']) ? $_POST['idTransaction'] : '';
$pasienID = isset($_POST['pasienID']) ? (int)$_POST['pasienID'] : '';
$pemeriksaan = isset($_POST['pemeriksaan']) ? $_POST['pemeriksaan'] : '';
$spesimen = isset($_POST['spesimen']) ? $_POST['spesimen'] : '';
$hasil_pemeriksaan = isset($_POST['hasil_pemeriksaan']) ? $_POST['hasil_pemeriksaan'] : '';
$keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';


if ($pemeriksaan == '' || $spesimen == '' || $hasil_pemeriksaan == '') {
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
            $query_update = $conn->query("update transaksi_rawat_jalan set status='Close', resultTime=NOW() where transaksiID = '$idTransaction' and pasienID='$pasienID'") or die($conn->error);
            // echo '<script>alert("Data NIK/Passport ' . $nik . ' Hasil berhasil ditambahkan !");window.location.href="https://registrasi.norbumedika.id/admin/admin.php?page=hasil-lab-antigen";</script>';
            echo '<script>alert("Data NIK/Passport ' . $nik . ' Hasil berhasil ditambahkan !");window.location.href="https://reservasi.norbumedika.id/admin/admin.php?page=hasil-antigen-faskes";</script>';
        
            /*log file*/
            $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                            values ('$_SESSION[idKaryawan]',NOW(),'Input hasil Antigen') ";
              mysqli_query($conn, $sql_query1);
            /*log file*/
        }
    }
}
