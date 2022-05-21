<?php
include('../connection.php');
include('../helper/base_url.php');
include('../phpqrcode/qrlib.php');
require('../vendor/autoload.php');

session_start();

$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
$pasienID = isset($_GET['noPasien']) ? $_GET['noPasien'] : '';
$sess_karyawan  = isset($_SESSION['idKaryawan']) ? $_SESSION['idKaryawan'] : '';


$tempdir = "temp/";
if (!file_exists($tempdir)) {
    mkdir($tempdir);
}

$isi_qrCode = BASE_URL . "lhu/index.php?idTransaction=$idTransaction&noPasien=$pasienID";
$filename   = 'QRCode_'.md5($idTransaction).'pasien_'.$pasienID.'.png';
$qr_doctor  = BASE_URL . "images/new_qr_doctor";

$pngAbsolutePNG = $tempdir . $filename;

if (!file_exists($pngAbsolutePNG)) {
    # code...
    QRcode::png($isi_qrCode, $pngAbsolutePNG);
} 

$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

function country($country)
{
    switch ($country) {
        case null:
            # code...
            return '-';
            break;

        default:
            # code...
            return $country;
            break;
    }
}

function barcodeLAB($barcodeLab)
{
    switch ($barcodeLab) {
        case 'Belum dibarcode':
            # code...
            return '-';
            break;

        default:
            # code...
            return $barcodeLab;
            break;
    }
}

function sampleTime($sampleTime)
{
    switch ($sampleTime) {
        case null:
            # code...
            return '-';
            break;

        default:
            # code...
            return $sampleTime . ' WIB';
            break;
    }
}
function barcodeLabTime($barcodeLabTime)
{
    switch ($barcodeLabTime) {
        case null:
            # code...
            return '-';
            break;

        default:
            # code...
            return $barcodeLabTime;
            break;
    }
}
function resuktTime($resultTime)
{
    switch ($resultTime) {
        case null:
            # code...
            return '-';
            break;

        default:
            # code...
            return $resultTime . ' WIB';
            break;
    }
}

function resultTes($hasil)
{
    switch ($hasil) {
        case 'Positif':
            # code...
            return 'Positif/Positive';
            break;
        case 'Inkonklusif':
            # code...
            return 'Inkonklusif/Inconclusive';
            break;
        default:
            # code...
            return 'Negatif/Negative';
            break;
    }
}

function keterangan($keterangan)
{
    switch ($keterangan) {
        case null || '':
            # code...
            return '-';
            break;

        default:
            # code...
            return $keterangan;
            break;
    }
}

function targetReagen($gen)
{
    switch ($gen) {
        case null || '':
            # code...
            return '';
            break;

        default:
            # code...
            $explode = explode('#', $gen);
            if($explode[0] == null) {
                return $explode[1] . ' : TIDAK TERDETEKSI / NOT DETECTED ';
            } else {
            return $explode[1] . ' : ' . $explode[0];
            }
            break;
    }
}

function textCutOff($typeTindakan) {
    if($typeTindakan == 'PCR') {
        return 'Cutoff CT Value adalah ≥ 43 / Cutoff CT Value is ≥ 43';
    } else {
        return '';
    }
}

function numberID($nik, $passport) {
    // if($nik == '') {
    //     return $passport;
    // } else {
    //     return $nik;
    // }
    
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

function customDate($datetime) {
    
    $strtime = strtotime($datetime);
    $formatdate = date('dm', $strtime);
    
    return $formatdate;
}

$select_data = $conn->query("SELECT master_pasien.name name_pasien, master_pasien.gender, master_pasien.dateOfBirth, master_pasien.nik, master_pasien.passport,
master_pasien.country, master_pasien.address address_pasien, transaksi_rawat_jalan.barcodeLab, master_tindakan.typeTindakan, transaksi_rawat_jalan.sampleTime, 
transaksi_rawat_jalan.barcodeLabTime, transaksi_rawat_jalan.resultTime, master_hasil_tes.pemeriksaan, master_hasil_tes.spesimen, 
master_hasil_tes.hasil, master_hasil_tes.keterangan, master_hasil_tes.nameTargetGen, master_hasil_tes.gen0, master_hasil_tes.gen1, master_hasil_tes.gen2, master_hasil_tes.gen3,
master_hasil_tes.gen4, master_hasil_tes.gen5, master_outlet.name name_outlet FROM transaksi_rawat_jalan 
JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id JOIN master_hasil_tes ON transaksi_rawat_jalan.transaksiID = master_hasil_tes.idTransaction
JOIN master_outlet ON transaksi_rawat_jalan.outletID = master_outlet.id JOIN master_tindakan ON transaksi_rawat_jalan.tindakanID = master_tindakan.id
WHERE transaksi_rawat_jalan.transaksiID = '$idTransaction' AND transaksi_rawat_jalan.pasienID = '$pasienID'");
$fetch          = $select_data->fetch_array();
$name           = $fetch['name_pasien'];
$gender         = $fetch['gender'];
$dob            = $fetch['dateOfBirth'];
$nik            = $fetch['nik'];
$passport       = $fetch['passport'];
$country        = $fetch['country'];
$address        = $fetch['address_pasien'];
$barcodeLab     = $fetch['barcodeLab'];
$typeTindakan   = $fetch['typeTindakan'];
$name_outlet    = $fetch['name_outlet'];
$sampleTime     = $fetch['sampleTime'];
$barcodeLabTime = $fetch['barcodeLabTime'];
$resultTime     = $fetch['resultTime'];
$pemeriksaan    = $fetch['pemeriksaan'];
$spesimen       = $fetch['spesimen'];
$hasil          = $fetch['hasil'];
$keterangan     = $fetch['keterangan'];
$nameTargetGen  = $fetch['nameTargetGen'];
$gen0           = $fetch['gen0'];
$gen1           = $fetch['gen1'];
$gen2           = $fetch['gen2'];
$gen3           = $fetch['gen3'];
$gen4           = $fetch['gen4'];
$gen5           = $fetch['gen5'];

$mpdf->SetTitle('HASIL PEMERIKSAAN LABORATORIUM');

// Define the Header/Footer before writing anything so they appear on the first page
$mpdf->SetHTMLHeader('
<br><br>
<div style="text-align: left; font-weight: bold;">
<table width="100%">
<tr>
    <td width="15%"><img width="10%" src="../images/LogoNorbuMedika.jpg"></img></td>
    <td>
        <h2>NORBU MEDIKA</h2><br>
        <p style="font-size: 18px; letter-spacing: 2px;">LABORATORIUM KHUSUS</p><br>
        <p style="font-size: 14px; letter-spacing: 2px;">Jl. Pluit Permai Raya Mall Pluit Village No 30</p> 
    </td>
</tr>
</table>
<hr>
</div>');

if($typeTindakan == 'PCR') {
    $mpdf->SetHTMLFooter('
<hr>
<table width="100%">
<tr>
    <td></td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">Catatan/<span style="font-style: italic; font-weight: normal">Noted :</span></p>
    </td>
</tr>
<tr>
    <td style="vertical-align:top"; width="3%">
    1.
    </td>
    <td>
    <p style="font-size: 12px; font-weight: bold; text-align: justify;">Hasil pemeriksaan diatas dikerjakan dengan metode Real Time PCR hanya menggambarkan kondisi saat pengambilan spesimen/<span style="font-style: italic; font-weight: normal">The examination result is based on Real Time PCR method and only describe the condition when the specimen was collected</span></p>
    </td>
</tr>
<tr>
    <td style="vertical-align:top"; width="3%">
    2.
    </td>
    <td>
    <p style="font-size: 12px; font-weight: bold; text-align: justify;">Jika hasil PCR positif, silahkan hubungi dokter atau fasilitas kesehatan terdekat/<span style="font-style: italic; font-weight: normal">If the PCR test result is positive, please contact your doctor or nearest health facilities</span></p>
    </td>
</tr>
<tr>
    <td style="vertical-align:top"; width="3%">
    3.
    </td>
    <td>
    <p style="font-size: 12px; font-weight: bold; text-align: justify;">Hasil PCR negatif, bukan berarti pasien tidak terinfeksi. Akan tetapi hanya menunjukkan bahwa material genetik tidak ditemukan pada sampel/<span style="font-style: italic; font-weight: normal">Negative PCR result does not necessary mean that the patient is not infected. Rather it only shows that genetic material is not present in the sample</span></p>
    </td>
</tr>
<tr>
    <td style="vertical-align:top"; width="3%">
    4.
    </td>
    <td>
    <p style="font-size: 12px; font-weight: bold; text-align: justify;">Hasil dari satu laboratorium tidak dapat dibandingkan dengan hasil dari laboratorium lain mengingat adanya kemungkinan perbedaan metode, instrument mesin, dan reagen/<span style="font-style: italic;font-weight: normal">Result from one laboratory cannot be compared with other laboratory due to possibility of different methods, instruments, and reagents</span></p>
    </td>
</tr>
</table>
<br><br>
');
}

$mpdf->WriteFixedPosHTML(
    '<p style="font-size: 14px; margin-top:100px; text-align: center;font-weight: bold;">Hasil Laboratorium/<span style="font-style:italic;">Laboratory Result</span></p><br>',
    50,
    28,
    100,
    10
);

$mpdf->WriteFixedPosHTML('
<table width="100%">
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">Nama Pasien</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Patient Name</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $name . '</p>
    </td>
</tr>
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">Jenis Kelamin</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Gender/Sex</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $gender . '</p>
    </td>
</tr>
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">Tanggal Lahir</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Date of Birth</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $dob . '</p>
    </td>
</tr>
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">No KTP/Passport</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">ID/Passport Number</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . numberID($nik, $passport) . '</p>
    </td>
</tr>
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">Warga Negara</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Nationality</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . country($country) . '</p>
    </td>
</tr>
<tr>
    <td width="30%">
        <p style="font-size: 12px; font-weight: bold;">Alamat</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Address</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $address . '</p>
    </td>
</tr>
</table>
', 15, 63, 100, 100);

$mpdf->WriteFixedPosHTML('
<table width="100%">
<tr>
    <td width="35%">
        <p style="font-size: 12px; font-weight: bold;">No Registrasi</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Reg Number</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $idTransaction . '</p>
    </td>
</tr>
<tr>
    <td width="35%">
        <p style="font-size: 12px; font-weight: bold;">Kode Sample</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Sample code</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . barcodeLAB($barcodeLab) . '</p>
    </td>
</tr>
<tr>
    <td width="35%">
        <p style="font-size: 12px; font-weight: bold;">Asal Sample</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Sample Received From</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . $name_outlet . '</p>
    </td>
</tr>
<tr>
    <td width="35%">
        <p style="font-size: 12px; font-weight: bold;">Pengambilan Spesimen</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Speciment Collection</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . sampleTime($sampleTime) . '</p>
    </td>
</tr>
<tr>
    <td width="35%">
        <p style="font-size: 12px; font-weight: bold;">Tgl. Hasil</p>
        <p style="font-size: 10px; font-weight: bold; font-style:italic;">Result Date</p>
    </td>
    <td width="5%">
        :
    </td>
    <td>
        <p style="font-size: 12px; font-weight: bold;">' . resuktTime($resultTime) . '</p>
    </td>
</tr>
</table>
', 110, 63, 100, 100);

$mpdf->WriteFixedPosHTML('<table style="border: 1px solid black; border-collapse: collapse; width:100%;">
<tr>
    <th style="border: 1px solid black; text-align:center; background-color:#B6C134; width: 30% ">
    <p style="font-size: 12px; font-weight: bold;">Pemeriksaan</p>
    <p style="font-size: 10px; font-weight: bold; font-style:italic;">Type of Examination</p>
    </th>
    <th style="border: 1px solid black;text-align:center; background-color:#B6C134; width: 30%">
    <p style="font-size: 12px; font-weight: bold;">Hasil</p>
    <p style="font-size: 10px; font-weight: bold; font-style:italic;">Result</p>
    </th>
    <th  style="border: 1px solid black;text-align:center; background-color:#B6C134; width: 40%">
    <p style="font-size: 12px; font-weight: bold;">Keterangan</p>
    <p style="font-size: 10px; font-weight: bold; font-style:italic;">Other Information</p>
    </th>
</tr>
<tr>
    <td style="border: 1px solid black;text-align:center; padding:10px;">
        <p style="font-size: 12px; font-weight: bold; ">' . $pemeriksaan . '</p>
    </td>
    <td style="border: 1px solid black;text-align:center; padding:10px;">
        <p style="font-size: 12px; font-weight: bold;">' . resultTes($hasil) . '</p>
    </td>
    <td style="text-align:justify; padding:10px;">
        <p style="font-size: 10px; font-weight: bold;">' . keterangan($keterangan) . '</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen0) .'</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen1) .'</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen2) .'</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen3) .'</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen4) .'</p>
        <p style="font-size: 10px; font-weight: bold;">' . targetReagen($gen5) .'</p>
        <p style="font-size: 10px; font-weight: normal;">'.textCutOff($typeTindakan).'</p>
    </td>
</tr>
<tr>
    <td style="text-align:left; padding-left:20px;">
    <p style="font-size: 12px; font-weight: bold;">Jenis Spesimen</p>
    <p style="font-size: 10px; font-weight: bold; font-style:italic;">Specimen Type</p>
    </td>
    <td style="border-right: 1px solid black;text-align:left; ">
    <p style="font-size: 10px; font-weight: bold; font-style:italic;">: ' . $spesimen . '</p>
    </td>
</tr>
</table>', 15, 123, 180, 100);


if($typeTindakan == 'PCR') {
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">SARAN/<span style="font-style: italic;">RECOMMENDATION :</span></p>', 15, 155, 100, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">1. Patuhi protokol kesehatan yang berlaku /<span style="font-style: italic; font-weight: normal;"> Always follow the health protocol.</span></p>', 20, 163, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">2. Tetap berperilaku bersih dan sehat /<span style="font-style: italic; font-weight: normal;"> Keep a clean and healthy attitude.</span></p>', 20, 167, 110, 100);

    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">Dokter Penanggung Jawab,</p>', 150, 175, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold; font-style: italic;">Dokter in Charge,</p>', 155, 178, 110, 100);
    $mpdf->WriteFixedPosHTML('<img width="25%" src="'. $pngAbsolutePNG . '"></img>', 20, 180, 110, 100);
    $mpdf->WriteFixedPosHTML('<img width="23%" src="'.$qr_doctor.'"></img>', 154, 183, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;"> dr. Herna, SpMK</p>', 155, 210, 110, 100);
} else {
    
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">SARAN/<span style="font-style: italic;">RECOMMENDATION :</span></p>', 15, 155, 100, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">1. Konfirmasi dengan metode RT-PCR /<span style="font-style: italic; font-weight: normal;"> Confirm the result with RT-PCR.</span></p>', 20, 163, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">2. Menerapkan protokol 5M (memakai masker, mencuci tangan, menjaga jarak, menjauhi kerumunan, membatasi mobilitas) /<span style="font-style: italic; font-weight: normal;"> Maintain 5M protocol (wear mask, wash hand, maintain distance, avoid crowd, restrict mobility).</span></p>', 20, 167, 180, 100);
    
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;">Dokter Penanggung Jawab,</p>', 150, 195, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold; font-style: italic;">Dokter in Charge,</p>', 155, 198, 110, 100);
    $mpdf->WriteFixedPosHTML('<img width="28%" src="'. $pngAbsolutePNG . '"></img>', 20, 203, 110, 100);
    $mpdf->WriteFixedPosHTML('<img width="25%" src="'.$qr_doctor.'"></img>', 154, 205, 110, 100);
    $mpdf->WriteFixedPosHTML('<p style="font-size: 10px; font-weight: bold;"> dr. Herna, SpMK</p>', 155, 235, 110, 100);
}

$auth   = customDate($dob);

if($sess_karyawan == '') {
    $mpdf->SetProtection(array('print'), $auth);
} 

$mpdf->Output($name.'.pdf', 'I');

