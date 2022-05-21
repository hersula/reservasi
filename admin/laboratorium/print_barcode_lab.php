<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode Lab</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <style>
        /*@media print*/
        /*{*/
        /*    .page-break { display: block; page-break-before: always; }*/
            
        /*    div{*/
        /*        text-align:center;*/
        /*    }*/
            
        /*    p {*/
        /*        font-size: 2.5mm;*/
        /*    }*/
            
        /*    img {*/
        /*        height: 4mm;*/
        /*        width: 20mm;*/
        /*    }*/

        /*   @page*/
        /*   {*/
        /*    size: 100mm 15mm;*/
        /*    margin:0mm;*/
        /*    size:landscape;*/
        /*    margin-top: 1.5mm;*/
        /*    margin-right: 2mm;*/
        /*    margin-left: 2mm;*/
        /*    margin-bottom: 1.5mm;*/
            /*page-orientation: rotate-right;*/
        /*  }*/
        /*}*/
        
        .bg-label {
            width: 74mm;
            height: auto;
            margin: auto;
            display: grid;
            grid-template-columns: auto auto;
        }

        .element-label {
            /*border: 1px solid black;*/
            padding: 1mm;
            text-align: center;
            margin-left: 2mm;
            height: 15mm;
            width: 33mm;
            margin-right: 2mm;
            /*margin-top: 1.5mm;*/
            /*margin-bottom: 1.5mm;*/
        }
        
        .img-barcode {
            vertical-align: middle;
            width: 25mm;
            height: 5mm;
            margin-top: 1mm;
        }
        
        .size-text {
            font-size: 2mm;
        }
        
        /*.element-label1 {*/
            /*border: 1px solid black;*/
        /*    padding: 1mm;*/
        /*    text-align: center;*/
        /*    margin-left: 2mm;*/
        /*    height: 15mm;*/
        /*    width: 33mm;*/
        /*    margin-right: 2mm;*/
            /*margin-top: 1.5mm;*/
            /*margin-bottom: 1.5mm;*/
        /*}*/

        /*.img-barcode1 {*/
        /*    vertical-align: middle;*/
        /*    width: 28mm;*/
        /*    height: 8mm;*/
        /*}*/
        
        
        /*dibawah ini adalah barcode QR*/
        .element-label1 {
            display: flex;
            padding: 0.5mm;
            text-align: center;
            margin-left: 2mm;
            height: 15mm;
            width: 33mm;
            margin-right: 2mm;
        }

        .img-barcode1 {
            //width: 12mm;
            //height: 12mm;
            width: 13mm;
            height: 13mm;
        }
        
        .size-text1 {
            margin-top: 1mm;
            font-size: 2mm;
            text-align: start;
        }

        
        @page {
          size: 74mm 15mm;
          size: landscape;
          margin: 0mm;
        }
        
    </style>
</head>
<body>

                    <?php

                    include '../../connection.php';
                    require '../../vendor/autoload.php';
                    include '../../phpqrcode/qrlib.php';

                    $batchNumber = isset($_GET['batchnumber']) ? $_GET['batchnumber'] : '';

                        if ($batchNumber != '') {
                            # code...
                            $query = $conn->query("SELECT barcodeLab, master_pasien.name, master_pasien.dateOfBirth FROM transaksi_rawat_jalan 
                            JOIN master_pasien ON transaksi_rawat_jalan.pasienID = master_pasien.id WHERE batchNumber ='$batchNumber'");
                            $num_rows = $query->num_rows;
                            //echo $num_rows;
                            
                            for ($i = 0; $i < $num_rows; $i++) { 
                                # code...
                                $row = $query->fetch_array();
                                $format_barcode = $row['barcodeLab'];
                                $name           = $row['name'];
                                $dob            = $row['dateOfBirth'];
                                $namesubs       = substr($name, 0, 15);
                                
                                $format_barcode_new = $format_barcode . '/' . $namesubs;
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                
                                $tempdir = "temp/";
                                if (!file_exists($tempdir)) {
                                    mkdir($tempdir);
                                }
                    
                                $pngAbsolutePNG = $tempdir . $format_barcode . '.png';
                    
                                if (!file_exists($pngAbsolutePNG)) {
                                    # code...
                                    QRcode::png($format_barcode_new, $pngAbsolutePNG);
                                }
                                
                               echo '<div class="bg-label">';
                               echo '   <div class="element-label1">';
                               echo '<img class="img-barcode1" src="'.$pngAbsolutePNG.'"/><p class="size-text1">'.$namesubs.' </br> '.$dob.' </br> '.$format_barcode.'</p>';
                               echo '    </div>';
                               echo '   <div class="element-label">';
                               echo '<img class="img-barcode" src="data:image/png;base64,' . base64_encode($generator->getBarcode($format_barcode_new, $generator::TYPE_CODE_128)) . '"/><p class="size-text"> '. $namesubs . ' / ' . $dob .'</br>' . $format_barcode . '</p>';
                               echo '    </div>';
                               echo '</div>';
                            }
                        }
                    ?>

    
    

</body>

</html>

<script>
    window.print();
</script>