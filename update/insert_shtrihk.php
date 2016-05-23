<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {
	
if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['kategory'])) {$kategory = $_POST['kategory']; if ($kategory == '') {unset ($kategory);}}
if (isset($_POST['tovar'])) {$tovar = $_POST['tovar']; if ($tovar == '') {unset ($tovar);}}
if (isset($_POST['shtrihkod'])) {$shtrihkod = $_POST['shtrihkod']; if ($shtrihkod == '') {unset ($shtrihkod);}}

$serial_flag = false;
if (isset($id)) {
	$res_serial = mysql_query("SELECT serial_number FROM serialnum WHERE ID_shtrihkoda = '$id'",$db);
	$myr_serial = mysql_fetch_array($res_serial);
	if (isset($myr_serial['serial_number']) && ($myr_serial['serial_number'] <> '')) {$serial_flag = true; $alert = $myr_serial['serial_number'];}
	else {$res = mysql_query("DELETE FROM shtrihkod WHERE ID='$id'",$db);}	
	}			
else {

$_SESSION['selected_kat_shtrih'] = $kategory;
$_SESSION['selected_tov_shtrih'] = $tovar;

if (isset($kategory) && (isset($tovar)) && (isset($shtrihkod)) && ($kategory <> 'all')) {	
      $res=mysql_query("INSERT INTO shtrihkod SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', shtrih = '$shtrihkod'",$db);
   }	   
}
if ($serial_flag == false) {header("Location: ../shtrihkod.php");}
else {header("Location: ../shtrihkod.php?al=$alert");}

}
else {

header("Location: ../index.php");
die();
}
 ?>