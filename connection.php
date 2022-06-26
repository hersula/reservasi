<?php 

    // $host = 'localhost';
    // $user = 'norbumed_operational';
    // $pass = 'yn8bOL[6MlPZ';
    // $user = 'root';
    // $pass = '';
    $host = '51.79.150.45';
    $user = 'hersul';
    $pass = 'Qaz123wsxa@gtXvsradeon=slivscrossfireX';
    $db_name = 'norbumed_operational_db';

    $conn = mysqli_connect($host, $user, $pass, $db_name);

    if (!$conn) {
        # code...
        echo "Connection Failed !";
    }

?>