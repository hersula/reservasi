<?php

include '../../connection.php';
include '../../helper/base_url.php';
require '../../vendor/autoload.php';

$idGenerate = isset($_POST['generate']) ? $_POST['generate'] : '';
$batchnumber = isset($_POST['batchnumber']) ? $_POST['batchnumber'] : '';

if ($idGenerate != '') {
    # code...

    $fullYMD         = date('ymd');
    $thisDay         = date('d');
    $thisMonth       = date('m');
    $thisYear        = date('Y');

    for ($i = 0; $i <= count($idGenerate) - 1; $i++) {
        # code...
        $query_cek_this_month = $conn->query("SELECT barcodeLab FROM transaksi_rawat_jalan a JOIN master_tindakan b on a.tindakanID = b.id WHERE b.typeTindakan='PCR' AND MONTH(barcodeLabTime) = '$thisMonth' AND YEAR(barcodeLabTime) = '$thisYear' AND NOT barcodeLab='Belum dibarcode'");
        
        if ($query_cek_this_month->num_rows >= 1) {
            # code...
            // query generate barcode sebelumnya
            // $query = $conn->query("SELECT GREATEST(MAX(transaksi_rawat_jalan.barcodeLab), COALESCE(MAX(transaksi_rawat_jalan.softDeleteBarcode), 0)) noAntrian FROM transaksi_rawat_jalan 
            //                   JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id 
            //                   JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
            //                   WHERE NOT transaksi_rawat_jalan.status = 'Open' AND master_tindakan.typeTindakan='PCR'
            //                   AND Month(transaksi_rawat_jalan.barcodeLabTime) = '$thisMonth' AND Year(transaksi_rawat_jalan.barcodeLabTime) ='$thisYear'");
            
            $query = $conn->query("SELECT GREATEST(COALESCE(transaksi_rawat_jalan.barcodeLab, 0), COALESCE(transaksi_rawat_jalan.softDeleteBarcode, 0)) noAntrian FROM transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id 
            WHERE NOT transaksi_rawat_jalan.status = 'Open' AND master_tindakan.typeTindakan='PCR' 
            AND Month(transaksi_rawat_jalan.barcodeLabTime) = '$thisMonth' AND Year(transaksi_rawat_jalan.barcodeLabTime) ='$thisYear' ORDER BY transaksi_rawat_jalan.barcodeLab DESC");
            
            $fetchAntrian = $query->fetch_array();

            $antrian = $fetchAntrian['noAntrian'];

            $antrianInt = (int)substr($antrian, 11) + 1;
            
            if ($antrianInt > 9999) {
                $invID = str_pad(1, 4, '0', STR_PAD_LEFT);
            } else {
                 $invID = str_pad($antrianInt, 4, '0', STR_PAD_LEFT);
            }
            
            $format_barcode = "C943." . $fullYMD . $invID;
        } else {

            $invID = str_pad('1', 4, '0', STR_PAD_LEFT);

            $format_barcode = "C943." . $fullYMD . $invID;
        }

        // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($format_barcode, $generator::TYPE_CODE_128)) . '">
        // <h5>' . $format_barcode . '</h5>';

        // $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = '$format_barcode', transaksi_rawat_jalan.status = 'On Process', transaksi_rawat_jalan.batchNumber = '$batchnumber', transaksi_rawat_jalan.barcodeLabTime = NOW() 
        // WHERE transaksi_rawat_jalan.id = '$idGenerate[$i]'");
        
        $select = $conn->query("SELECT barcodeLab FROM transaksi_rawat_jalan WHERE barcodeLab = '$format_barcode'");

        $listRow =  $select->num_rows;

        if ($listRow <= 0) {
            # code...
            $query_isFaskes = $conn->query("SELECT isFaskes FROM master_outlet JOIN transaksi_rawat_jalan ON transaksi_rawat_jalan.outletID = master_outlet.id WHERE transaksi_rawat_jalan.id = '$idGenerate[$i]'");

            $fetch_isFaskes = $query_isFaskes->fetch_array();
            $isFaskes       = $fetch_isFaskes['isFaskes'];


            if ($isFaskes == '1') {
                # code...
                $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = '$format_barcode', transaksi_rawat_jalan.status = 'On Process', transaksi_rawat_jalan.batchNumber = '$batchnumber', transaksi_rawat_jalan.barcodeLabTime = NOW(), transaksi_rawat_jalan.sampleTime = NOW()
            WHERE transaksi_rawat_jalan.id = '$idGenerate[$i]'");
            } else {
                $query = $conn->query("UPDATE transaksi_rawat_jalan JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id SET transaksi_rawat_jalan.barcodeLab = '$format_barcode', transaksi_rawat_jalan.status = 'On Process', transaksi_rawat_jalan.batchNumber = '$batchnumber', transaksi_rawat_jalan.barcodeLabTime = NOW() 
            WHERE transaksi_rawat_jalan.id = '$idGenerate[$i]'");
            }
        } else {
            $query = false;
        }
    }

    if ($query) {
        # code...
        header('location: ' . BASE_URL . 'admin/laboratorium/print_barcode_lab.php?batchnumber='.$batchnumber.'');
    } else {
        echo '<script>alert("Maaf terjadi kesalahan, mohon coba lagi !");window.location.href="https://reservasi.norbumedika.id/admin/admin.php?page=sample-lab";</script>';
    }
}