<?php


include '../../connection.php';
require '../../vendor/autoload.php';

$nik_barcode_lab = isset($_GET['nik']) ? $_GET['nik'] : '';
$idTransaction   = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';

if ($nik_barcode_lab != '') {
    # code...
    $query_select_softDelete = $conn->query("SELECT transaksi_rawat_jalan.barcodeLab, transaksi_rawat_jalan.softDeleteBarcode FROM `transaksi_rawat_jalan` JOIN master_pasien on transaksi_rawat_jalan.pasienID = master_pasien.id 
    WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' AND master_pasien.nik='$nik_barcode_lab'");
    $fetch_softdelete = $query_select_softDelete->fetch_array();

    $isBarcodeDeleted = $fetch_softdelete['barcodeLab'];

    if ($isBarcodeDeleted != 'Belum dibarcode') {
        # code...
        /*log file*/
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                        values ('$_SESSION[idKaryawan]',NOW(),'Cancel barcode lab') ";
        mysqli_query($conn, $sql_query1);
        /*log file*/
        $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = 'Belum dibarcode', transaksi_rawat_jalan.status = 'On Process',
        transaksi_rawat_jalan.barcodeLabTime = null, transaksi_rawat_jalan.batchNumber = null WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' && master_pasien.nik = '$nik_barcode_lab'");

        if ($query) {
            # code...
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
