<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['sebespriv'] == 1)) {
	
if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['p_m'])) {$p_m = $_POST['p_m']; $_SESSION['plus_minus'] = $_POST['p_m']; if ($p_m == '') {unset ($p_m);}}
if (isset($_POST['magaz'])) {$magaz = $_POST['magaz']; $_SESSION['id_mag_selected'] = $_POST['magaz']; if ($magaz == '') {unset ($magaz);}}
if (isset($_POST['primech'])) {$primech = $_POST['primech']; if ($primech == '') {unset($primech);}}
if (isset($_POST['summ'])) {$summ = $_POST['summ']; if ($summ == '') {unset($summ);}}


if (isset($id)) {$res = mysql_query("DELETE FROM rashodu WHERE ID='$id'",$db);}	
		
else {

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));
$data = $dat.' '.$vremya;

if (isset($_SESSION['id_rashodu'])) {
if (isset($primech) && (isset($summ)) && (is_numeric($summ))) {
$res=mysql_query("UPDATE rashodu SET primech = '$primech', summ = '$summ', sec_data = '$sec_dat', data = '$data' WHERE ID = '{$_SESSION['id_rashodu']}'",$db); unset($_SESSION['id_rashodu']);}
} else {
if (isset($primech) && (isset($summ)) && (is_numeric($summ))) {
if ($magaz == 'all') {$magaz = '0';}
$res=mysql_query("INSERT INTO rashodu SET p_m = '$p_m', ID_magazina = '$magaz', primech = '$primech', summ = '$summ', sec_data = '$sec_dat', data = '$data'",$db);} 
}}

header("Location: ../rashodu.php");	
}
else {

header("Location: ../index.php");
die();
}
 ?>