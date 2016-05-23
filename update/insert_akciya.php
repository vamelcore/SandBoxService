<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {
	
if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['kategory'])) {$kategory = $_POST['kategory']; if ($kategory == '') {unset ($kategory);}}
if (isset($_POST['operator'])) {$operator = $_POST['operator']; if ($operator == '') {unset ($operator);}}
if (isset($_POST['cena'])) {$cena = $_POST['cena']; if ($cena == '') {unset ($cena);}}
if (isset($_POST['tovar'])) {$tovar = $_POST['tovar']; if ($tovar == '') {unset ($tovar);}}
if (isset($_POST['tarifplan'])) {$tarifplan = $_POST['tarifplan']; if ($tarifplan == '') {unset ($tarifplan);}}
if (isset($_POST['voznag'])) {$voznag = $_POST['voznag']; if ($voznag == '') {unset ($voznag);}}

if (isset($id)) {$res = mysql_query("DELETE FROM akciya WHERE ID='$id'",$db);}	
		
else {

if (isset($_SESSION['id_akc'])) {
$res=mysql_query("UPDATE akciya SET ID_kateg = '$kategory', ID_tov = '$tovar', ID_oper = '$operator', ID_tp = '$tarifplan', cena = '$cena', voznag = '$voznag' WHERE ID = '{$_SESSION['id_akc']}'",$db);	
unset($_SESSION['id_akc']);
} else {
	$_SESSION['selected_kat_akc'] = $kategory;
	$_SESSION['selected_op_akc'] = $operator;
	$_SESSION['selected_tov_akc'] = $tovar;
	$_SESSION['selected_tp_akc'] = $tarifplan; 
$res=mysql_query("INSERT INTO akciya SET ID_kateg = '$kategory', ID_tov = '$tovar', ID_oper = '$operator', ID_tp = '$tarifplan', cena = '$cena', voznag = '$voznag'",$db);
}}



header("Location: ../akciya.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>