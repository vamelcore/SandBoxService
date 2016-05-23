<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) { 

$_POST=defender_xss_min($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['id_op'])) {$id = $_POST['id_op']; if ($id == '') {unset($id);} }
if (isset($_POST['schet'])) {$schet = $_POST['schet'];}
if (isset($_POST['popolnenie'])) {$popolnenie = $_POST['popolnenie'];}
if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset($magazine);}}
if (isset($_POST['vkasse_mag'])) {$vkasse_mag = $_POST['vkasse_mag'];}

$summa = $schet + $popolnenie;

$result = mysql_query("UPDATE operatoru SET schet = '$summa' WHERE ID = '$id'",$db);

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));

$res_max_id_ot = mysql_query("SELECT MAX(ID) AS `ID` FROM otchet",$db);
$myr_max_id_ot = mysql_fetch_array($res_max_id_ot);

$res_max_id_rh = mysql_query("SELECT MAX(ID) AS `ID` FROM rahunok",$db);
$myr_max_id_rh = mysql_fetch_array($res_max_id_rh);

$rahunok = $summa.' (+'.$popolnenie.')';

if ($myr_max_id_ot['ID'] <= $myr_max_id_rh['ID']) {
$res_rah = mysql_query("INSERT INTO rahunok SET ID = '{$myr_max_id_rh['ID']}'+1, date = '$dat', ID_operatora = '$id', rahunok = '$rahunok', sec_data = '$sec_dat', user = '{$_SESSION['login']}'",$db);
$autoinc = $myr_max_id_rh['ID'] + 2;
$res_alert = mysql_query("ALTER TABLE otchet AUTO_INCREMENT = $autoinc",$db);	
}
else {
$res_rah = mysql_query("INSERT INTO rahunok SET ID = '{$myr_max_id_ot['ID']}'+1, date = '$dat', ID_operatora = '$id', rahunok = '$rahunok', sec_data = '$sec_dat', user = '{$_SESSION['login']}'",$db);
$autoinc = $myr_max_id_ot['ID'] + 2;
$res_alert = mysql_query("ALTER TABLE otchet AUTO_INCREMENT = $autoinc",$db);
}

if ((isset($magazine)) && ($magazine <> '0')) {
	
$vkassein = $vkasse_mag - $popolnenie;

$res_kassa=mysql_query("INSERT INTO kassa SET ID_prodaja = '0', data = '$dat $vremya', magazine = '$magazine', vkasse = '$vkassein', inkas = '$popolnenie', user = '{$_SESSION['login']}: Пополнение счета', sec_data = '$sec_dat'",$db);		
	}


header("Location: ../operatoru.php");
}
?>