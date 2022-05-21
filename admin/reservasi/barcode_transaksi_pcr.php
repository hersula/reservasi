<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode Transaksi</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <style>
        @media print 
        {
           @page
           {
            size: 50mm 20mm;
            margin: 0mm;
          }
        }
    </style>
</head>

<?php

require('../../vendor/autoload.php');

$idTransaction  = isset($_GET['idTransaction']) ? (string)$_GET['idTransaction'] : '';
$dateOfBirth  = isset($_GET['dateOfBirth']) ? $_GET['dateOfBirth'] : '';
$namePasien     = isset($_GET['name_pasien']) ? $_GET['name_pasien'] : '';
$name_tindakan     = isset($_GET['name_tindakan']) ? $_GET['name_tindakan'] : '';
$name_outlet     = isset($_GET['name_outlet']) ? $_GET['name_outlet'] : '';
$tglTindakan     = isset($_GET['tglTindakan']) ? $_GET['tglTindakan'] : '';
$sampleTime     = isset($_GET['sampleTime']) ? $_GET['sampleTime'] : '';
$timeSample     = strtotime($sampleTime);
$formatTimeSample = date('H:i:s', $timeSample);
$name_pasien_substr = substr($namePasien, 0, 20);

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo '
<div style="text-align:center">
<p style="font-size:8px; margin-bottom:0px">'.$tglTindakan.'<span style=" margin-left: 15mm;">'.$formatTimeSample.'</span></p><img style="padding-bottom:0px; margin-top:0px;" width="170" height="20" src="data:image/png;base64,' . base64_encode($generator->getBarcode($idTransaction, $generator::TYPE_CODE_128)) . '">
<p style="margin-top:0px; margin-bottom:0px;font-size:8px;">'.$name_pasien_substr.' / '.$dateOfBirth.'<br>'.$name_tindakan.'<br>'.$name_outlet.'</p></div>
';

?>

<script>window.print()</script>