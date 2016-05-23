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
if (isset($_POST['serialnum'])) {$serialnum = $_POST['serialnum']; if ($serialnum == '') {unset ($serialnum);}}
if (isset($_POST['shtrih'])) {$shtrih = $_POST['shtrih']; if ($shtrih == '') {unset ($shtrih);}}
if (isset($_POST['rangrand'])) {$rangrand = $_POST['rangrand']; if ($rangrand == '') {$rangrand = 8;}}

if (isset($id)) {$res = mysql_query("DELETE FROM serialnum WHERE ID='$id'",$db);}	
		
else {

$_SESSION['selected_kat_sern'] = $kategory;
$_SESSION['selected_tov_sern'] = $tovar;
$_SESSION['selected_shtr_sern'] = $shtrih;
$_SESSION['selected_rangr_sern'] = $rangrand;
$sernum_flag = false;
if (isset($kategory) && (isset($tovar)) && (isset($serialnum)) && ($kategory <> 'all')) {
	$res_sernum_check = mysql_query("SELECT ID FROM serialnum WHERE serial_number = '$serialnum'",$db);
	if (mysql_num_rows($res_sernum_check) > 0) {$sernum_flag = true;}
	else {$res=mysql_query("INSERT INTO serialnum SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', ID_shtrihkoda = '$shtrih', serial_number = '$serialnum'",$db);}
} 
}
if ($sernum_flag == false) {
header("Location: ../serialnum.php");}
else {header("Location: ../serialnum.php?al=$serialnum");}	
}
else {

header("Location: ../index.php");
die();
}
 ?>