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
<title>Редактор таблицы отчетов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
  </style>

</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_otchet.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактировать отчет</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Дата:</p></td>
  	<td><textarea name="data" cols="30" rows="1"><?php echo $myrow['data'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Магазин:</p></td>
  	<td><select name="magazin" id="mag">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no +1;
	
if ($myrow['magazin'] == $_SESSION['name_mag'][$no])	{
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag'] - 1);

 ?>
</select></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><input type="hidden" name="operator" value="<?php echo $myrow['ID_operatora'] ?>"><p>ФИО:</p></td>
  	<td><textarea name="fio" cols="30" rows="1"><?php echo $myrow['fio'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер абонента:</p></td>
  	<td><textarea name="nomer_ab" cols="30" rows="1"><?php echo $myrow['nomer_abon'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Контактный номер телефона:</p></td>
  	<td><textarea name="kontact_nomer" cols="30" rows="1"><?php echo $myrow['kontakt_nomer'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Пакет:</p></td>
  	<td><textarea name="paket" cols="30" rows="1"><?php echo $myrow['paket'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Ключ EVDO:</p></td>
  	<td><textarea name="kluch_evdo" cols="30" rows="1"><?php echo $myrow['kluch_evdo'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Аванс:</p></td>
  	<td><textarea name="avans" cols="30" rows="1"><?php echo $myrow['avans'] ?></textarea></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Оплата с лицевого счета:</p></td>
  	<td><textarea name="oplata" cols="30" rows="1"><?php echo $myrow['oplata'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Остаток на лицевом счете:</p></td>
  	<td><textarea name="ostatok" cols="30" rows="1"><?php echo $myrow['ostatok'] ?></textarea></td>
    </tr>  
  <tr bgcolor="#ecf2f6">
	<td><p>Оборудование:</p></td>
  	<td><textarea name="oborudovanie" cols="30" rows="1"><?php echo $myrow['oborudov'] ?></textarea></td>
    </tr>
  
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" style="width:100px;" type="submit" value="Сохранить" ></td>
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