<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['id'])) { $id = $_POST['id']; if ($id == '') {unset ($id);}}
if (isset($_POST['procent'])) { $procent = $_POST['procent']; if ($procent == '') {unset ($procent);}}
if (isset($_POST['edit'])) {$edit = true;} else {$edit = false;}

if ((isset($id)) && ($id <> '') && ($edit == true) && (isset($procent))) {$result = mysql_query("UPDATE payment_dilers SET procent = '$procent' WHERE ID = '$id'",$db);} 
elseif ((isset($id)) && ($id <> '') && ($edit == false)) {$result = mysql_query("DELETE FROM payment_dilers WHERE ID = '$id'",$db);} 


header("Location: ../dileru.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>