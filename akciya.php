<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'akciya.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Акциoнное оборудование</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 250px;}
  </style>

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button_use" href="prase.php">Товары</a></td><td><a class="like_button" href="operatoru.php">Операторы</a></td><td><a class="like_button" href="tarifplan.php">Тарифы</a></td><td><a class="like_button" href="plan.php">План</a></td><td><a class="like_button" href="PAYment.php">Дилерам</a></td>
<?php 
if (isset($_SESSION['sebespriv']) &&($_SESSION['sebespriv'] == 1)) {
printf('<td><a class="like_button" href="rashodu.php">Расходы</a></td>');}
if (isset($_SESSION['kontpriv']) &&($_SESSION['kontpriv'] == 1)) {
printf('<td><a class="like_button" href="kontrol.php">Контроль</a></td>');}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td>
	<form action="update/insert_akciya.php" method="post"><table><tr>
	<td align="center"><select name="kategory" id="kateg"><option value="">Выберите категорию</option>
  			<?php 
$res_kat = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii` ORDER BY `kateg` ASC",$db);	
$myr_kat = mysql_fetch_array($res_kat);
if (isset($_SESSION['selected_kat_akc'])) {
do {

if ($myr_kat['ID'] == $_SESSION['selected_kat_akc']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
}
else {
do {
printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
}		
while ($myr_kat = mysql_fetch_array($res_kat));	
}
  			?>
  		</select></td>
	<td align="center"><select name="operator" id="operator"><option value="">Выберите оператора</option>
		<?php 
$res_op = mysql_query("SELECT `ID`,`oper` FROM `operatoru` ORDER BY `oper` ASC",$db); 		
$myr_op = mysql_fetch_array($res_op);  		
if (isset($_SESSION['selected_op_akc'])) {
do {

if ($myr_op['ID'] == $_SESSION['selected_op_akc']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_op['ID'],$myr_op['oper']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_op['ID'],$myr_op['oper']);}	
}		
while ($myr_op = mysql_fetch_array($res_op));
}
else {
do {
printf ("<option value=\"%s\">%s</option>",$myr_op['ID'],$myr_op['oper']);	
}		
while ($myr_op = mysql_fetch_array($res_op));	
}	
  		?></select></td>
	<td align="right">Цена</td>
	<td align="center"><input type="text" name="cena"></td>
	</tr><tr>
	<td align="center"><select name="tovar" id="tovar">
<?php 
if (isset($_SESSION['selected_tov_akc'])) {
$res_tov = mysql_query("SELECT `ID`,`tovar` FROM `prase` WHERE `ID_kategorii` = '{$_SESSION['selected_kat_akc']}' ORDER BY `tovar` ASC",$db);	
$myr_tov = mysql_fetch_array($res_tov);
do {

if ($myr_tov['ID'] == $_SESSION['selected_tov_akc']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);}	
}		
while ($myr_tov = mysql_fetch_array($res_tov));
}

  			?>		
	</select></td>
	<td align="center"><select name="tarifplan" id="tarpl">
		<?php 
if (isset($_SESSION['selected_tp_akc'])) {
$res_tp = mysql_query("SELECT `ID`, `tarifplan` FROM `tarifplan` WHERE `ID_oper` = '{$_SESSION['selected_op_akc']}' ORDER BY `tarifplan` ASC",$db);	
$myr_tp = mysql_fetch_array($res_tp);
do {

if ($myr_tp['ID'] == $_SESSION['selected_tp_akc']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tp['ID'],$myr_tp['tarifplan']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tp['ID'],$myr_tp['tarifplan']);}	
}		
while ($myr_tp = mysql_fetch_array($res_tp));
}

  			?>	
	</select></td>
	<td align="right">Вознаг.</td>
	<td align="center"><input type="text" name="voznag"></td>
	<td rowspan="2" align="center" valign="center"><input type="submit" value="Добавить"></td>
	</tr></table></form>
	</td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="500">
		<thead>
			<tr>
				<th width="20" class="nosort"><h3>Редакт.</h3></th>
				<th width="20" class="nosort"><h3>Удалить</h3></th>
				<th width="180" ><h3>Категория</h3></th>
				<th width="180" ><h3>Наименование товара</h3></th>
				<th width="180" ><h3>Оператор</h3></th>
				<th width="180" ><h3>Тарыфный план</h3></th>
				<th width="40" ><h3>Цена</h3></th>
				<th width="80" ><h3>Вознаг.</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM akciya ORDER BY ID ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {
$res_kat_a = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii WHERE ID = '{$myrow['ID_kateg']}'",$db);	
$myr_kat_a = mysql_fetch_array($res_kat_a);
$res_tov_a = mysql_query("SELECT `ID`,`tovar` FROM prase WHERE ID = '{$myrow['ID_tov']}'",$db);	
$myr_tov_a = mysql_fetch_array($res_tov_a);
$res_op_a = mysql_query("SELECT `ID`,`oper` FROM operatoru  WHERE ID = '{$myrow['ID_oper']}'",$db); 		
$myr_op_a = mysql_fetch_array($res_op_a);
$res_tp_a = mysql_query("SELECT `ID`, `tarifplan` FROM tarifplan WHERE ID = '{$myrow['ID_tp']}'",$db);	
$myr_tp_a = mysql_fetch_array($res_tp_a);	
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_akciya.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_akciya.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td><strong>%s</strong></td></tr>",$myrow['ID'],$myrow['ID'],$myr_kat_a['kateg'],$myr_tov_a['tovar'],$myr_op_a['oper'],$myr_tp_a['tarifplan'],$myrow['cena'],$myrow['voznag']);
	
}
while($myrow = mysql_fetch_array($result));

} 

?>

</tbody></table>


<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)" style="width:45px;">
			<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50" selected="selected">50</option>
				<option value="100">100</option>
				<option value="<?php $num_rows = mysql_num_rows($result); echo $num_rows; ?>">Все</option>
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
	sorter.init("table",3);
  </script>
	
</td></tr> 


<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
</td></tr>

  </table>
</div>


<script type="text/javascript">
         $("#kateg").change(function(){		 		
         $("#tovar").load("./update/get_tov_from_prise.php", { kateg: $("#kateg option:selected").val() });
         });
         </script>
<script type="text/javascript">
         $("#operator").change(function(){		 		
         $("#tarpl").load("./update/get_prodaja_tp.php", { operator: $("#operator option:selected").val() });
         });

		 </script>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>