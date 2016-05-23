<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'operatoru.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Тип работы</title>
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
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button_use" href="operatoru.php">Тип работы</a></td><td><a class="like_button" href="tarifplan.php">Работы</a></td><td><a class="like_button" href="plan.php">План</a></td>
            <!--<td><a class="like_button" href="PAYment.php">Дилерам</a></td>-->
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
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr>
<!--            <td width="150" align="center"><a class="like_button" href="archive_popoln.php">Архив пополнений</a></td>-->
            <td><form action="update/insert_operatoru.php" method="post"><table><tr>
<!--                            <td align="center">Тип работы</td>-->
<!--                            <td align="center">Тип счета</td>-->
<!--                            <td align="center">Баланс</td>-->
                            </tr>
                        <tr><td><input type="text" name="oper"></td>
<!--                            <td><select name="priznak"><option value="Нет" selected="selected">Нет</option><option value="Тарыфный план">Тарыфный план</option><option value="Оборудование">Оборудование</option><option value="Тарыфный план + Оборудование">Тарыфный план+Оборудование</option></select></td><td><input type="text" name="schet"></td>-->
                            <td><input type="submit" value="Добавить"></td></tr></table></form></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
<!--				<th width="25" class="nosort"><h3>Пополн.</h3></th>-->
				<th width="25" class="nosort"><h3>Редакт.</h3></th>
				<th width="25" class="nosort"><h3>Удалить</h3></th>
				<th width="300"><h3>Тип работы</h3></th>
<!--				<th width="100"><h3>Тип счета</h3></th>-->
<!--				<th width="100"><h3>Баланс, грн.</h3></th>-->
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM `operatoru` ORDER BY `oper` ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_operatoru.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_operatoru.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td></tr>",$myrow['ID'],$myrow['ID'],$myrow['oper']);
	
}
while($myrow = mysql_fetch_array($result));

} 

?>

</tbody></table>

<div class="overlay" id="overlay">
<div class="wrap"></div></div>

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
	sorter.init("table",3);
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