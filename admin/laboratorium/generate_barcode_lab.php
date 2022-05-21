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

    $isBarcodeDeleted = $fetch_softdelete['softDeleteBarcode'];

    if ($isBarcodeDeleted == null) {
        # code...
        $fullYMD         = date('ymd');
        $thisMonth       = date('m');
        $thisYear        = date('Y');

        $query_cek_this_month = $conn->query("SELECT * FROM transaksi_rawat_jalan a JOIN master_tindakan b on a.tindakanID = b.id WHERE b.typeTindakan='PCR' AND MONTH(tglTindakan) = '$thisMonth' AND YEAR(tglTindakan) = '$thisYear'");
        // printf("Select returned %d rows.\n", $query_cek_this_month->num_rows);
        // exit();

        if ($query_cek_this_month->num_rows >= 1) {
            # code...
            $query = $conn->query("SELECT GREATEST(MAX(transaksi_rawat_jalan.barcodeLab), COALESCE(MAX(transaksi_rawat_jalan.softDeleteBarcode), 0)) noAntrian FROM transaksi_rawat_jalan 
                               JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id 
                               JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
                               WHERE NOT transaksi_rawat_jalan.status = 'Open' AND master_tindakan.typeTindakan='PCR' 
                               AND Month(transaksi_rawat_jalan.tglTindakan) = '$thisMonth' AND Year(transaksi_rawat_jalan.tglTindakan) ='$thisYear'");
            $fetchAntrian = $query->fetch_array();

            $antrian = $fetchAntrian['noAntrian'];

            $antrianInt = (int)substr($antrian, 11) + 1;

            $invID = str_pad($antrianInt, 4, '0', STR_PAD_LEFT);


            $format_barcode = "C943." . $fullYMD . $invID;
        } else {

            $invID = str_pad('1', 4, '0', STR_PAD_LEFT);

            $format_barcode = "C943." . $fullYMD . $invID;
        }

        // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($format_barcode, $generator::TYPE_CODE_128)) . '">
        // <h5>' . $format_barcode . '</h5>';

        $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = '$format_barcode', transaksi_rawat_jalan.status = 'On Process', transaksi_rawat_jalan.barcodeLabTime = NOW() 
        WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' && master_pasien.nik = '$nik_barcode_lab';");

        if ($query) {
            # code...
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = '$isBarcodeDeleted', transaksi_rawat_jalan.status = 'On Process',
        transaksi_rawat_jalan.barcodeLabTime = NOW(), transaksi_rawat_jalan.softDeleteBarcode = null WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' && master_pasien.nik = '$nik_barcode_lab';");

        if ($query) {
            # code...
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
