<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['sebespriv'] == 1)) {

 if (isset($_GET['id'])) {$id = $_GET['id']; unset($_GET['id']); if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM sebestoim WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);

$res_tov = mysql_query("SELECT `tovar` FROM `prase` WHERE ID = '{$myrow['ID_tovara']}'",$db);
$myr_tov = mysql_fetch_array($res_tov);

$res_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$myrow['ID_magazina']}'",$db);
$myr_mag = mysql_fetch_array($res_mag);

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
	
<form action="insert_sebes.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td width="200"><p>Дата добавления:</p></td>
  	<td width="200" height="20"><?php echo $myrow['data'];?></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Магазин:</p></td>
  	<td height="20"><?php echo $myr_mag['name'];?></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Наименование товара:</p></td>
  	<td height="20"><?php echo $myr_tov['tovar'];?></td>
  </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Количество, шт:</p></td>
  	<td height="20"><input type="text" style="width:205px" name="kol_sebes" value="<?php echo $myrow['kolichestvo'];?>"></td>
  </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Себестоимость, грн:</p></td>
  	<td height="20"><input type="text" style="width:205px" name="sebes" value="<?php echo $myrow['sebestoimost'];?>"><input type="hidden" name="id_seb" value="<?php echo $id;?>"><input type="hidden" name="id_to_back_sebes" value="<?php echo $myrow['ID_tovara'];?>"></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../sebestoim.php?id=<?php echo $myrow['ID_tovara'];?>'" ></td>
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