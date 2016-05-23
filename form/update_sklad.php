<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1)) { 

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['skl_id'])) {$id = $_POST['skl_id']; if ($id == '') {unset($id);} }
if (isset($_POST['kolich'])) {$kolich = $_POST['kolich']; if (!is_numeric($kolich)) {$kolich = 0;}}
if (isset($_POST['add_kolich'])) {$add_kolich = $_POST['add_kolich']; if (!is_numeric($add_kolich)) {$add_kolich = 0;}}
if (isset($_POST['id_kat'])) {$id_kat = $_POST['id_kat']; if ($id_kat == '') {unset($id_kat);}}
if (isset($_POST['id_tov'])) {$id_tov = $_POST['id_tov']; if ($id_tov == '') {unset($id_tov);}}

if (isset($_POST['sebestoemost'])) {$sebestoemost = $_POST['sebestoemost']; if ($sebestoemost == '') {$sebestoemost = 0;}}

if (isset($_POST['shtrihkod'])) {$shtrihkod = $_POST['shtrihkod']; if ($shtrihkod == '') {$shtrihkod = 'no';}}

$summa = $kolich + $add_kolich;

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));
$sys_data = strtotime($dat);

$result = mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '+$add_kolich', data_posl_prihoda = '$dat', kolichestvo = '$summa' WHERE ID = '$id'",$db);

$kolich = '+'.$add_kolich.' ('.$summa.')';

$res_arch=mysql_query("INSERT INTO prihodu SET data = '$dat', ID_magazina = '{$_SESSION['id_mag_selected']}', ID_kategorii = '$id_kat', ID_tovara = '$id_tov', kol_prihoda = '$kolich', primech = 'Добавление на склад', user = '{$_SESSION['login']}', sec_data = '$sec_dat'",$db);

$res_info_sebes = mysql_query("SELECT `sebespriv` FROM `users`",$db);
$using_sebes = false;
while ($myr_info_sebes = mysql_fetch_array($res_info_sebes)) {
if ($myr_info_sebes['sebespriv'] == '1') {$using_sebes = true;}
}
if ($using_sebes == true) {
$res_sebes = mysql_query("INSERT INTO sebestoim SET ID_magazina = '{$_SESSION['id_mag_selected']}', ID_tovara = '$id_tov', kolichestvo = '$add_kolich', sebestoimost = '$sebestoemost', data = '$dat', sys_data = '$sys_data'");
}

if (($shtrihkod == 'yes') && ($_SESSION['add_priv_ost'] == 1)) {
	$shtrihkod_array = array('k' => $id_kat, 't' => $id_tov, 'kc' => $add_kolich);
	if (isset($_SESSION['shtrihkod_array'])) {unset($_SESSION['shtrihkod_array']);}
	$_SESSION['shtrihkod_array'] = $shtrihkod_array;
header("Location: ../update/add_shtrihkod.php");}
else {
header("Location: ../sklad.php");
}
} else {header("Location: ../sklad.php");} 
?>