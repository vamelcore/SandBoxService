<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

 if (isset($_GET['id'])) {$id = $_GET['id']; $_SESSION['id_tarpl'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM tarifplan WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_tarifplan.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Тип работы:</p></td>
  	<td width="200"><select name="selected_op"><?php 
$res_op =mysql_query("SELECT `ID`,`oper` FROM operatoru");
$myr_op = mysql_fetch_array($res_op);
do {
if ($myr_op['ID'] ==  $myrow['ID_oper']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_op['ID'],$myr_op['oper']);
} else {
	printf("<option value=\"%s\">%s</option>",$myr_op['ID'],$myr_op['oper']);
}	
}
while ($myr_op = mysql_fetch_array($res_op));
?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Работа:</p></td>
  	<td><textarea name="tarifplan" cols="30" rows="1"><?php echo $myrow['tarifplan'] ?></textarea></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Оплата за работу:</p></td>
  	<td><textarea name="stoimpodkl" cols="30" rows="1"><?php echo $myrow['stoim_podkl'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Вознаграждение:</p></td>
  	<td><textarea name="voznagtp" cols="30" rows="1"><?php echo $myrow['voznagtp'] ?></textarea></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../tarifplan.php'" ></td>
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