<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'archive_popoln.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Архив пополнений</title>
<link rel="stylesheet" href="style_main_page.css" />
<link rel="stylesheet" type="text/css" href="form/style_popolnenie.css"/>
<script src="form/jquery.js"></script>
<script>

$(function() {
	$("a[rel]").overlay(function() {
		$('#overlay').html('<div class="wrap"></div>');
		var wrap = this.getContent().find("div.wrap");
		if (wrap.is(":empty")) {
			wrap.load(this.getTrigger().attr("href"));
		}
	});
});

</script>

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button_use" href="operatoru.php">Операторы</a></td><td><a class="like_button" href="tarifplan.php">Тарифы</a></td><td><a class="like_button" href="plan.php">План</a></td><td><a class="like_button" href="PAYment.php">Дилерам</a></td>
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
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td><p style="font-size:10pt;">Оператор</p></td><td><form action="" method="post"><select name="operator" onchange="javascript:form.submit()"><?php
	$result_oper = mysql_query("SELECT `ID`, `oper` FROM operatoru",$db);
	$myrow_oper = mysql_fetch_array($result_oper);
	if (isset ($_POST['operator'])) {$_SESSION['ID_oper_rah'] = $_POST['operator'];}
	do {
	if (!isset($_SESSION['ID_oper_rah'])) {$_SESSION['ID_oper_rah'] = $myrow_oper['ID']; $_POST['operator'] = $myrow_oper['ID'];}
	if ($_SESSION['ID_oper_rah'] == $myrow_oper['ID']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_oper['ID'],$myrow_oper['oper']);  $_SESSION['ID_oper_rah'] = $myrow_oper['ID'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_oper['ID'],$myrow_oper['oper']);
	}
	}
	while ($myrow_oper = mysql_fetch_array($result_oper));
	
		?></select></form></td><td><p style="font-size:10pt;">Дата</p></td><td><form action="" method="post"><select name="sec_data" onchange="javascript:form.submit()"><?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM otchet ORDER BY `ID` DESC",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset ($_POST['sec_data'])) {$_SESSION['sec_data_rah'] = $_POST['sec_data'];}
	do {
	if (!isset($_SESSION['sec_data_rah'])) {$_SESSION['sec_data_rah'] = $myrow_date['sec_data']; $_POST['sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['sec_data_rah'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['sec_data_rah'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
	
		?></select></form></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<th width="25" class="nosort"><h3>Inf</h3></th>
				<th width="100"><h3>Дата</h3></th>
				<th width="100"><h3>Состояние счета, грн.</h3></th>
				<th width="100"><h3>Кто пополнил</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("(SELECT ID, data, ostatok, magazin FROM `otchet` WHERE ID_operatora = '{$_SESSION['ID_oper_rah']}' AND sec_data = '{$_SESSION['sec_data_rah']}') UNION ALL (SELECT ID, `date`, rahunok, user FROM `rahunok` WHERE ID_operatora = '{$_SESSION['ID_oper_rah']}' AND sec_data = '{$_SESSION['sec_data_rah']}') ORDER BY ID DESC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}

if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {
	$flag = 'false';
	$result_mag = mysql_query("SELECT name FROM magazinu",$db);
    $myrow_mag = mysql_fetch_array($result_mag);
	do {
		if ($myrow['magazin'] == $myrow_mag['name']) {$flag = 'true';} 		
	} while ($myrow_mag = mysql_fetch_array($result_mag));
	if ($flag == 'false') {printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td><td><strong>%s</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td></tr>",$myrow['data'],$myrow['ostatok'],$myrow['magazin']);} 
	else {printf("<tr><td width=15 align='center'><a href=\"form/page_rahunok.php?id=%s\" rel=\"#overlay\"><img src='images/info_icon.png' width='20' height='20' border='0'></a></td><td>%s</td><td>%s</td><td>----</td></tr>",$myrow['ID'],$myrow['data'],$myrow['ostatok']);}	


}
while($myrow = mysql_fetch_array($result));

} 

?>

</tbody></table>

<div class="overlay" id="overlay">
<div class="wrap"></div>
</div>

<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
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
	sorter.init("table",<?php if ($_SESSION['user_brouser'] != 'chrome') {echo '0';} else {echo '-1';}?>);
  </script>
	
</td></tr> 

<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
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