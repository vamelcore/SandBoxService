<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
 
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

      if (isset($_POST['kategory'])) {$kategory = $_POST['kategory'];if ($kategory == '') {unset ($kategory);}}
      if (isset($_POST['tovar'])) {$tovar = $_POST['tovar'];if ($tovar == '') {unset ($tovar);}}
      if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo']; if ($kolichestvo == '') {$kolichestvo = 0;}}
	  if (isset($_POST['shtrih'])) {$shtrih = $_POST['shtrih']; if ($shtrih == '') {unset($shtrih);}}
	  if (isset($_POST['serialnum'])) {$serialnum = $_POST['serialnum']; if ($serialnum == '') {unset($serialnum);}}
	  if (isset($_POST['rangrand'])) {$rangrand = $_POST['rangrand']; if ($rangrand == '') {$rangrand=8;}}

$serialnum_copy = false;
$insert_flag = false;
if (($kolichestvo > 0) && isset($kategory) && isset($tovar)) {

if (isset($serialnum)) {
    $res_find_serial=mysql_query("SELECT DISTINCT serial_number FROM serialnum WHERE serial_number = '$serialnum'",$db);
    if (mysql_num_rows($res_find_serial) > 0) {$serialnum_copy = true;} else { 
	
	if (isset($shtrih))	{$res_shtrih=mysql_query("INSERT INTO shtrihkod SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', shtrih = '$shtrih'",$db); $res_id_shtrih=mysql_query("SELECT ID FROM shtrihkod ORDER BY ID DESC LIMIT 1",$db); $myr_id_shtrih=mysql_fetch_array($res_id_shtrih); $shtrih_id = $myr_id_shtrih['ID']; $insert_flag = true;} else {$shtrih_id = '';}
	
    $res_serial=mysql_query("INSERT INTO serialnum SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', ID_shtrihkoda = '$shtrih_id', serial_number = '$serialnum'",$db); $insert_flag = true;
	
	}
}
elseif (isset($shtrih))	{$res_shtrih=mysql_query("INSERT INTO shtrihkod SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', shtrih = '$shtrih'",$db); $res_id_shtrih=mysql_query("SELECT ID FROM shtrihkod ORDER BY ID DESC LIMIT 1",$db); $myr_id_shtrih=mysql_fetch_array($res_id_shtrih); $shtrih_id = $myr_id_shtrih['ID']; $insert_flag = true;} 

}

if ($insert_flag == true) {$kolichestvo = $kolichestvo-1;}

if (isset($_SESSION['shtrihkod_array'])) {unset($_SESSION['shtrihkod_array']);}
	
if ($kolichestvo > 0) {	
	if ($serialnum_copy == false) {
		$shtrihkod_array = array('k' => $kategory, 't' => $tovar, 'kc' => $kolichestvo, 'sh' => $shtrih, 'r' => $rangrand);	   
	    $_SESSION['shtrihkod_array'] = $shtrihkod_array;
		header("Location: add_shtrihkod.php");
		}
		else {
			$shtrihkod_array = array('k' => $kategory, 't' => $tovar, 'kc' => $kolichestvo, 'sh' => $shtrih, 'r' => $rangrand, 'al' => $serialnum);	   
	        $_SESSION['shtrihkod_array'] = $shtrihkod_array;
			header("Location: add_shtrihkod.php");
			}
}
else {
header("Location: ../sklad.php");
}	
}
else {

header("Location: ../index.php");
die();
}
 ?>
