<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['sebespriv'] == 1)) {

 if (isset($_GET['id'])) {$id = $_GET['id']; $_SESSION['id_rashodu'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM rashodu WHERE ID='$id'",$db);
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
	
<form action="insert_rashodu.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6" height="20">
  	<td width="200"><p>Тип:</p></td>
  	<td width="200"><strong><?php if ($myrow['p_m'] = 'minus') {$rashod_p_m = 'Расход';} else {$rashod_p_m = 'Доход';} echo $rashod_p_m;?></strong></td>
    </tr>
  <tr bgcolor="#dce6ee" height="20">
    <td><p>Магазин:</p></td>
  	<td><strong><?php
	 if ($myrow['ID_magazina'] == '0') {$magaz_p_m = 'Все';}
     else {
     $no = 1;	
     do {
     if ($myrow['ID_magazina'] == $_SESSION['id_mag'][$no]) {$magaz_p_m = $_SESSION['name_mag'][$no];}	
     $no++;
     }
     while(isset($_SESSION['id_mag'][$no]));
     }	
	 echo $magaz_p_m; ?></strong></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Описание:</p></td>
  	<td><input name="primech" style="width:195px" value="<?php echo $myrow['primech']; ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Сумма, грн:</p></td>
  	<td><input name="summ" style="width:195px" value="<?php echo $myrow['summ']; ?>"></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../rashodu.php'" ></td>
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