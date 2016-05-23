<form method="post"><table><tr><td><p style="font-size:10pt;">Магазин:</p></td><td><select name="selector_of_stores" onChange="javascript:form.submit()"><?php

$no = 0;	
do {
$no = $no +1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no]; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show'][$no]; 
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag']);
if ($_SESSION['id_mag_selected'] <> 'all') {
$res_plan = mysql_query("SELECT * FROM plan WHERE ID_magazina = '{$_SESSION['id_mag_selected']}'");
$myr_plan = mysql_fetch_array($res_plan);
do {
	${'plan_'.$myr_plan['name']} = $myr_plan['plane'];
} while ($myr_plan = mysql_fetch_array($res_plan));
}

$hours = date('H') + $_SESSION['time_zone']; 
$day = date ('d', mktime ($hours));

?></select></td><td><a href="chat/index.php" class="newWindow" ><img id='new_mes' src='images/mail.png'></a></td><td><?php include ("message.php")?></td></tr></table></form> 

<table cellspacing="5"><tr>
<td><a class="<?php if (($_SESSION['lastpagevizitmag'] == 'page.php') || ($_SESSION['lastpagevizitmag'] == 'archive_prodaj.php') || ($_SESSION['lastpagevizitmag'] == 'archive_sotrudniki.php')) {echo "like_button_use";} else {echo "like_button";}?>" href="page.php">Общая</a></td>
<?php 
if ($_SESSION['vot_priv_pri'] == 1) { if ($_SESSION['lastpagevizitmag'] == 'praice.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="praice.php">Прайсы</a></td>',$gangnam_style);}

if ($_SESSION['vot_priv_ost'] == 1) { if ($_SESSION['lastpagevizitmag'] == 'sklad.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="sklad.php">Остатки</a></td>',$gangnam_style);}

if ($_SESSION['vot_priv_per'] == 1) {if ($_SESSION['lastpagevizitmag'] == 'peremeschenie.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="peremeschenie.php">Перемещения</a></td>',$gangnam_style);}

if ($_SESSION['vot_priv_pro'] == 1) { if ($_SESSION['lastpagevizitmag'] == 'prodaja.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="prodaja.php">Работы</a></td>',$gangnam_style);}

if ($_SESSION['vot_priv_zar'] == 1) { if ($_SESSION['lastpagevizitmag'] == 'zarplata.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';}
printf('<td><a class="%s" href="zarplata.php">Зарплаты</a></td>',$gangnam_style);}
 
if (($_SESSION['tabl_store_show'][0] == 1) && ($_SESSION['vot_priv_rem'] == 1)) {if ($_SESSION['lastpagevizitmag'] == 'remontu.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';} 
printf('<td><a class="%s" href="remontu.php">Ремонты</a></td>',$gangnam_style);} 
if (($_SESSION['tabl_store_show'][1] == 1) && ($_SESSION['vot_priv_voz'] == 1)) {if ($_SESSION['lastpagevizitmag'] == 'vozvratu.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';} 
printf('<td><a class="%s" href="vozvratu.php">Возвраты</a></td>',$gangnam_style);} 
if (($_SESSION['tabl_store_show'][2] == 1) && ($_SESSION['vot_priv_otch'] == 1)) {if ($_SESSION['lastpagevizitmag'] == 'otchet.php') {$gangnam_style = 'like_button_use';} else {$gangnam_style = 'like_button';} 
printf('<td><a class="%s" href="otchet.php">Отчеты</a></td>',$gangnam_style);}
 
if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"%s\">Админ</a></td>",$_SESSION['lastpagevizitadm']);
}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td>
<td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td>
<td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td>
</tr></table>
