<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['rollpriv'] == 1) && ($_SESSION['vot_priv_pro'] == 1)) {

$result = mysql_query("SELECT `ID`, `data` FROM `prodaja` WHERE `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC LIMIT 0 , 50",$db);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Отмена работы</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_rollback_prodaja.php" method="post" name="formroll">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Отмена работы</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="140"><p>ID транзакции / Дата:</p></td>
  	<td width="260"><select id="id_data" name='id' style="width:100%;"><option>Выберите запись</option>
<?php while($myrow = mysql_fetch_array($result)) {
printf("<option value=%s>ID: %s/Дата: %s</option>",$myrow['ID'],$myrow['ID'],$myrow['data']);	
	}?>  	
  	</select></td>
    </tr>
    <tr><td colspan="2" id="roll_info"><table>
  <tr bgcolor="#dce6ee">
    <td width="200"><p>Тип:</p></td>
  	<td width="200"><p></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Наименование:</p></td>
  	<td><p></p></td>
    </tr>
<!--  <tr bgcolor="#dce6ee">
	<td><p>Серийный номер устройства:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Штрих-код:</p></td>
  	<td><p></p></td>
    </tr>-->
  <tr bgcolor="#dce6ee">
	<td><p>Вознаграждение:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Стоимость материалов:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td><p>Процент от продажи:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Тип работы:</p></td>
  	<td><p></p></td>
  </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Работа:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Вознаграждение за работу:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Оплата за работу:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Марка авто:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Абонентский номер:</p></td>
  	<td><p></p></td>
    </tr>
    <tr bgcolor="#ecf2f6">
 <td><p>Место пользования:</p></td>
  	<td><p></p></td>
    </tr> 
  <tr bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td><p></p></td>
    </tr> 
  <tr bgcolor="#ecf2f6">
	<td><p>Примечание:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Кем выполнино:</p></td>
  	<td><p></p></td>
    </tr></table></td></tr> 
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="otkat" style="width:120px" type="submit" value="Отмена продажи" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>
<script type="text/javascript">
$(document).ready(function(){ 
         $("#id_data").change(function(){		 		
         $("#roll_info").load("./get_prodaja_for_rollback.php", { id_roll: $("#id_data option:selected").val() }, function()         {                
    if ( $("#dissubmit").length ) {
        $("input[type=submit]").attr("disabled", "disabled");
    }
    else {
        $("input[type=submit]").removeAttr("disabled");
    }  
         
});         
});
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