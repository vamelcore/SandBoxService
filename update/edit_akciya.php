<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

 if (isset($_GET['id'])) {$id = $_GET['id']; $_SESSION['id_akc'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM akciya WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 250px;}
  </style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_akciya.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Категория товара:</p></td>
  	<td width="200"><select name="kategory" id="kateg">
  			<?php 
$res_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii ORDER BY ID ASC",$db);	
$myr_kat = mysql_fetch_array($res_kat);
do {

if ($myr_kat['ID'] == $myrow['ID_kateg']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
  			?>
  		</select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Имя товара:</p></td>
  	<td><select name="tovar" id="tovar">
<?php 

$res_tov = mysql_query("SELECT `ID`,`tovar` FROM prase WHERE ID_kategorii = '{$myrow['ID_kateg']}' ORDER BY ID ASC",$db);	
$myr_tov = mysql_fetch_array($res_tov);
do {

if ($myr_tov['ID'] == $myrow['ID_tov']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);}	
}		
while ($myr_tov = mysql_fetch_array($res_tov));
  			?>		
	</select></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Оператор:</p></td>
  	<td><select name="operator" id="operator">
		<?php 
$res_op = mysql_query("SELECT `ID`,`oper` FROM operatoru ORDER BY ID ASC",$db); 		
$myr_op = mysql_fetch_array($res_op);  		

do {

if ($myr_op['ID'] == $myrow['ID_oper']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_op['ID'],$myr_op['oper']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_op['ID'],$myr_op['oper']);}	
}		
while ($myr_op = mysql_fetch_array($res_op));


  		?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Тарифный план:</p></td>
  	<td><select name="tarifplan" id="tarpl">
		<?php 

$res_tp = mysql_query("SELECT `ID`, `tarifplan` FROM tarifplan WHERE ID_oper = '{$myrow['ID_oper']}' ORDER BY ID ASC",$db);	
$myr_tp = mysql_fetch_array($res_tp);
do {

if ($myr_tp['ID'] == $myrow['ID_tp']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tp['ID'],$myr_tp['tarifplan']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tp['ID'],$myr_tp['tarifplan']);}	
}		
while ($myr_tp = mysql_fetch_array($res_tp));


  			?>	
	</select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Цена:</p></td>
  	<td><input type="text" name="cena" value="<?php echo $myrow['cena'];?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Вознаграждение:</p></td>
  	<td><input type="text" name="voznag" value="<?php echo $myrow['voznag'];?>"></td>
    </tr>  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../akciya.php'" ></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
         $("#kateg").change(function(){		 		
         $("#tovar").load("./get_tov_from_prise.php", { kateg: $("#kateg option:selected").val() });
         });
         </script>
<script type="text/javascript">
         $("#operator").change(function(){		 		
         $("#tarpl").load("./get_prodaja_tp.php", { operator: $("#operator option:selected").val() });
         });

		 </script>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>