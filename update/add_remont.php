<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_rem'] == 1) && ($_SESSION['vot_priv_rem'] == 1)) {

if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['selector_of_stores'] =$_SESSION['id_mag']['1'];}
				else {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
			}
		
	}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы ремонтов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<style type="text/css">
   SELECT {width: 205px;}
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
  </style>

</head>

<body>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_remont.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Добавить запись</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата приема:</p></td>
  	<td align="center"><p align="ceenter"><?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?></p><input name="data_priema" type="hidden" value="<?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?>"></td>
    </tr>
    <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td>
  		<select name="magazine">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no +1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}
if ($_SESSION['id_mag'][$no+1] == 'all') {$no++;}		
}
while($no < $_SESSION['count_mag']);

 ?>
</select>
  	</td>
    </tr>
    
    
  <tr bgcolor="#dce6ee">
    <td><p>Номер телефона:</p></td>
  	<td><input type="text" name="nomer_tel" value=""></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Модель:</p></td>
  	<td><input type="text" name="model" value=""></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Причина ремонта:</p></td>
  	<td><textarea name="prichina_rem" cols="30" rows="1"></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Гарантийный:</p></td>
  	<td><select name="gar"><option value="Есть">Есть</option><option value="Нет">Нет</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Стоимость:</p></td>
  	<td><input type="text" name="stoimost" value=""></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Заключение:</p></td>
  	<td><textarea name="zakluch" cols="30" rows="5"></textarea></td>
    </tr>
 
 </table>
<div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" type="submit" value="Сохранить" style="width:100px" ></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" style="width:100px" onclick="top.location.href='../remontu.php'" ></td>
  </tr></table></div>
 
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