<?php

$outletID = isset($_GET['outletID']) ? $_GET['outletID'] : "";

session_start();
$_SESSION['outletID'] = $outletID;

header('location: ../pasien/main/index.php?page=type-register');
