<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['sebespriv'] == 1)) {

//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['id_seb'])) {$id_seb = $_POST['id_seb']; if ($id_seb == '') {unset ($id_seb);}}
if (isset($_POST['sebes'])) {$sebes = $_POST['sebes']; if ($sebes == '') {unset ($sebes);}}
if (isset($_POST['kol_sebes'])) {$kol_sebes = $_POST['kol_sebes']; if ($kol_sebes == '') {unset ($kol_sebes);}}

if (isset($_POST['id_to_back_sebes'])) {$id_to_back_sebes = $_POST['id_to_back_sebes']; if ($id_to_back_sebes == '') {unset ($id_to_back_sebes);}}

if (!is_numeric($kol_sebes)) {$kol_sebes = 0;}
if (!is_numeric($sebes)) {$sebes = 0;}

$res=mysql_query("UPDATE sebestoim SET kolichestvo = '$kol_sebes', sebestoimost = '$sebes' WHERE ID = '$id_seb'",$db); 

header("Location: ../sebestoim.php?id=".$id_to_back_sebes);	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>