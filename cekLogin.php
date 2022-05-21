<?php

/*
if(isset($_SESSION["lastclick"])){
	$lastclick = $_SESSION["lastclick"];
	if(time() - $lastclick > 3*60*60){
 		session_destroy();
	}
}
else{
	$_SESSION["lastclick"] = 0;
}
*/

	$timeout = 1; // setting timeout dalam menit
	$logout = "index.php"; // redirect halaman logout

	$timeout = $timeout *60*60; // menit ke detik
	if(isset($_SESSION['start_session'])){
		$elapsed_time = time()-$_SESSION['start_session'];
		if($elapsed_time >= $timeout){
			session_destroy();
		}
	}

	$_SESSION['start_session']=time();

if(!isset($_SESSION["email"])) {
  header("location: index.php");
  //die(0);
}

?>