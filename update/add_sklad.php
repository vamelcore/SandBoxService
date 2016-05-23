<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_ost'] == 1) && ($_SESSION['vot_priv_ost'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['selector_of_stores'] =$_SESSION['id_mag']['1'];}
				else {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
			}
		
	}
if (isset($_SESSION['id_tovara'])) {unset ($_SESSION['id_tovara']);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Добавить в остатки</title>
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
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Добавить товар на Остатки</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
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
    <td><p>Категория товара:</p></td>
  	<td>
  		
  	<select name="kategory" id="kateg"><option value="">Выберите категорию</option>
  			
<?php
$result_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii ORDER BY `kateg`",$db);
$myrow_kat = mysql_fetch_array($result_kat);

do { 
$no = $no + 1;

printf("<option value=\"%s\">%s</option>",$myrow_kat['ID'],$myrow_kat['kateg']);
}
while($myrow_kat = mysql_fetch_array($result_kat));

 ?>
			</select>			
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Наименование товара:</p></td>
  	<td><select name="tovar" id="tov"></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество, шт:</p></td>
  	<td><input type="text" name="kolichestvo"></td>
    </tr>
<?php
if ($_SESSION['sebespriv'] == 1) {
printf('
  <tr bgcolor="#ecf2f6">
	<td><p>Себестоимость, грн:</p></td>
  	<td><input type="text" name="sebestoemost"></td>
    </tr>
');
$next_color = '#dce6ee';
}
else {$next_color = '#ecf2f6';}
?>
<!--  <tr height="20" bgcolor="<?php //echo $next_color; ?>">
	<td><p>Штрих-код/серийный номер</p></td>
  	<td><select name="shtrihkod"><option value="no">Нет</option><option value="yes">Есть</option></select></td>
    </tr>-->
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr></table></div>
 
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