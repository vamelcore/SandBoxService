<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_pro'] == 1) && ($_SESSION['vot_priv_pro'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_prodaja'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM prodaja WHERE ID='$id'",$db);
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
	
<form action="insert_prodaja.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
  	<td style="width:200px;"><p>Дата:</p></td>
  	<td style="width:200px;"><p><?php echo $myrow['data'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
    <td><p>Тип:</p></td>
  	<td><p><?php echo $myrow['b'] ?></p></td>
  </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Магазин:</p></td>
  	<td><p><?php echo $myrow['magazin'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Категория:</p></td>
  	<td><p><?php echo $myrow['kategoria'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Наименование:</p></td>
  	<td><p><?php echo $myrow['naimenovanie'] ?></p></td>
    </tr>
<!--  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Серийный номер устройства:</p></td>
  	<td><p><?php //echo $myrow['serialnum'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Штрих-код:</p></td>
  	<td><p><?php //echo $myrow['shtrihkod'] ?></p></td>
    </tr>-->
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Вознаграждение:</p></td>
  	<td><p><?php echo $myrow['voznag_za_jelezo'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
  	<td><p>Стоимость материалов:</p></td>
  	<td><p><?php echo $myrow['stoimost'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
    <td><p>Тип работы:</p></td>
  	<td><p><?php echo $myrow['operator'] ?></p></td>
  </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Работа:</p></td>
  	<td><p><?php echo $myrow['tarifn_plan'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Вознаграждение за работу:</p></td>
  	<td><p><?php echo $myrow['voznag_za_tp'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Оплата за работу:</p></td>
  	<td><p><?php echo $myrow['oplata_tp_podkluchenie'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Марка авто:</p></td>
  	<td><p><?php echo $myrow['kluch_evdo'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p><?php echo $myrow['kontakt_nomer_tel'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>ФИО:</p></td>
  	<td><p><?php echo $myrow['FIO'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Абонентский номер:</p></td>
  	<td><p><?php echo $myrow['abonent_nomer'] ?></p></td>
    </tr>
    <tr bgcolor="#ecf2f6" style="height:20px;">
 <td ><p>Место пользования:</p></td>
  	<td><p><?php echo $myrow['mesto_polz'] ?></p></td>
    </tr> 
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Скидка:</p></td>
  	<td><p><?php echo $myrow['skidka'] ?></p></td>
    </tr> 
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Примечание:</p></td>
  	<td><p><?php echo $myrow['add'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Кем выполнено:</p></td>
  	<td><p><?php echo $myrow['user'] ?></p></td>
    </tr>  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" style="width:100px;" type="submit" value="Удалить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
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