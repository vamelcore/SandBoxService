<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1) && ($_SESSION['vot_priv_ost'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_tovara'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM sklad_tovaru WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<style type="text/css">
   SELECT {width: 210px;}
   INPUT {width: 200px;}
  </style>

</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_sklad.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Редактировать товар на Остаткие</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td>
  		<select name="magazine">
  			
<?php
$result_mag = mysql_query("SELECT `ID`, `name` FROM magazinu",$db);
$myrow_mag = mysql_fetch_array($result_mag);

do { 

if ($myrow['ID_magazina'] == $myrow_mag['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
else {
printf("<option value=\"%s\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
}
while($myrow_mag = mysql_fetch_array($result_mag));

 ?>

			</select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Категория товара:</p></td>
  	<td>
  		
  	<select name="kategory" id="kateg">
  			
<?php
$result_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);
$myrow_kat = mysql_fetch_array($result_kat);

do { 

if ($myrow['ID_kategorii'] == $myrow_kat['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_kat['ID'],$myrow_kat['kateg']);}
else {
printf("<option value=\"%s\">%s</option>",$myrow_kat['ID'],$myrow_kat['kateg']);}
}
while($myrow_kat = mysql_fetch_array($result_kat));

 ?>

			</select>	
  		
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Наименование товара:</p></td>
  	<td><select name="tovar" id="tov">
  		
<?php
$result_tov = mysql_query("SELECT `ID`, `tovar` FROM prase WHERE ID_kategorii ='{$myrow['ID_kategorii']}' ",$db);
$myrow_tov = mysql_fetch_array($result_tov);

do { 

if ($myrow['ID_tovara'] == $myrow_tov['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_tov['ID'],$myrow_tov['tovar']);}
else {
printf("<option value=\"%s\">%s</option>",$myrow_tov['ID'],$myrow_tov['tovar']);}
}
while($myrow_tov = mysql_fetch_array($result_tov));

 ?>
  		
  		
  		
  	</select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество:</p></td>
  	<td><input type="text" name="kolichestvo" value="<?php echo $myrow['kolichestvo'] ?>"></td>
    </tr>
    
    
  
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr>
 </table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
         $("#kateg").change(function(){		 		
         $("#tov").load("./get_tov.php", { kateg: $("#kateg option:selected").val() });
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