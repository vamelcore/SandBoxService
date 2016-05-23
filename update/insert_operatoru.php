<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['oper'])) {$oper = $_POST['oper']; if ($oper == '') {unset ($oper);}}
if (isset($_POST['priznak'])) {$priznak = $_POST['priznak']; if ($priznak == '') {unset ($priznak);}}
else {$priznak = 'Нет';}
if ((isset($_POST['schet'])) && ($priznak <> 'Нет')) {$schet = $_POST['schet']; if ($schet == '') {$schet = '0';}}
else {$schet = '----';}

if ((isset($_POST['edit'])) && (isset($_SESSION['id_operator']))) {
	
	$res=mysql_query("UPDATE operatoru SET oper = '$oper', priznak = '$priznak', schet = '$schet' WHERE ID = '{$_SESSION['id_operator']}'",$db);
	unset($_SESSION['id_operator']);
}
else {	
if (isset($id)) {
	$result = mysql_query("SELECT * FROM tarifplan WHERE `ID_oper` = '$id'",$db);	
	if (mysql_num_rows($result) > 0) {?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Есть тарифные планы, которые привязаны к этому оператору. <a href="../tarifplan.php">Тарывный план</a> || <a href="../operatoru.php">Назад</a></p>
</body>
</html>			
			
<?php		die();}	
		
	else {$res = mysql_query("DELETE FROM operatoru WHERE ID='$id'",$db);}
}

else {
      
$res=mysql_query("INSERT INTO operatoru SET oper = '$oper', priznak = '$priznak', schet = '$schet'",$db);	
}
}

header("Location: ../operatoru.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>