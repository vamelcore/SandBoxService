<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_voz'] == 1) && ($_SESSION['vot_priv_voz'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_vozvrat'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM vozvratu WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы возвратов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
  </style>

</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_vozvrat.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактировать возврат</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Дата приема:</p></td>
  	<td><textarea name="data_priema" cols="30" rows="1"><?php echo $myrow['data'] ?></textarea></td>
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
	<td><p>Тип:</p></td>
  	<td><textarea name="t_a" cols="30" rows="1"><?php echo $myrow['t_a'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td><textarea name="kategory" cols="30" rows="1"><?php echo $myrow['kategoria'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Наименование:</p></td>
  	<td><textarea name="naimenovanie" cols="30" rows="1"><?php echo $myrow['naimenovanie'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>ESN:</p></td>
  	<td><textarea name="esn" cols="30" rows="1"><?php echo $myrow['esn'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Количество:</p></td>
  	<td><textarea name="kolichestvo" cols="30" rows="1"><?php echo $myrow['kolichestvo'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Дата покупки:</p></td>
  	<td><textarea name="data_pokupki" cols="30" rows="1"><?php echo $myrow['data_pokupki_vozvr_ob'] ?></textarea></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Стоимость:</p></td>
  	<td><textarea name="summanal" cols="30" rows="1"><?php echo $myrow['summa_nal'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td><textarea name="summabeznal" cols="30" rows="1"><?php echo $myrow['summa_bez_nal'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Причина возврата:</p></td>
  	<td><textarea name="prichina_vozv" cols="30" rows="1"><?php echo $myrow['prichina_vozvrata'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Период 14 дней:</p></td>
  	<td><textarea name="per14dn" cols="30" rows="1"><?php echo $myrow['per_14_dney'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Обмен на:</p></td>
  	<td><textarea name="obmen" cols="30" rows="1"><?php echo $myrow['obmen_na'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Дальнейшее движение:</p></td>
  	<td><select name="daln_dvizhen"><?php
  	if ($myrow['daln_dvijenie_vozvr_tov'] == 'Не определено') {printf("<option selected=\"selected\" value=\"Не определено\">Не определено</option>");} else {printf("<option value=\"Не определено\">Не определено</option>");}
	if ($myrow['daln_dvijenie_vozvr_tov'] == 'Отправлен в ремонт') {printf("<option selected=\"selected\" value=\"Отправлен в ремонт\">Отправлен в ремонт</option>");} else {printf("<option value=\"Отправлен в ремонт\">Отправлен в ремонт</option>");}
	if ($myrow['daln_dvijenie_vozvr_tov'] == 'Поставлен на приход') {printf("<option selected=\"selected\" value=\"Поставлен на приход\">Поставлен на приход</option>");} else {printf("<option value=\"Поставлен на приход\">Поставлен на приход</option>");}
  	 ?></select></td>
    </tr>    
  <tr bgcolor="#ecf2f6">
	<td><p>Примечания:</p></td>
  	<td><textarea name="primechanie" cols="30" rows="1"><?php echo $myrow['primechanie'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Кто принял:</p></td>
  	<td><textarea name="kto_pvinyal" cols="30" rows="1"><?php echo $myrow['kto_pvinyal']?></textarea><input type="hidden" name="sec_data" value="<?php echo $myrow['sec_data'];?>"><input type="hidden" name="sebestoim" value="<?php echo $myrow['sebestoim'];?>"></td>
    </tr>  
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../vozvratu.php'" ></td>
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