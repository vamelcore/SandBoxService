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
<title>Редактор таблицы работ</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
  </style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_prodaja.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Редактировать запись</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
  	<td style="width:200px;"><p>Дата:</p></td>
  	<td><textarea name="data" cols="30" rows="1"><?php echo $myrow['data'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Тип:</p></td>
    <td><select name="b">
    	<?php 
    	if ($myrow['b'] == "А") {printf("<option selected = 'selected' value=\"А\">Аксесуар</option>");} else {printf("<option value=\"А\">Аксесуар</option>");}
		if ($myrow['b'] == "М") {printf("<option selected = 'selected' value=\"М\">Материал</option>");} else {printf("<option value=\"М\">Материал</option>");}
		if ($myrow['b'] == "МР") {printf("<option selected = 'selected' value=\"МР\">Материал+Работа</option>");} else {printf("<option value=\"МР\">Материал+Работа</option>");}
		if ($myrow['b'] == "Р") {printf("<option selected = 'selected' value=\"Р\">Работа</option>");} else {printf("<option value=\"Р\">Работа</option>");}
    	?></select></td>
  </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Магазин:</p></td>
  	<td><select name="magazine" id="mag">
  			
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
	<td><p>Категория:</p></td>	
	<td>
		<select name="kategory" id="kat">
  			<?php 
$result_kateg = mysql_query("SELECT `ID`,`kateg` FROM sklad_kategorii",$db);	
$myrow_kateg = mysql_fetch_array($result_kateg);  			

do {
	if ($myrow_kateg['kateg'] == $myrow['kategoria']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_kateg["ID"], $myrow_kateg["kateg"]); $katgor = $myrow_kateg["ID"];}
	else {printf ("<option value='%s'>%s</option>" , $myrow_kateg["ID"], $myrow_kateg["kateg"]);}   
    }
while ($myrow_kateg = mysql_fetch_array($result_kateg));  			
  			?>
  		</select>
  		
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Наименование:</p></td>
	<td><select name="tovar" id="tov">
		<?php 
$result_tov = mysql_query("SELECT `ID`, `tovar` FROM prase WHERE ID_kategorii = '$katgor'",$db);
$myrow_tov = mysql_fetch_array($result_tov);

 do {
 	if ($myrow_tov['tovar'] == $myrow['naimenovanie']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_tov["ID"], $myrow_tov["tovar"]);}
	else {printf ("<option value='%s'>%s</option>" , $myrow_tov["ID"], $myrow_tov["tovar"]);} 	    
    }
 while ($myrow_tov = mysql_fetch_array($result_tov));			
		?>
	</select></td>
    </tr>
<!--  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Серийный номер устройства:</p></td>
  	<td><textarea name="serialn" cols="30" rows="1"><?php //echo $myrow['serialnum'] ?></textarea></td>
    </tr>-->
<!--  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Штрих-код:</p></td>
  	<td><textarea name="shtrihkod" cols="30" rows="1"><?php //echo $myrow['shtrihkod'] ?></textarea></td>
    </tr>-->
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Вознаграждение:</p></td>
  	<td><textarea name="voznag_za_jelezo" cols="30" rows="1"><?php echo $myrow['voznag_za_jelezo'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
  	<td><p>Стоимость материалов:</p></td>
  	<td><textarea name="stoimost" cols="30" rows="1"><?php echo $myrow['stoimost'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
    <td><p>Тип работы:</p></td>
  	<td><textarea name="operator" cols="30" rows="1"><?php echo $myrow['operator'] ?></textarea></td>
  </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Работа:</p></td>
  	<td><textarea name="tarifplan" cols="30" rows="1"><?php echo $myrow['tarifn_plan'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Вознаграждение за работу:</p></td>
  	<td><textarea name="voznag_za_tp" cols="30" rows="1"><?php echo $myrow['voznag_za_tp'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Оплата за работу:</p></td>
  	<td><textarea name="oplata_tp_podkl" cols="30" rows="1"><?php echo $myrow['oplata_tp_podkluchenie'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Марка авто:</p></td>
  	<td><textarea name="kluch_evdo" cols="30" rows="1"><?php echo $myrow['kluch_evdo'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Контактний номер телефона:</p></td>
  	<td><textarea name="kontakt_nom_tel" cols="30" rows="1"><?php echo $myrow['kontakt_nomer_tel'] ?></textarea></td>
    </tr>    
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>ФИО:</p></td>
  	<td><textarea name="fio" cols="30" rows="1"><?php echo $myrow['FIO'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Абонентский номер:</p></td>
  	<td><textarea name="abon_nomer" cols="30" rows="1"><?php echo $myrow['abonent_nomer'] ?></textarea></td>
    </tr>
 <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Место пользования:</p></td>
  	<td><textarea name="mesto_polz" cols="30" rows="1"><?php echo $myrow['mesto_polz'] ?></textarea></td>
    </tr>     
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Скидка:</p></td>
  	<td><textarea name="skidka" cols="30" rows="1"><?php echo $myrow['skidka'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Примечание:</p></td>
  	<td><textarea name="primech" cols="30" rows="1"><?php echo $myrow['add'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Кем выполнено:</p></td>
  	<td><textarea name="user" cols="30" rows="1"><?php echo $myrow['user'] ?></textarea></td>
    </tr>  
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
  </tr>
 </table>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
         $("#kat").change(function(){		 		
         $("#tov").load("./get_tov_from_sklad.php", { kat: $("#kat option:selected").val(), mag: $("#mag option:selected").val() });
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