<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");
session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['sebespriv'] == 1)) {
	
	
		if (!isset($_SESSION['id_mag_selected'])) {$_POST['magaz'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['magaz'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['magaz'] =$_SESSION['id_mag']['1'];}
				else {$_POST['magaz'] = $_SESSION['id_mag_selected'];}
			}
		
	}
	
$_SESSION['lastpagevizitadm'] = 'rashodu.php';	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Расходы</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button" href="operatoru.php">Тип работы</a></td><td><a class="like_button" href="tarifplan.php">Работы</a></td><td><a class="like_button" href="plan.php">План</a></td>
            <!--<td><a class="like_button" href="PAYment.php">Дилерам</a></td>-->
<?php
if (isset($_SESSION['sebespriv']) &&($_SESSION['sebespriv'] == 1)) {
printf('<td><a class="like_button_use" href="rashodu.php">Расходы</a></td>');}
if (isset($_SESSION['kontpriv']) &&($_SESSION['kontpriv'] == 1)) {
printf('<td><a class="like_button" href="kontrol.php">Контроль</a></td>');}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr><td style="border-bottom:1px solid #c6d5e1;" align="center"><form method="post" action="update/insert_rashodu.php"><table align="center"><tr><td align="center">Тип</td><td align="center">Магазин</td><td align="center">Описание</td><td align="center">Сумма, грн</td><td></td></tr><tr><td>
<select name="p_m" onChange="javascript:form.submit()">
<?php 
if (isset($_SESSION['plus_minus'])) {
if ($_SESSION['plus_minus'] == 'minus') {printf('<option value="minus" selected="selected">Расходы</option>'); $_SESSION['plus_minus'] = 'minus';} 
else {printf('<option value="minus">Расходы</option>');}
if ($_SESSION['plus_minus'] == 'plus') {printf('<option value="plus" selected="selected">Доходы</option>'); $_SESSION['plus_minus'] = 'plus';} 
else {printf('<option value="plus">Доходы</option>');}
}
else {
$_SESSION['plus_minus'] = 'minus';
printf('<option value="minus" selected="selected">Расходы</option>');
printf('<option value="plus">Доходы</option>');
}
?>
</select>
</td><td>
<select name="magaz" onChange="javascript:form.submit()">
<?php

//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 1;	
do {
	
if ($_SESSION['id_mag_selected'] == $_SESSION['id_mag'][$no])	{

	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}
$no++;
//if ($_SESSION['id_mag'][$no] == 'all') {$no++;}		
}
while(isset($_SESSION['id_mag'][$no]));

?>
</select>
</td><td><input type="text" name="primech" style="width:200px"></td><td><input type="text" name="summ" style="width:65px"></td><td><input type="submit" value="Добавить"></td></tr></table></form></td></tr>  
<tr><td style="border-bottom:1px solid #c6d5e1;" align="center">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="400">
		<thead>
			<tr>
				<th width="40" class="nosort"><h3>Удалить</h3></th>
				<th width="40" class="nosort"><h3>Редакт.</h3></th>
				<th width="120"><h3>Тип</h3></th>
				<th width="120"><h3>Магазин</h3></th>
				<th width="120"><h3>Описание</h3></th>
				<th width="120"><h3>Сумма, грн</h3></th>
                                <th width="120"><h3>Дата</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
if ($_SESSION['id_mag_selected'] == 'all') {$result = mysql_query("SELECT * FROM rashodu WHERE p_m = '{$_SESSION['plus_minus']}' AND ID_magazina = '0' ORDER BY ID DESC",$db);}
else {$result = mysql_query("SELECT * FROM rashodu WHERE p_m = '{$_SESSION['plus_minus']}' AND ID_magazina = '{$_SESSION['id_mag_selected']}' ORDER BY ID DESC",$db);}

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
 
do {

if ($myrow['p_m'] == 'minus') {$rashod_p_m = 'Расход';} else {$rashod_p_m = 'Доход';}

if ($myrow['ID_magazina'] == '0') {$magaz_p_m = 'Все';}
else {
$no = 1;	
do {
if ($myrow['ID_magazina'] == $_SESSION['id_mag'][$no]) {$magaz_p_m = $_SESSION['name_mag'][$no];}	
$no++;
}
while(isset($_SESSION['id_mag'][$no]));
}

	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_rashodu.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_rashodu.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$myrow['ID'],$myrow['ID'],$rashod_p_m,$magaz_p_m,$myrow['primech'],$myrow['summ'],$myrow['data']);
	
}
while($myrow = mysql_fetch_array($result));

} 

?>
</tbody></table>
	<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50" selected="selected">50</option>
				<option value="100">100</option>
				<option value="<?php $num_rows = mysql_num_rows($result); echo $num_rows; ?>" >Все</option>
			</select>
			<span>Записей на страницу</span>
		</div>
		<div id="navigation">
			<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">Страница <span id="currentpage"></span> из <span id="pagelimit"></span></div>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
  var sorter = new TINY.table.sorter("sorter");
	sorter.head = "head";
	sorter.asc = "asc";
	sorter.desc = "desc";
	sorter.even = "evenrow";
	sorter.odd = "oddrow";
	sorter.evensel = "evenselected";
	sorter.oddsel = "oddselected";
	sorter.paginate = true;
	sorter.currentid = "currentpage";
	sorter.limitid = "pagelimit";
	sorter.init("table",<?php if ($_SESSION['user_brouser'] != 'chrome') {echo '2';} else {echo '-1';}?>);
  </script>	
</td></tr> 
  </table>
</div>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>