<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_ost'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_xss($_GET); $_GET=defender_sql($_GET);  $id = $_GET['id']; $_SESSION['id_tovara'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM sklad_tovaru WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);

if ($myrow['kolichestvo'] == '0') { ?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">	
	<p>Количество товара <? echo $myrow['tovar']; ?> в этом магазине равно 0, его нельзя переместить! <a href="../sklad.php">Вернуться на Остатки</a></p>
</div>
</body>
</html>	
<?php 	

}

else {


$result_from = mysql_query("SELECT `ID`, `name` FROM magazinu WHERE `ID` = '{$myrow['ID_magazina']}'",$db);
$myrow_from = mysql_fetch_array($result_from);


$result_mag = mysql_query("SELECT `ID`, `name` FROM magazinu",$db);
$myrow_mag = mysql_fetch_array($result_mag);


$result_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii WHERE `ID` = '{$myrow['ID_kategorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat);


$result_tov = mysql_query("SELECT `ID`, `tovar` FROM prase WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="replace_tovar.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Редактировать таблицу товаров</p></b></td>
    </tr>
  
  <tr bgcolor="#dce6ee">
	<td height="20px"><p>Из магазина:</p></td>
  	<td height="20px"><p><?php echo $myrow_from['name']; ?></p><input name="from_mag" type="hidden" value="<?php echo $myrow_from['ID']; ?>"><input name="from_mag_name" type="hidden" value="<?php echo $myrow_from['name']; ?>"></td>
  
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>В магазин:</p></td> 	
  	<td>
  		<select name="to_mag">
  			
<?php
do { 
//$no = $no + 1;
if ($myrow['ID_magazina'] == $myrow_mag['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
else {
printf("<option value=\"%s\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
}
while($myrow_mag = mysql_fetch_array($result_mag));

 ?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td height="20px"><p>Категория товара:</p></td>
  	<td height="20px"><p><?php echo $myrow_kat['kateg']; ?></p><input name="kategorya" type="hidden" value="<?php echo $myrow_kat['ID']; ?>"><input name="kategorya_name" type="hidden" value="<?php echo $myrow_kat['kateg']; ?>"></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td height="20px"><p>Наименование товара:</p></td>
  	<td height="20px"><p><?php echo $myrow_tov['tovar']; ?></p><input name="name_tovar" type="hidden" value="<?php echo $myrow_tov['ID']; ?>"><input name="tovar_name" type="hidden" value="<?php echo $myrow_tov['tovar']; ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество:</p></td>
  	<td><select name="kolichestvo"><?php 
if ($myrow['kolichestvo'] > '0'){
$i='1';
do {

printf("<option value=\"%s\">%s</option>",$i,$i);	
$i=$i+1;	

} while ($i <= $myrow['kolichestvo']);
}
  	
?></select></td>
    </tr>  
  
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr>
 </table>
 
 </form>
 
 </td></tr></table>
 
</div>

</body>
</html>

<?php

}

}
else {

header("Location: ../index.php");
die();
}
 ?>