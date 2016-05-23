<?php include ("config.php");
header('Content-Type: text/html; charset=utf-8');

session_start();

if ( stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox') ) $_SESSION['user_brouser'] = 'firefox';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome') ) $_SESSION['user_brouser'] = 'chrome';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'Safari') ) $_SESSION['user_brouser'] = 'safari';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'Opera') ) $_SESSION['user_brouser'] = 'opera';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') ) $_SESSION['user_brouser'] = 'ie6';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0') ) $_SESSION['user_brouser'] = 'ie7';
elseif ( stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') ) $_SESSION['user_brouser'] = 'ie8';

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}		
	}

$_SESSION['lastpagevizitmag'] = 'page.php';
$_SESSION['lastpagevizitadm'] = 'kassa.php';

$hours = date('H') + $_SESSION['time_zone']; 
$data = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$day = date ('d', mktime ($hours));

if ($day == '19') {$res_sysconfig = mysql_query("UPDATE `sysconfig` SET `enabled` = 'yes' WHERE `param` = 'pay_message'",$db);}

$res_zar = mysql_query("SELECT * FROM zarplata WHERE ID_usera = '{$_SESSION['user_id']}' AND data = '$data'",$db);
$myr_zar = mysql_fetch_array($res_zar);

if (mysql_num_rows($res_zar) == 0) {	
	$zar_flag=false;		
}
else {
	$zar_flag=false;
	do {
		if ($myr_zar['polniy_den'] <> '----') {$zar_flag=true;}
	} while ($myr_zar = mysql_fetch_array($res_zar));
}




if ($_SESSION['admin_priv'] == '1') {$prov_perv_polz = '0';}
else {$prov_perv_polz = $_SESSION['perv_prod']['1'];}

if (($zar_flag == false) && ($prov_perv_polz == 1)) {
	
$res_zar_detect = mysql_query("SELECT DISTINCT ID_usera FROM zarplata WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND data = '$data'",$db);

if (mysql_num_rows($res_zar_detect) <> 0) {		
	while ($myr_zar_detect = mysql_fetch_array($res_zar_detect)) {
$res_user_detect = mysql_query("SELECT adminpriv FROM users WHERE ID = '{$myr_zar_detect['ID_usera']}'",$db);
$myr_user_detect = mysql_fetch_array($res_user_detect);
if ($myr_user_detect['adminpriv'] == '0') {$zar_flag=true;}
	}
 }	
}




if ($zar_flag == false) {
	$res_max_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '{$_SESSION['user_id']}' ORDER BY `ID` DESC LIMIT 1");
	$myr_max_zap = mysql_fetch_array($res_max_zap);	
	
	$myr_max_zap['k_oplate'] = $myr_max_zap['k_oplate'] + $_SESSION['stavka'];
$res_zar = mysql_query("INSERT INTO zarplata SET ID_prodaja = '0', ID_magazina = '{$_SESSION['id_mag_selected']}', ID_usera = '{$_SESSION['user_id']}', data = '----', vremya = '----', polniy_den = '----', polov_dnya = '----', voznag_za_tp = '----', prodaja = '----', procent = '----', k_oplate = '----',vudano = '----', shtraf = '----', bonus = '----', user = '----'",$db);	

$res_zar = mysql_query("INSERT INTO zarplata SET ID_prodaja = '0', ID_magazina = '{$_SESSION['id_mag_selected']}', ID_usera = '{$_SESSION['user_id']}', data = '$data', vremya = '$vremya', polniy_den = '{$_SESSION['stavka']}', polov_dnya = '----', voznag_za_tp = '----', prodaja = '----', procent = '----', k_oplate = '{$myr_max_zap['k_oplate']}',vudano = '----', shtraf = '----', bonus = '----', user = '----'",$db);	
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
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

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><?php include ("includers/header_mag.php"); if ($_SESSION['vot_priv_obch'] == 0) {printf('<br><div align=center><table style="border:1px solid #ccc; background:#ffffff; padding:15px;"><tr><td style="text-align:center;"><img src="images/img_alert.jpg"><p style="font-size:16pt; text-align:center; vertical-align: middle;">Доступ к этой странице ограничен!</p></td></tr></table></div><br></td></tr>'); die();}?></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><p style="font-size:10pt;">Таблица: "Общая" из базы данных на <?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y', mktime ($hours)); ?>.    <?php if ($_SESSION['id_mag_selected'] <> 'all') {  printf("<strong>%s</strong> грн к ставке за выполнение плана",$plan_bonus);} else {printf("<a class=\"like_button\" href='archive_prodaj.php'>Архив работ</a>   <a class=\"like_button\" href='archive_sotrudniki.php'>Эффективность сотрудников</a>");} ?></p></td>
</tr>
<?php
$date_val = date ('m.Y', mktime ($hours));

if ($_SESSION['id_mag_selected'] == 'all') {
	printf("<tr><td style=\"border-bottom:1px solid #c6d5e1;\" align=\"center\"><table  cellspacing=\"10\"><tr>");

printf("<td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong><a href=\"kassa.php\">В кассе</a>, грн</strong></td></tr>");
$no = 0;	
do {
$no = $no +1;
	$res_vkasse = mysql_query("SELECT `vkasse` FROM kassa WHERE magazine = '{$_SESSION['name_mag'][$no]}' ORDER BY `ID` DESC LIMIT 1",$db);
	$myr_vkasse = mysql_fetch_array($res_vkasse);	
	printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$_SESSION['name_mag'][$no],$myr_vkasse['vkasse']);				
}
while($no < $_SESSION['count_mag'] - 1);
printf("</table></td><td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong><a href=\"operatoru.php\">Баланс</a>, грн</strong></td></tr>");

	$res_rah = mysql_query("SELECT schet, oper FROM operatoru WHERE priznak != 'Нет'",$db);
	$myr_rah = mysql_fetch_array($res_rah);
	do {
	   printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$myr_rah['oper'], $myr_rah['schet']);	
	} while ($myr_rah = mysql_fetch_array($res_rah));
	
	
printf("</table></td><td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong><a href=\"zarplata.php\">Зарплата</a>, грн</strong></td></tr>");	
	$res_u = mysql_query("SELECT `ID`, `login` FROM users",$db);
	$myr_u = mysql_fetch_array($res_u);
do {
$res_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '{$myr_u['ID']}' ORDER BY `ID` DESC LIMIT 1");	
$myr_zap = mysql_fetch_array($res_zap);
printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$myr_u['login'],$myr_zap['k_oplate']);
}
while ($myr_u = mysql_fetch_array($res_u));
printf("</table></td><td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Прибыль за %s, грн</strong></td></tr>",$date_val);
$no = 0; $summ_prib = array();
do {
$no = $no +1;
	$res_stoimost = mysql_query("SELECT `stoimost` FROM prodaja WHERE magazin = '{$_SESSION['name_mag'][$no]}' AND sec_data = '$date_val' AND `akciya` <> 'true'",$db);
	$myr_stoimost = mysql_fetch_array($res_stoimost);
	$summa_soim = 0;
	do {$summa_soim=$summa_soim+$myr_stoimost['stoimost'];} while ($myr_stoimost = mysql_fetch_array($res_stoimost));	
  printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$_SESSION['name_mag'][$no],$summa_soim);
    $summ_pribul[$no] = $summa_soim;		
}
while($no < $_SESSION['count_mag'] - 1);
printf("</table></td>");



if ($_SESSION['sebespriv'] == 1) {

printf("<td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Чистый доход </br> за %s, грн</strong></td></tr>",$date_val);

$res_pashodu = mysql_query("SELECT `p_m`, `summ` FROM `rashodu` WHERE `ID_magazina` = '0' AND `sec_data` = '$date_val'",$db);
$rashodu_plus_all = 0; $rashodu_minus_all = 0;
if (mysql_num_rows($res_pashodu) > 0) {
while ($myr_pashodu = mysql_fetch_array($res_pashodu)) {

if ($myr_pashodu['p_m'] == 'plus') {$rashodu_plus_all = $rashodu_plus_all + $myr_pashodu['summ'];}
if ($myr_pashodu['p_m'] == 'minus') {$rashodu_minus_all = $rashodu_minus_all + $myr_pashodu['summ'];}

}
}

if (($_SESSION['real_count_mag']) > 0) {$num_magazinoff = $_SESSION['real_count_mag'];} else {$num_magazinoff = 1;}

$no = 0;
do {
$no = $no +1;

$res_sebestoimost = mysql_query("SELECT `sebestoimost`, `skidka` FROM `prodaja` WHERE `magazin` = '{$_SESSION['name_mag'][$no]}' AND `sec_data` = '$date_val' AND `akciya` <> 'true'",$db);
$summa_sebesoim = 0;
$summa_skidka = 0;
if (mysql_num_rows($res_sebestoimost) > 0) {

while ($myr_sebestoimost = mysql_fetch_array($res_sebestoimost)) {

$summa_sebesoim = $summa_sebesoim + $myr_sebestoimost['sebestoimost'];
$summa_skidka = $summa_skidka + $myr_sebestoimost['skidka'];
} 
}	


$res_pashodu = mysql_query("SELECT `p_m`, `summ` FROM `rashodu` WHERE `ID_magazina` = '{$_SESSION['id_mag'][$no]}' AND `sec_data` = '$date_val'",$db);
$rashodu_plus = 0; $rashodu_minus = 0; 
if (mysql_num_rows($res_pashodu) > 0) {
while ($myr_pashodu = mysql_fetch_array($res_pashodu)) {

if ($myr_pashodu['p_m'] == 'plus') {$rashodu_plus = $rashodu_plus + $myr_pashodu['summ'];}
if ($myr_pashodu['p_m'] == 'minus') {$rashodu_minus = $rashodu_minus + $myr_pashodu['summ'];}

}
}   	
	

$res_zarplata_rashod = mysql_query("SELECT * FROM `zarplata` WHERE `ID_magazina` = '{$_SESSION['id_mag'][$no]}' AND `data` LIKE '%$date_val'",$db);
$rashod_zp_poln_den = 0; $rashod_zp_pol_dnya = 0; $rashod_zp_prod_tp = 0; $rashod_zp_prod_j = 0; $rashod_zp_proc = 0; $rashod_zp_shtraff = 0; $rashod_zp_bonus = 0;
if (mysql_num_rows($res_zarplata_rashod) > 0) {
while ($myr_zarplata_rashod = mysql_fetch_array($res_zarplata_rashod)) {
$rashod_zp_poln_den = $rashod_zp_poln_den + $myr_zarplata_rashod['polniy_den'];
$rashod_zp_pol_dnya = $rashod_zp_pol_dnya + $myr_zarplata_rashod['polov_dnya'];
$rashod_zp_prod_tp = $rashod_zp_prod_tp + $myr_zarplata_rashod['voznag_za_tp'];
$rashod_zp_prod_j = $rashod_zp_prod_j + $myr_zarplata_rashod['prodaja'];
$rashod_zp_proc = $rashod_zp_proc + $myr_zarplata_rashod['procent'];
$rashod_zp_shtraff = $rashod_zp_shtraff + $myr_zarplata_rashod['shtraf'];
$rashod_zp_bonus = $rashod_zp_bonus + $myr_zarplata_rashod['bonus'];
}
}

	
$chistuy_dohod = $summ_pribul[$no] - round($summa_sebesoim, 2) + round(($rashodu_plus_all/$num_magazinoff), 2) - round(($rashodu_minus_all/$num_magazinoff), 2) + $rashodu_plus - $rashodu_minus - $rashod_zp_poln_den - $rashod_zp_pol_dnya - $rashod_zp_prod_tp - $rashod_zp_prod_j - $rashod_zp_proc + $rashod_zp_shtraff - $rashod_zp_bonus - $summa_skidka;
	
printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$_SESSION['name_mag'][$no],$chistuy_dohod);
}
while($no < $_SESSION['count_mag'] - 1);

printf("</table></td><td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=180><tr><td colspan='2' bgcolor=#c1cedb align='center'><strong>Суммарная стоемость материалов, грн</strong></td></tr>");
$no = 0;
do {
$no = $no+1;
$res_summ_stoem = mysql_query("SELECT kolichestvo, sebestoimost FROM sebestoim WHERE ID_magazina = '{$_SESSION['id_mag'][$no]}'",$db);
if (mysql_num_rows($res_summ_stoem) > 0) {
$summa_sebestiom = 0;
while ($myr_summ_stoem = mysql_fetch_array($res_summ_stoem)) {
$summa_sebestiom = $summa_sebestiom + $myr_summ_stoem['kolichestvo']*$myr_summ_stoem['sebestoimost'];
}
printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$_SESSION['name_mag'][$no],$summa_sebestiom);
}
else {printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>0</td></tr>",$_SESSION['name_mag'][$no]);}
}
while ($no < $_SESSION['count_mag'] - 1);
printf("</table></td></tr>");
}
else {printf("</tr>");}

$res_podkl = mysql_query("SELECT `ID`, `oper` FROM operatoru",$db);
$res_kateg = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);

$_SESSION['plot_month'] = date ('m.Y', mktime ($hours));
printf("<tr><td colspan='6' align='center'><table><tr><td><img src='/jpgraph/plot_bar_pribil.php'></td></tr></table></td></tr>");

printf("<tr><td colspan='6' align='left'><select id='tupe_graph' name='tupe_graph'><option value='bar'>Бар</option><option value='graph'>График</option></select> <select id='plot_opetator' name='plot_opetator'><option value='all'>Все</option>");
while ($myr_podkl = mysql_fetch_array($res_podkl)) {
printf("<option value=%s>%s</option>",$myr_podkl['ID'],$myr_podkl['oper']);}
printf("</select></td></tr>");


printf("<tr><td colspan='6' align='center'><table><tr><td><img id='plot_graph' src='/jpgraph/plot_bar_operatoru.php'></td><td colspan='2' align='center'><img src='/jpgraph/plot_pie_operatoru.php'></td></tr></table></td></tr>");


printf("<tr><td colspan='6' align='left'><select id='tupe1_graph' name='tupe1_graph'><option value='bar'>Бар</option><option value='graph'>График</option></select> <select id='plot_kategory' name='plot_kategory'><option value='all'>Все</option>");
while ($myr_kateg = mysql_fetch_array($res_kateg)) {
printf("<option value=%s>%s</option>",$myr_kateg['ID'],$myr_kateg['kateg']);}
printf("</select></td></tr>");

printf("<tr><td colspan='6' align='center'><table><tr><td><img id='plot_kateg' src='/jpgraph/plot_bar_kategorii.php'></td><td colspan='2' align='center'><img src='/jpgraph/plot_pie_kategorii.php'></td></tr></table></td></tr>");

printf("</tr></table></td></tr>");
}
?>
<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php
				if ($_SESSION['id_mag_selected'] == 'all')
				{
					printf("<th class=\"nosort\"><h3>Наименование</h3></th>");
					$i = 1;
					do {
						printf("<th class=\"nosort\"><h3>%s</h3></th>", $_SESSION['name_mag'][$i]);
						$i++;
						if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
					} while (isset($_SESSION['name_mag'][$i]));
					printf("<th class=\"nosort\"><h3>Суммарное количество</h3></th>");
				} else {
					printf("<th width=\"300\" class=\"nosort\"><h3>Наименование</h3></th>
							<th width=\"100\" class=\"nosort\"><h3>Результат за месяц:</h3></th>
							<th width=\"100\"class=\"nosort\"><h3>План:</h3></th>
							");
				}
				?>				
			</tr>
		</thead>
		<tbody>
<?php
if ($_SESSION['id_mag_selected'] <> 'all') {
$res_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myr_mag = mysql_fetch_array($res_mag);
}

$res_podkl = mysql_query("SELECT `ID`, `oper` FROM operatoru",$db);
$myr_podkl = mysql_fetch_array($res_podkl); 

$res_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);
$myr_kat = mysql_fetch_array($res_kat);

?>

<tr bgcolor="#dce6ee">
  	<td><p>В СУММЕ ЗА ЭТОТ МЕСЯЦ</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') {
  		$res_summ_prodaj = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE b != 'Р' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY magazin",$db);
  	$summa_prodaj = mysql_fetch_array($res_summ_prodaj);
	if ($summa_prodaj['COUNT(ID)'] == '') {$summa_prodaj['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_prodaj['COUNT(ID)']);}
	else {	
		$i = 1; $summa = 0;
		do {						
		$res_summ_prodaj = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE b != 'Р' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY magazin",$db);	
		$summa_prodaj = mysql_fetch_array($res_summ_prodaj);				
		if ($summa_prodaj['COUNT(ID)'] == '') {$summa_prodaj['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj['COUNT(ID)']);				
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);		
	}  		
  	?>  	
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Аксесуары:</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  		$res_summ_prodaj_t = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'А' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY b",$db);
  	$summa_prodaj_t = mysql_fetch_array($res_summ_prodaj_t);
	if ($summa_prodaj_t['COUNT(ID)'] == '') {$summa_prodaj_t['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\">%s</p></td>",$summa_prodaj_t['COUNT(ID)'],$plan_term);}
	else {
		$i = 1; $summa = 0;
		do {
		$res_summ_prodaj_t = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'А' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY b",$db);	
		$summa_prodaj_t = mysql_fetch_array($res_summ_prodaj_t);
	    if ($summa_prodaj_t['COUNT(ID)'] == '') {$summa_prodaj_t['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj_t['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj_t['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);	
	}  		
  	?>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Материалы:</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  		$res_summ_prodaj_a = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'М' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY b",$db);
  	$summa_prodaj_a = mysql_fetch_array($res_summ_prodaj_a);
	if ($summa_prodaj_a['COUNT(ID)'] == '') {$summa_prodaj_a['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\">%s</p></td>",$summa_prodaj_a['COUNT(ID)'],$plan_acses);}
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_prodaj_a = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'М' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY b",$db);	
		$summa_prodaj_a = mysql_fetch_array($res_summ_prodaj_a);
	    if ($summa_prodaj_a['COUNT(ID)'] == '') {$summa_prodaj_a['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj_a['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj_a['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);		
	}  		
  	?>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Материалы+Работа:</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  		$res_summ_prodaj_s = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'МР' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY b",$db);
  	$summa_prodaj_s = mysql_fetch_array($res_summ_prodaj_s);
	if ($summa_prodaj_s['COUNT(ID)'] == '') {$summa_prodaj_s['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\">%s</p></td>",$summa_prodaj_s['COUNT(ID)'],$plan_starpak);}
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_prodaj_s = mysql_query("SELECT b, COUNT(ID) FROM prodaja WHERE b = 'МР' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY b",$db);	
		$summa_prodaj_s = mysql_fetch_array($res_summ_prodaj_s);
	    if ($summa_prodaj_s['COUNT(ID)'] == '') {$summa_prodaj_s['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj_s['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj_s['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);			
	}  		
  	?>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>РАБОТЫ, ВСЕГО</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  	$res_summ_podk = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE operator != '' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY magazin",$db);
  	$summa_podk = mysql_fetch_array($res_summ_podk);
	if ($summa_podk['COUNT(ID)'] == '') {$summa_podk['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\">%s</p></td>",$summa_podk['COUNT(ID)'],$plan_podkl);}
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_podk = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE operator != '' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY magazin",$db);	
		$summa_podk = mysql_fetch_array($res_summ_podk);
	    if ($summa_podk['COUNT(ID)'] == '') {$summa_podk['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_podk['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_podk['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);		
	}
  	?>
    </tr>
    <?php
  	if ($_SESSION['id_mag_selected'] <> 'all') {    
    do {
 $res_podkl_count = mysql_query("SELECT operator, COUNT(ID) FROM prodaja WHERE magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' AND operator = '{$myr_podkl['oper']}' GROUP BY operator",$db);
    $myr_podkl_count = mysql_fetch_array($res_podkl_count);
	if ($myr_podkl_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_podkl_count['COUNT(ID)'];}   			
    printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td><td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td></tr>",$myr_podkl['oper'],$summ); 
	} while ($myr_podkl = mysql_fetch_array($res_podkl));}
	else {
	
	do {
		printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td>",$myr_podkl['oper']);
	    $i = 1; $summa = 0;
		do {
		$res_podkl_count = mysql_query("SELECT operator, COUNT(ID) FROM prodaja WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' AND operator = '{$myr_podkl['oper']}' GROUP BY operator",$db);	
		$myr_podkl_count = mysql_fetch_array($res_podkl_count);
	    if ($myr_podkl_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_podkl_count['COUNT(ID)'];}
		$summa = $summa + $myr_podkl_count['COUNT(ID)'];		
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summ);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td></tr>",$summa);	
	} while ($myr_podkl = mysql_fetch_array($res_podkl));
		
	} 
    ?>
  <tr bgcolor="#dce6ee">
	<td><p>МАТЕРИАЛЫ, ВСЕГО</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  		$res_summ_prodaj_K = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE kategoria != '' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY magazin",$db);
  	$summa_prodaj_K = mysql_fetch_array($res_summ_prodaj_K);
	if ($summa_prodaj_K['COUNT(ID)'] == '') {$summa_prodaj_K['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_prodaj_K['COUNT(ID)']); }
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_prodaj_K = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE kategoria != '' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY magazin",$db);	
		$summa_prodaj_K = mysql_fetch_array($res_summ_prodaj_K);
	    if ($summa_prodaj_K['COUNT(ID)'] == '') {$summa_prodaj_K['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj_K['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj_K['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);		
	} 		  	
  	?>  	
    </tr>
    <?php
    if ($_SESSION['id_mag_selected'] <> 'all') {
    do {
   $res_kateg_count = mysql_query("SELECT kategoria, COUNT(ID) FROM prodaja WHERE magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' AND kategoria = '{$myr_kat['kateg']}' GROUP BY kategoria",$db);
	$myr_kateg_count = mysql_fetch_array($res_kateg_count);
 	if ($myr_kateg_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_kateg_count['COUNT(ID)'];}   
 printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td><td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td></tr>",$myr_kat['kateg'],$summ);
	} while ($myr_kat = mysql_fetch_array($res_kat));}
	else {
		
	do {
		printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td>",$myr_kat['kateg']);
	    $i = 1; $summa = 0;
		do {
		$res_kateg_count = mysql_query("SELECT kategoria, COUNT(ID) FROM prodaja WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' AND kategoria = '{$myr_kat['kateg']}' GROUP BY kategoria",$db);	
		$myr_kateg_count = mysql_fetch_array($res_kateg_count);
	    if ($myr_kateg_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_kateg_count['COUNT(ID)'];}
		$summa = $summa + $myr_kateg_count['COUNT(ID)'];		
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summ);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td></tr>",$summa);	
	} while ($myr_kat = mysql_fetch_array($res_kat));		
				
	}
    ?>
<!--<tr bgcolor="#dce6ee">
	<td><p>РЕМОНТЫ:</p></td>
  	<?php  	
//    if ($_SESSION['id_mag_selected'] <> 'all') {
//    	
//     if ($_SESSION['tabl_store_show'][0] == '1') {    	
//    	  	  	 
//  		$res_summ_remont = mysql_query("SELECT magazin, COUNT(ID) FROM remontu WHERE magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY magazin",$db);
//  	$summa_remont = mysql_fetch_array($res_summ_remont);
//	if ($summa_remont['COUNT(ID)'] == '') {$summa_remont['COUNT(ID)'] = 0;}
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_remont['COUNT(ID)']);}
//	
//	   else {printf("<td><p align=\"center\"><strong>-</strong></p></td><td><p align=\"center\"></p></td>");}
//	
//	}  
//	else {		
//		$i = 1; $summa = 0;
//		do {
//		$res_summ_remont = mysql_query("SELECT magazin, COUNT(ID) FROM remontu WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY magazin",$db);	
//		$summa_remont = mysql_fetch_array($res_summ_remont);
//	    if ($summa_remont['COUNT(ID)'] == '') {$summa_remont['COUNT(ID)'] = 0;}
//		$summa = $summa + $summa_remont['COUNT(ID)'];
//		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_remont['COUNT(ID)']);
//		$i++;
//		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
//		} while (isset($_SESSION['name_mag'][$i]));
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);				
//	}
//	
//	
//	
  	?>  	
    </tr>-->
<!--<tr bgcolor="#dce6ee">
	<td><p>ВОЗВРАТЫ, ВСЕГО</p></td>
  	<?php
//    if ($_SESSION['id_mag_selected'] <> 'all') {
//    	
//       if ($_SESSION['tabl_store_show'][1] == '1') {   	
//    	  	 
//  		$res_summ_vozv = mysql_query("SELECT magazin, COUNT(ID) FROM vozvratu WHERE magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY magazin",$db);
//  	$summa_vozv = mysql_fetch_array($res_summ_vozv);
//	if ($summa_vozv['COUNT(ID)'] == '') {$summa_vozv['COUNT(ID)'] = 0;}
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_vozv['COUNT(ID)']);}
//	
//	     else {printf("<td><p align=\"center\"><strong>-</strong></p></td><td><p align=\"center\"></p></td>");}
//	
//	}
//	else {		
//		$i = 1; $summa = 0;
//		do {
//		$res_summ_vozv = mysql_query("SELECT magazin, COUNT(ID) FROM vozvratu WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY magazin",$db);	
//		$summa_vozv = mysql_fetch_array($res_summ_vozv);
//	    if ($summa_vozv['COUNT(ID)'] == '') {$summa_vozv['COUNT(ID)'] = 0;}
//		$summa = $summa + $summa_vozv['COUNT(ID)'];
//		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_vozv['COUNT(ID)']);
//		$i++;
//		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
//		} while (isset($_SESSION['name_mag'][$i]));
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);				
//	}  		
  	?>  	
    </tr>-->
<!--<tr bgcolor="#ecf2f6">
	<td><p>Терминалы:</p></td>
  	<?php
//    if ($_SESSION['id_mag_selected'] <> 'all') {
//    	
//    	   if ($_SESSION['tabl_store_show'][1] == '1') {   	
//    	  	 
//  		$res_summ_vozv_t = mysql_query("SELECT t_a, COUNT(ID) FROM vozvratu WHERE t_a = 'Т' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY t_a",$db);
//  	$summa_vozv_t = mysql_fetch_array($res_summ_vozv_t);
//	if ($summa_vozv_t['COUNT(ID)'] == '') {$summa_vozv_t['COUNT(ID)'] = 0;}
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_vozv_t['COUNT(ID)']);}
//
//      else {printf("<td><p align=\"center\"><strong>-</strong></p></td><td><p align=\"center\"></p></td>");} 
//
//}
//	else {		
//		$i = 1; $summa = 0;
//		do {
//		$res_summ_vozv_t = mysql_query("SELECT t_a, COUNT(ID) FROM vozvratu WHERE t_a = 'Т' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY t_a",$db);	
//		$summa_vozv_t = mysql_fetch_array($res_summ_vozv_t);
//	    if ($summa_vozv_t['COUNT(ID)'] == '') {$summa_vozv_t['COUNT(ID)'] = 0;}
//		$summa = $summa + $summa_vozv_t['COUNT(ID)'];
//		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_vozv_t['COUNT(ID)']);
//		$i++;
//		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
//		} while (isset($_SESSION['name_mag'][$i]));
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);				
//	}  		
  	?>  	
    </tr>-->
<!--<tr bgcolor="#ecf2f6">
	<td><p>Аксесуары:</p></td>
  	<?php
//  	if ($_SESSION['id_mag_selected'] <> 'all') {
//  		
//       if ($_SESSION['tabl_store_show'][1] == '1') {		
//  		 
//  		$res_summ_vozv_a = mysql_query("SELECT t_a, COUNT(ID) FROM vozvratu WHERE t_a = 'А' AND magazin = '{$myr_mag['name']}' AND sec_data = '$date_val' GROUP BY t_a",$db);
//  	$summa_vozv_a = mysql_fetch_array($res_summ_vozv_a);
//	if ($summa_vozv_a['COUNT(ID)'] == '') {$summa_vozv_a['COUNT(ID)'] = 0;}
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_vozv_a['COUNT(ID)']);}
//	
//	     else {printf("<td><p align=\"center\"><strong>-</strong></p></td><td><p align=\"center\"></p></td>");}
//	
//	}
//	else {		
//		$i = 1; $summa = 0;
//		do {
//		$res_summ_vozv_a = mysql_query("SELECT t_a, COUNT(ID) FROM vozvratu WHERE t_a = 'А' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '$date_val' GROUP BY t_a",$db);	
//		$summa_vozv_a = mysql_fetch_array($res_summ_vozv_a);
//	    if ($summa_vozv_a['COUNT(ID)'] == '') {$summa_vozv_a['COUNT(ID)'] = 0;}
//		$summa = $summa + $summa_vozv_a['COUNT(ID)'];
//		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_vozv_a['COUNT(ID)']);
//		$i++;
//		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
//		} while (isset($_SESSION['name_mag'][$i]));
//	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);				
//	}  		
  	?>  	
    </tr>-->
</tbody></table>

	
</td></tr>
<tr><td align="center">SandBOX Glyshutelservise &reg; &copy;</td></tr> 
  </table>
</div>

<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#plot_opetator").change(function(event){
    event.preventDefault();
    var operator=$("#plot_opetator").val();
    var tupe=$("#tupe_graph").val();
    if (tupe == 'bar') {$("#plot_graph").attr("src","./jpgraph/plot_bar_operatoru.php?plot_oper="+operator);}
    if (tupe == 'graph') {$("#plot_graph").attr("src","./jpgraph/plot_graph_operatoru.php?plot_oper="+operator);}
     
});
});
</script>
<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#tupe_graph").change(function(event){
    event.preventDefault();
    $("#plot_opetator").val("all");
    if ($(this).val() == 'bar') {$("#plot_graph").attr("src","./jpgraph/plot_bar_operatoru.php");}
    if ($(this).val() == 'graph') {$("#plot_graph").attr("src","./jpgraph/plot_graph_operatoru.php");}
});
});
</script>
<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#plot_kategory").change(function(event){
    event.preventDefault();
    var kategoria=$("#plot_kategory").val();
    var tupe1=$("#tupe1_graph").val();
    if (tupe1 == 'bar') {$("#plot_kateg").attr("src","./jpgraph/plot_bar_kategorii.php?plot_kateg="+kategoria);}
    if (tupe1 == 'graph') {$("#plot_kateg").attr("src","./jpgraph/plot_graph_kategorii.php?plot_kateg="+kategoria);}
     
});
});
</script>
<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#tupe1_graph").change(function(event){
    event.preventDefault();
    $("#plot_kategory").val("all");
    if ($(this).val() == 'bar') {$("#plot_kateg").attr("src","./jpgraph/plot_bar_kategorii.php");}
    if ($(this).val() == 'graph') {$("#plot_kateg").attr("src","./jpgraph/plot_graph_kategorii.php");}
});
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