<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_otch'] == 1) && ($_SESSION['vot_priv_otch'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_otchet'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM otchet WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Удаление записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_otchet.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Дата:</p></td>
  	<td width="200"><p><?php echo $myrow['data'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Магазин:</p></td>
  	<td><p><?php echo $myrow['magazin'] ?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><p><?php echo $myrow['fio'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер абонента:</p></td>
  	<td><p><?php echo $myrow['nomer_abon'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Контактный номер телефона:</p></td>
  	<td><p><?php echo $myrow['kontakt_nomer'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Пакет:</p></td>
  	<td><p><?php echo $myrow['paket'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Ключ EVDO:</p></td>
  	<td><p><?php echo $myrow['kluch_evdo'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Аванс:</p></td>
  	<td><p><?php echo $myrow['avans'] ?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Оплата с лицевого счета:</p></td>
  	<td><p><?php echo $myrow['oplata'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Остаток на лицевом счете:</p></td>
  	<td><p><?php echo $myrow['ostatok'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Оборудование:</p></td>
  	<td><p><?php echo $myrow['oborudov'] ?></p></td>
    </tr>
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" style="width:100px;" type="submit" value="Удалить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../otchet.php'" ></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>