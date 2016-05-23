<?php include ("config.php");
header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}		
	}

$_SESSION['lastpagevizitmag'] = 'archive_sotrudniki.php';

$hours = date('H') + $_SESSION['time_zone']; 
$data = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$day = date ('d', mktime ($hours));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница. Рентабельность</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
            var windowSizeArray = [ "width=400,height=650",
                                    "width=400,height=650,scrollbars=yes" ];
 
            $(document).ready(function(){
                $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
                    var windowSize = "width=400,height=650,scrollbars=yes";
 
                    window.open(url, windowName, windowSize);
 
                    event.preventDefault();
 
                });
            });
        </script>
<style type="text/css">
 .myColor {color:RED} 
</style>
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><?php include ("includers/header_mag.php");?></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table><tr><td><form action="" method="post"><p style="font-size:10pt;">Таблица: "Рентабельность сотрудников".  Дата: <select name="arch_pr_sec_data" onchange="javascript:form.submit()">
	<?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM prodaja WHERE `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC LIMIT 0 , 24",$db);
	if (isset ($_POST['arch_pr_sec_data'])) {$_SESSION['arch_pr_sec_data'] = $_POST['arch_pr_sec_data'];}
	while ($myrow_date = mysql_fetch_array($result_date)) {
	if (!isset($_SESSION['arch_pr_sec_data'])) {$_SESSION['arch_pr_sec_data'] = $myrow_date['sec_data']; $_POST['arch_pr_sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['arch_pr_sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['arch_pr_sec_data'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	
		?></select></p></form></td><td><form action="" method="post"><p style="font-size:10pt;">&nbsp;&nbsp;&nbsp;Логин продавца: <select name="arch_seller_login" onchange="javascript:form.submit()">
      <?php
	$result_user = mysql_query("SELECT `ID`, `login`, `fio_usera` FROM `users`",$db);
	
	if (isset ($_POST['arch_seller_login'])) {$_SESSION['arch_seller_login'] = $_POST['arch_seller_login'];}
	while ($myrow_user = mysql_fetch_array($result_user)) {
	if (!isset($_SESSION['arch_seller_login'])) {$_SESSION['arch_seller_login'] = $myrow_user['login']; $_POST['arch_seller_login'] = $myrow_user['login']; $selected_user_id = $myrow_user['ID'];}
	if ($_SESSION['arch_seller_login'] == $myrow_user['login']){
		printf("<option value=\"%s\" selected=\"selected\">%s (%s)</option>",$myrow_user['login'],$myrow_user['login'],$myrow_user['fio_usera']);  $_SESSION['arch_seller_login'] = $myrow_user['login']; $selected_user_id = $myrow_user['ID'];
	}	else {
		printf("<option value=\"%s\">%s (%s)</option>",$myrow_user['login'],$myrow_user['login'],$myrow_user['fio_usera']);
	}
	}
	if ($_SESSION['arch_seller_login'] == 'rating') {
		printf('<option class="myColor" selected="selected" value="rating">Рейтинг сотрудников</option>');
		}
		else {
			printf('<option class="myColor" value="rating">Рейтинг сотрудников</option>');
			}     	  
	  ?></select></p></form></td></tr></table></td>
</tr>
<?php
printf("<tr><td style=\"border-bottom:1px solid #c6d5e1;\" align=\"center\">");

if ($_SESSION['arch_seller_login'] != 'rating') {

$no_data = false;
$result = mysql_query("SELECT kategoria, stoimost, operator, sebestoimost, skidka FROM prodaja WHERE sec_data = '{$_SESSION['arch_pr_sec_data']}' AND user = '{$_SESSION['arch_seller_login']}'",$db);
if (mysql_num_rows($result) > 0) {
$myarray_result = array(); $index_res = 0;
while ($myrow = mysql_fetch_assoc($result)) {
foreach($myrow as $key => $value) {
$myarray_result[$key][$index_res] = $value;
}
$index_res++;
}
}
else {$no_data = true;}
	
	
	printf("<table cellspacing=\"10\"><tr><td valign=top align=center>");
	
	printf("<table bgcolor=#c6d5e1 border=0 cellpadding=1 cellspacing=1 style='width:380px;' class='sortable'><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Статистика по подключениям, кол</strong></td></tr>");

$res_podkl = mysql_query("SELECT oper FROM operatoru ORDER BY ID",$db);
$summa = 0;
while ($myr_podkl = mysql_fetch_array($res_podkl)) {
	$counter = 0;
	if ($no_data == false) {for ($no=0; $no<$index_res; $no++) {if ($myarray_result['operator'][$no] == $myr_podkl['oper']) {$counter++;}}}	
	printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$myr_podkl['oper'],$counter);
	$summa = $summa + $counter;
	}
printf("<tr><td bgcolor=#c6d5e1><strong>В сумме</string></td><td bgcolor=#c6d5e1><strong>%s</strong></td></tr></table>",$summa);	

printf("</td><td valign=top align=center>");

printf("<table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 style='width:380px;' class='sortable'><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Статистика по продажам, кол</strong></td></tr>");

$res_prodaji = mysql_query("SELECT kateg FROM sklad_kategorii ORDER BY ID",$db);
$summa = 0;

while ($myr_prodaji = mysql_fetch_array($res_prodaji)) {
	$counter = 0;
	if ($no_data == false) {for ($no=0; $no<$index_res; $no++) {if ($myarray_result['kategoria'][$no] == $myr_prodaji['kateg']) {$counter++;}}}	
	printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$myr_prodaji['kateg'],$counter);
	$summa = $summa + $counter;
	}
printf("<tr><td bgcolor=#c6d5e1><strong>В сумме</string></td><td bgcolor=#c6d5e1><strong>%s</strong></td></tr></table>",$summa);

printf("</td><td valign=top align=center>");

printf("<table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 style='width:380px;' class='sortable'><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Статистика по рентабельности, грн</strong></td></tr>");

$counter = 0;
	if ($no_data == false) {for ($no=0; $no<$index_res; $no++) {if ($myarray_result['stoimost'][$no] != "") {$counter = $counter + $myarray_result['stoimost'][$no];}}}
	printf("<tr><td bgcolor=#f6f6f6>Валовый доход</td><td bgcolor=#f6f6f6>%s</td></tr>",$counter);

$counter = 0;
	if ($no_data == false) {for ($no=0; $no<$index_res; $no++) {if ($myarray_result['sebestoimost'][$no] != "") {$counter = $counter + $myarray_result['stoimost'][$no] - $myarray_result['sebestoimost'][$no] - $myarray_result['skidka'][$no];}}}
	printf("<tr><td bgcolor=#f6f6f6>Чистый доход</td><td bgcolor=#f6f6f6>%s</td></tr>",$counter);

$selected_data = $_SESSION['arch_pr_sec_data'];
$res_zarplata = mysql_query("SELECT polniy_den, polov_dnya, voznag_za_tp, prodaja, procent, shtraf, bonus FROM zarplata WHERE ID_usera = '$selected_user_id' AND data LIKE '%$selected_data'",$db);
$counter = 0;
if (mysql_num_rows($res_zarplata) > 0) {
while ($myr_zarplata = mysql_fetch_array($res_zarplata)) {
	if (is_numeric($myr_zarplata['polniy_den'])) {$polniy_den = $myr_zarplata['polniy_den'];} else {$polniy_den = 0;}
	if (is_numeric($myr_zarplata['polov_dnya'])) {$polov_dnya = $myr_zarplata['polov_dnya'];} else {$polov_dnya = 0;}
	if (is_numeric($myr_zarplata['voznag_za_tp'])) {$voznag_za_tp = $myr_zarplata['voznag_za_tp'];} else {$voznag_za_tp = 0;}
	if (is_numeric($myr_zarplata['prodaja'])) {$prodaja = $myr_zarplata['prodaja'];} else {$prodaja = 0;}	
	if (is_numeric($myr_zarplata['procent'])) {$procent = $myr_zarplata['procent'];} else {$procent = 0;}
	if (is_numeric($myr_zarplata['shtraf'])) {$shtraf = $myr_zarplata['shtraf'];} else {$shtraf = 0;}
	if (is_numeric($myr_zarplata['bonus'])) {$bonus = $myr_zarplata['bonus'];} else {$bonus = 0;}
	
	$counter = $counter + $polniy_den + $polov_dnya + $voznag_za_tp + $prodaja + $procent - $shtraf + $bonus;
	}
}
printf("<tr><td bgcolor=#f6f6f6>Зарплата продавца</td><td bgcolor=#f6f6f6>%s</td></tr>",$counter);

printf("</table>");

printf("</td></tr></table>");
}
else {

$no_data = false;
$result = mysql_query("SELECT b, naimenovanie, tarifn_plan, stoimost, sebestoimost, skidka, user FROM prodaja WHERE sec_data = '{$_SESSION['arch_pr_sec_data']}'",$db);
if (mysql_num_rows($result) > 0) {
$myarray_result = array(); $index_res = 0;
while ($myrow = mysql_fetch_assoc($result)) {
foreach($myrow as $key => $value) {
$myarray_result[$key][$index_res] = $value;
}
$index_res++;
}
}
else {$no_data = true;}	



?>

	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" style="width:600px;">
		<thead>
			<tr>
				<th style="width:400px;"><h3>Продавец</h3></th>
				<th style="width:50px;"><h3>Продажи</h3></th>
				<th style="width:50px;"><h3>Подключения</h3></th>
				<th style="width:50px;"><h3>Валовая прибыль</h3></th>
				<th style="width:50px;"><h3>Чистый доход</h3></th>
			</tr>
		</thead>
		<tbody>

<?php
$result_user = mysql_query("SELECT `ID`, `login`, `fio_usera` FROM `users`",$db);
$summa_prod = 0; $summa_podk = 0; $summa_vprib = 0; $summa_chprib = 0;
while ($myrow_user = mysql_fetch_array($result_user)) {
$counter_prod = 0; $counter_podk = 0; $counter_vprib = 0; $counter_chprib = 0; 
	if ($no_data == false) {
		for ($no=0; $no<$index_res; $no++) {
			if ($myarray_result['user'][$no] == $myrow_user['login']) {
				if ($myarray_result['tarifn_plan'][$no] != '') {$counter_podk++;} 
				if ($myarray_result['naimenovanie'][$no] != '') {$counter_prod++;}
				$counter_vprib = $counter_vprib + $myarray_result['stoimost'][$no];
				$counter_chprib = $counter_chprib + $myarray_result['stoimost'][$no] - $myarray_result['sebestoimost'][$no] -$myarray_result['skidka'][$no];
				
				
			}
		}
	}

printf("<tr><td>%s (%s)</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$myrow_user['login'],$myrow_user['fio_usera'],$counter_prod,$counter_podk,$counter_vprib,$counter_chprib);
$summa_prod = $summa_prod + $counter_prod;
$summa_podk = $summa_podk + $counter_podk;
$summa_vprib = $summa_vprib + $counter_vprib;
$summa_chprib = $summa_chprib + $counter_chprib;	
}
printf("<tr><td><strong>ВСЕГО:</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td></tr>",$summa_prod,$summa_podk,$summa_vprib,$summa_chprib);
?>



</tbody></table>
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
	sorter.init("table",0);
  </script>
<?php	
}

printf("</td></tr>");

?>

<tr><td align="center">SandBOX CDMA &reg; &copy;</td></tr> 
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