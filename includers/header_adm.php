<table cellspacing="5"><tr>
<td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td>
<td>||</td>
<?php 
if ($_SESSION['lastpagevizitadm'] == 'kassa.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="kassa.php">Касса</a></td>',$gangnam_style);
if ($_SESSION['lastpagevizitadm'] == 'kategorii.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="kategorii.php">Категории</a></td>',$gangnam_style);
if ($_SESSION['lastpagevizitadm'] == 'prase.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="prase.php">Товары</a></td>',$gangnam_style);
if ($_SESSION['lastpagevizitadm'] == 'operatoru.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="operatoru.php">Операторы</a></td>',$gangnam_style);
if ($_SESSION['lastpagevizitadm'] == 'tarifplan.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="tarifplan.php">Тарифы</a></td>',$gangnam_style);
if ($_SESSION['lastpagevizitadm'] == 'plan.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="plan.php">План</a></td>',$gangnam_style);
if (($_SESSION['lastpagevizitadm'] == 'dileru.php') || ($_SESSION['lastpagevizitadm'] == 'archive_files.php')) {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="dileru.php">Дилеры</a></td>',$gangnam_style);
 
if (isset($_SESSION['sebespriv']) && ($_SESSION['sebespriv'] == 1)) {
	if ($_SESSION['lastpagevizitadm'] == 'rashodu.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="rashodu.php">Расходы</a></td>',$gangnam_style);}
if (isset($_SESSION['kontpriv']) &&($_SESSION['kontpriv'] == 1)) {
	if ($_SESSION['lastpagevizitadm'] == 'kontrol.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="kontrol.php">Контроль</a></td>',$gangnam_style);}

if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td>
<td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td>
<td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td>
</tr></table>