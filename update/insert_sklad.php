<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
$hours = date('H') + $_SESSION['time_zone'];
$data = date ('d.m.Y H:i:s',mktime ($hours));
$sec_data = date ('m.Y',mktime ($hours));
$sys_data = strtotime($data);	
if (isset($_SESSION['id_tovara'])) {

if ($_SESSION['ed_priv_ost'] == 1) {		
	$id = $_SESSION['id_tovara']; unset ($_SESSION['id_tovara']); if ($id == '') {unset ($id);}
	
	$identify == 'no';
    
	if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM sklad_tovaru WHERE ID='$id'",$db); unset ($_POST['delete']);}

    else {

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

      if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
      if (isset($_POST['kategory'])) {$kategory = $_POST['kategory'];if ($kategory == '') {unset ($kategory);}}
      if (isset($_POST['tovar'])) {$tovar = $_POST['tovar'];if ($tovar == '') {unset ($tovar);}}
      if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);} else {if (!is_numeric($kolichestvo)) {$kolichestvo = 0;}}}

     $kol_posl_prihoda='+'.$kolichestvo;	
     $res=mysql_query("UPDATE sklad_tovaru SET ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_posl_prihoda = '$kol_posl_prihoda', data_posl_prihoda = '$data', kolichestvo = '$kolichestvo' WHERE ID='$id'",$db);
//Добавление записи в архив
     $res_arch=mysql_query("INSERT INTO prihodu SET data = '$data', ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_prihoda = '$kolichestvo', primech = 'Редактирование записи, утсановка значения', user = '{$_SESSION['login']}', sec_data = '$sec_data'",$db);	
}
} 
}
else {

if ($_SESSION['add_priv_ost'] == 1) {
	
$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);	
		
     if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
     if (isset($_POST['kategory'])) {$kategory = $_POST['kategory'];if ($kategory == '') {unset ($kategory);}}
     if (isset($_POST['tovar'])) {$tovar = $_POST['tovar'];if ($tovar == '') {unset ($tovar);}}
     if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);} else {if (!is_numeric($kolichestvo)) {$kolichestvo = 0;}}}

if (isset($_POST['sebestoemost'])) {$sebestoemost = $_POST['sebestoemost']; if ($sebestoemost == '') {$sebestoemost = 0;}}

if (isset($_POST['shtrihkod'])) {$shtrihkod = $_POST['shtrihkod']; if ($shtrihkod == '') {$shtrihkod = 'no';}}

$result = mysql_query("SELECT * FROM sklad_tovaru",$db);
$myrow = mysql_fetch_array($result);
	 
$flag = false;
do {

	if (($myrow['ID_magazina'] == $magazine) && ($myrow['ID_kategorii'] == $kategory) && ($myrow['ID_tovara'] == $tovar)) {$flag = true;}
}
while($myrow = mysql_fetch_array($result));

if ($flag == false) {
$kol_posl_prihoda='+'.$kolichestvo;	
$res=mysql_query("INSERT INTO sklad_tovaru SET ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_posl_prihoda = '$kol_posl_prihoda', data_posl_prihoda = '$data', kolichestvo = '$kolichestvo'",$db);	
//Добавление записи в архив
$res_arch=mysql_query("INSERT INTO prihodu SET data = '$data', ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_prihoda = '$kolichestvo', primech = 'Добавление записи о товаре в остатки', user = '{$_SESSION['login']}', sec_data = '$sec_data'",$db);

$res_info_sebes = mysql_query("SELECT `sebespriv` FROM `users`",$db);
$using_sebes = false;
while ($myr_info_sebes = mysql_fetch_array($res_info_sebes)) {
if ($myr_info_sebes['sebespriv'] == '1') {$using_sebes = true;}
}
if ($using_sebes == true) {
$res_sebes = mysql_query("INSERT INTO sebestoim SET ID_magazina = '$magazine', ID_tovara = '$tovar', kolichestvo = '$kolichestvo', sebestoimost = '$sebestoemost', data = '$data', sys_data = '$sys_data'");
}

}
else { ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Вы пытаетесь добавить товар, который уже присутствует в этой категории в этом магазине. <a href="../sklad.php">На страницу товаров</a>.</p>
</body>
</html>


<?php 
die();
}
}
}

if (($shtrihkod == 'yes') && ($_SESSION['add_priv_ost'] == 1)) {
	$shtrihkod_array = array('k' => $kategory, 't' => $tovar, 'kc' => $kolichestvo);
	if (isset($_SESSION['shtrihkod_array'])) {unset($_SESSION['shtrihkod_array']);}
	$_SESSION['shtrihkod_array'] = $shtrihkod_array;
header("Location: add_shtrihkod.php");}
else {
header("Location: ../sklad.php");
}	
}
else {

header("Location: ../index.php");
die();
}
 ?>