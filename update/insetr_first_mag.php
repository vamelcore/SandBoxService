<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['root_priv'] == 1)) {

//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['first_mag_name'])) {$first_mag_name = $_POST['first_mag_name']; if ($first_mag_name == '') {unset($first_mag_name);}}
echo 'A'.$first_mag_name.'A';
//die();
if (isset($first_mag_name)) {
$_SESSION['name_mag'][1] = $first_mag_name;
$res=mysql_query("UPDATE `magazinu` SET `name` = '$first_mag_name' WHERE ID = '1'",$db);
header("Location: ../page.php");
}
else {
header("Location: ../first_start.php");
}

	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>
