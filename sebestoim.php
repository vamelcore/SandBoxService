<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1) && ($_SESSION['sebespriv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'prase.php';

if (isset($_GET['id'])) {$id = $_GET['id']; unset ($_GET['id']); if ($id == '') {unset($id);}}

$res_tov = mysql_query("SELECT * FROM `prase` WHERE ID = '$id'",$db);
$myr_tov = mysql_fetch_array($res_tov);

$res_mag = mysql_query("SELECT * FROM magazinu ORDER BY `ID` ASC",$db);

$myarray_mag = array(); $index_mag = 0;
while ($myr_mag = mysql_fetch_assoc($res_mag)) {
foreach($myr_mag as $key => $value) {
$myarray_mag[$key][$index_mag] = $value;
}
$index_mag++;
}	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Себестоимость товаров</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button_use" href="prase.php">Товары</a></td><td><a class="like_button" href="operatoru.php">Операторы</a></td><td><a class="like_button" href="tarifplan.php">Тарифы</a></td><td><a class="like_button" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?><td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><p style="font-size:10pt;">Таблица себестоимости для: <strong><?php echo $myr_tov['tovar'];?></strong></p></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
			<tr>
				
				<th width="20" class="nosort"><h3>Редакт.</h3></th>
				<th width="50"><h3>Магазин</h3></th>
				<th width="50"><h3>Количество, шт</h3></th>
				<th width="50"><h3>Себестоимость, грн</h3></th>
				<th width="50"><h3>Дата добавления</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM `sebestoim` WHERE ID_tovara = '$id' ORDER BY `ID` ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}

if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);

do {

for ($no=0; $no<$index_mag; $no++) {if ($myarray_mag['ID'][$no] == $myrow['ID_magazina']) {$magaz = $myarray_mag['name'][$no];}}

	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_sebes.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$myrow['ID'],$magaz,$myrow['kolichestvo'],$myrow['sebestoimost'],$myrow['data']);
	
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
	sorter.init("table",1);
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