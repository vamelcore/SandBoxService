<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {
	
if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['selected_op'])) {$selected_op = $_POST['selected_op']; $_SESSION['selected_op'] = $_POST['selected_op']; if ($selected_op == '') {unset ($selected_op);}}
if (isset($_POST['tarifplan'])) {$tarifplan = $_POST['tarifplan']; if ($tarifplan == '') {unset ($tarifplan);}}
if (isset($_POST['stoimpodkl'])) {$stoimpodkl = $_POST['stoimpodkl']; if ($stoimpodkl == '') {unset ($stoimpodkl);}}
if (isset($_POST['voznagtp'])) {$voznagtp = $_POST['voznagtp']; if ($voznagtp == '') {$voznagtp='----';}}


if (isset($id)) {$res = mysql_query("DELETE FROM tarifplan WHERE ID='$id'",$db);}	
		
else {

if (isset($_SESSION['id_tarpl'])) {
$res=mysql_query("UPDATE tarifplan SET ID_oper = '$selected_op', tarifplan = '$tarifplan', stoim_podkl = '$stoimpodkl', voznagtp = '$voznagtp' WHERE ID = '{$_SESSION['id_tarpl']}'",$db);	unset($_SESSION['id_tarpl']);
} else {
 if (isset($tarifplan) && (isset($stoimpodkl))) {  
$res=mysql_query("INSERT INTO tarifplan SET ID_oper = '$selected_op', tarifplan = '$tarifplan', stoim_podkl = '$stoimpodkl', voznagtp = '$voznagtp'",$db);} 
}}



header("Location: ../tarifplan.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>