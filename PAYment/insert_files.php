<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['diler'])) { $_GET=defender_sql($_GET); $diler = $_GET['diler']; if ($diler == '') {unset ($diler);}}

if ((isset($diler)) && ($diler <> '')) {
	
$tables = array('payment_2chast','payment_neokup','payment_ottok','payment_podkl','payment_router','payment_trafik','payment_vosstanov');
$ind = 0;

while (isset($tables[$ind])) {

$query = "DELETE FROM ".$tables[$ind]." WHERE filename = '".$diler."'";
$result = mysql_query($query,$db);

		
$ind++;
}
	
} 


header("Location: ../archive_files.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>