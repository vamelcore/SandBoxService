<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
 

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);		
		
      if (isset($_POST['data'])) {$data = $_POST['data'];if ($data == '') {unset ($data);}}
       if (isset($_POST['magazin'])) {
      		
      	$magazin = $_POST['magazin'];
      	if ($magazin == '') {unset ($magazin);}
	    $res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazin'",$db);
		$myr_mag=mysql_fetch_array($res_mag);
	  }
      if (isset($_POST['operator'])) {$operator = $_POST['operator'];if ($operator == '') {unset($operator);}}
      if (isset($_POST['fio'])) {$fio = $_POST['fio'];if ($fio == '') {unset($fio);}}
      if (isset($_POST['nomer_ab'])) {$nomer_ab = $_POST['nomer_ab'];if ($nomer_ab == '') {unset($nomer_ab);}}
	  if (isset($_POST['kontact_nomer'])) {$kontact_nomer = $_POST['kontact_nomer'];if ($kontact_nomer == '') {unset($kontact_nomer);}}
	  if (isset($_POST['paket'])) {$paket = $_POST['paket'];if ($paket == '') {unset($paket);}}
	  if (isset($_POST['kluch_evdo'])) {$kluch_evdo = $_POST['kluch_evdo'];if ($kluch_evdo == '') {unset ($kluch_evdo);}}
      if (isset($_POST['avans'])) {$avans = $_POST['avans'];if ($avans == '') {unset($avans);}}
      if (isset($_POST['oplata'])) {$oplata = $_POST['oplata'];if ($oplata == '') {unset($oplata);}}
	  if (isset($_POST['ostatok'])) {$ostatok = $_POST['ostatok'];if ($ostatok == '') {unset($ostatok);}}
      if (isset($_POST['oborudovanie'])) {$oborudovanie = $_POST['oborudovanie'];if ($oborudovanie == '') {unset($oborudovanie);}}
		
if ((isset($_SESSION['id_otchet'])) && ($_SESSION['ed_priv_otch'] == 1)) {
		
	$id = $_SESSION['id_otchet'];
	unset ($_SESSION['id_otchet']);
    if ($id == '') {unset ($id);}
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM otchet WHERE ID='$id'",$db); unset ($_POST['delete']);}

     else {

      $res=mysql_query("UPDATE otchet SET magazin = '{$myr_mag['name']}', data = '$data', ID_operatora = '$operator', fio = '$fio', nomer_abon = '$nomer_ab', kontakt_nomer = '$kontact_nomer', paket = '$paket', kluch_evdo = '$kluch_evdo', avans = '$avans', oplata = '$oplata', ostatok = '$ostatok', oborudov = '$oborudovanie' WHERE ID='$id'",$db);
	

}
}

header("Location: ../otchet.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>