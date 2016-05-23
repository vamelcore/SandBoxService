<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_voz'] == 1) && ($_SESSION['vot_priv_voz'] == 1)) {

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
<title>Редактор таблицы возвратов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<script type="text/javascript">
function hd(){
document.getElementById('hide_skidka').style.display = 'none';
}

function show(){
if ((document.getElementById('obmen_vozv').value == '0') || (document.getElementById('obmen_vozv').value == ''))	{document.getElementById('hide_skidka').style.display = 'none';}
else {document.getElementById('hide_skidka').style.display = '';}
}
</script>

<style type="text/css">
   SELECT {width: 205px;}
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
  </style>

</head>

<body onLoad="hd()">
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_vozvrat.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Добавить запись</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата приема:</p></td>
  	<td align="center"><p align="ceenter"><?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?></p><input name="data_priema" type="hidden" value="<?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?>"></td>
    </tr>
    <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td>
  		<select name="magazine" id="mag_vozv">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no +1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	$_SESSION['magazin_selected'] = $_SESSION['name_mag'][$no];
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
    <td><p>Тип:</p></td>
  	<td><select name="t_a"><option value="Т">Терминал</option><option value="А">Аксесуар</option></select></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Категория:</p></td>
  	<td>
  		<select name="kategory" id="kat_vozv"><option value="">Выберите категорию</option>
  			<?php
$result_kat = mysql_query("SELECT DISTINCT `kategoria` FROM prodaja WHERE magazin = '{$_SESSION['magazin_selected']}' ORDER BY `kategoria`",$db);
$myrow_kat = mysql_fetch_array($result_kat);  			

do {
	if ($myrow_kat["kategoria"] <> '') {	
     printf ("<option value='%s'>%s</option>" , $myrow_kat["kategoria"], $myrow_kat["kategoria"]);}
    }
while ($myrow_kat = mysql_fetch_array($result_kat)); 			
  			?>
  		</select>
  		
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Наименование:</p></td>
  	<td>
  		<select name="naimenovanie" id="naim_vozv"></select>
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Дата покупки:</p></td>
  	<td>
  		<select name="data_pokupki" id="pokup_vozv"></select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество:</p></td>
  	<td><input type="text" readonly="readonly" name="kolichestvo" value="1"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ESN:</p></td>
  	<td><input type="text" name="esn" value=""></td> 
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Стоимость:</p></td>
  	<td id="summa_vozv"><input type="text" name="summanal" value=""></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Скидка:</p></td>
  	<td id="skid_vozv"><input type="text" name="summabeznal" value=""></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Причина возврата:</p></td>
  	<td><textarea name="prichina_vozv"></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Период 14 дней:</p></td>
  	<td><select name="per14dn"><option value="Да">Да</option><option value="Нет">Нет</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Обмен на:</p></td>
  	<td>
  		<select name="obmen" id="obmen_vozv" onchange="show()"><option value="">Выберите категорию</option></select>
  	</td>
    </tr>
  <tr id="hide_skidka" bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td>
  		<input type="text" name="skidka" value="">
  	</td>
    </tr>        
  <tr bgcolor="#ecf2f6">
  	<td><p>Дальнейшее движение:</p></td>
  	<td><select name="daln_dvizhen"><option value="Не определено">Не определено</option><option value="Отправлен в ремонт">Отправлен в ремонт</option><option value="Поставлен на приход">Поставлен на приход</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечания:</p></td>
  	<td><textarea name="primechanie"></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Кто принял:</p></td>
  	<td><input type="text" name="kto_pvinyal" readonly="true" value="<?php echo $_SESSION['login'];?>"></td>
    </tr>
<?php
if ($_SESSION['vozvrat_voznag'] == '1') {
printf('
  <tr bgcolor="#dce6ee">
	<td><p>Абонент использует ТП?</p></td>
  	<td><select name="abon_ispolz_tp"><option value="yes">Да</option><option value="no">Нет</option></select></td>
    </tr>
');
}	
?>   
 </table>
<div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../vozvratu.php'" ></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
         $("#mag_vozv").change(function(){		 		
         $("#kat_vozv").load("./get_kat_from_prodaja.php", { mag: $("#mag_vozv option:selected").val() });
         });

		 </script>

<script type="text/javascript">
         $("#kat_vozv").change(function(){		 		
         $("#naim_vozv").load("./get_naim_from_prodaja.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val() });
         $("#obmen_vozv").load("./get_obmen_from_sklad_tovaru.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val() });
         });

		 </script>

<script type="text/javascript">
         $("#naim_vozv").change(function(){		 		
         $("#pokup_vozv").load("./get_pokup_from_prodaja.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val(), naim: $("#naim_vozv option:selected").val() });
         });

		 </script>

<script type="text/javascript">
         $("#pokup_vozv").change(function(){		 		
         $("#summa_vozv").load("./get_summa_from_prodaja.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val(), naim: $("#naim_vozv option:selected").val(), pokup: $("#pokup_vozv option:selected").val() });
         $("#skid_vozv").load("./get_skid_from_prodaja.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val(), naim: $("#naim_vozv option:selected").val(), pokup: $("#pokup_vozv option:selected").val() });
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