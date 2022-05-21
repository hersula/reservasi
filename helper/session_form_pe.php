<?php  

$gejala = isset($_POST['gejala']) ? $_POST['gejala'] : null;
$deskripsiGejala = empty($_POST['deskripsiGejala']) ? "Tidak ada gejala" : $_POST['deskripsiGejala'];

session_start();
$_SESSION['gejala'] = $gejala;
$_SESSION['deskripsiGejala'] = $deskripsiGejala;

header("location: ../pasien/main/index.php?page=package");


?>