<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_pro'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

$_SESSION['lastpagevizitmag'] = 'prodaja.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Работы</title>
<link rel="stylesheet" href="style.css" />
<script language="JavaScript" src="js/jquery-1.3.2.js"></script>

    <script src="printing/jquery-1.4.4.min.js" type="text/javascript"></script>
    <script src="printing/jquery.printPage.js" type="text/javascript"></script>
  <script>  
  $(document).ready(function() {
    $(".btnPrint").printPage();
  });
  </script>

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

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><?php include ("includers/header_mag.php");?></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr><td><?php if($_SESSION['add_priv_pro'] == 1) {printf("<input name=\"add\" type=\"button\" value=\"Добавить работу\" onclick=\"top.location.href='update/add_prodaja.php'\">");} ?> </td><td><input name="update" type="button" value="Сортировка по дате" onclick="top.location.href='prodaja.php'"></td> <?php if (isset($_SESSION['rollpriv']) && ($_SESSION['rollpriv'] == 1)) { printf("<td><input type=\"button\" value=\"Отмена работы\" onclick=\"top.location.href='update/rollback_prodaja.php'\"></td>"); } ?> <td><p style="font-size:10pt;">Таблица: "Работы". </p></td><td><p style="font-size:10pt;">Дата:</p></td><td><form action="" method="post"><select name="pr_sec_data" onchange="javascript:form.submit()"><option value="All">Все</option>
	<?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM prodaja WHERE `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC LIMIT 0 , 24",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset ($_POST['pr_sec_data'])) {$_SESSION['pr_sec_data'] = $_POST['pr_sec_data'];}
	do {
	if (!isset($_SESSION['pr_sec_data'])) {$_SESSION['pr_sec_data'] = $myrow_date['sec_data']; $_POST['pr_sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['pr_sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['pr_sec_data'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
	
		?></select></form></td><td><form action="prodaja_to_xls.php"><input type="submit" value="Сохранить в XLS"></form></td>
<!--            <td><p style="font-size:10pt;">Сумма на счету в Intertelecom:</p></td>
            <td><p style="font-size:10pt; color: green;">-->
	<?php 
//	$res_rah = mysql_query("SELECT schet FROM operatoru WHERE oper = 'Intertelecom'",$db);
//	$myr_rah = mysql_fetch_array($res_rah);
//	echo $myr_rah['schet']; 
	?>
<!--                </p></td>
            <td><p style="font-size:10pt;">грн.</p></td>-->
            <td><p style="font-size:10pt;">Сумма в кассе:</p></td><td><p style="font-size:10pt; color: green;"><?php 

if ($_SESSION['id_mag_selected'] == 'all') {

$no = 0;	$vkasse = 0;
do {
$no = $no +1;

$res_vkasse = mysql_query("SELECT `vkasse` FROM kassa WHERE magazine = '{$_SESSION['name_mag'][$no]}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse = mysql_fetch_array($res_vkasse);
	
$vkasse = $vkasse + $myr_vkasse['vkasse'];
	
} while($no < $_SESSION['count_mag']);

echo $vkasse;
	
} else {
	
$result_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		
					
//	$res_max_kassa = mysql_query("SELECT MAX(ID) AS `ID` FROM kassa WHERE magazine = '{$myrow_mag['name']}'",$db);
//	$myr_max_kassa = mysql_fetch_array($res_max_kassa, MYSQL_ASSOC);
//	$res_vkasse = mysql_query("SELECT `vkasse` FROM kassa WHERE ID = '{$myr_max_kassa['ID']}'",$db);

$res_vkasse = mysql_query("SELECT `vkasse` FROM kassa WHERE magazine = '{$myrow_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse = mysql_fetch_array($res_vkasse);
	
echo $myr_vkasse['vkasse'];	}        	
	        	
?></p><td><p style="font-size:10pt;">грн.</p></td></td><td><?php if (($_SESSION['kassapriv'] == 1) && ($_SESSION['id_mag_selected'] <> 'all')) {printf("<form action=\"update/insert_kassa.php\" method=\"post\"><input type=\"hidden\" name=\"get_priv_for_prod\" value=\"1001\"><input type=\"hidden\" name=\"magaz\" value='%s'>Сумма:<input style=\"width:50px;\" type=\"text\" name=\"inkas\">Причина:<input style=\"width:150px;\" type=\"text\" name=\"prichina\"><input type=\"submit\" value=\"Инкассировать\"></form>",$myrow_mag['name']);}?></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php if($_SESSION['ed_priv_pro'] == 1) {
				printf("<th class=\"nosort\"><h3><strong>P</strong></h3></th>");
				printf("<th class=\"nosort\"><h3><strong>E</strong></h3></th>");
				printf("<th class=\"nosort\"><h3><strong>D</strong></h3></th>");
				} else {
					printf("<th class=\"nosort\"><h3><strong>P</strong></h3></th>");
				} 
				?>
				<th class="nosort"><h3>Дата</h3></th>
				<th><h3>Тип</h3></th>
				<?php 
				if ($_SESSION['id_mag_selected'] == 'all') {
					printf("<th><h3>Магазин</h3></th>");
				}
				?>
				<th><h3>Категория</h3></th>
				<th><h3>Наименование/(Остаток)</h3></th>
				<th><h3>Вознаграждение, грн</h3></th>
				<th><h3>Стоимость материалов, грн</h3></th>
				<th><h3>Процент от прод, грн.</h3></th>
				<th><h3>Тип работы</h3></th>
				<th><h3>Работа</h3></th>
				<th><h3>Вознаграждение за работу, грн</h3></th>				
				<th><h3>Оплата за работу, грн</h3></th>
				<th><h3>Марка авто</h3></th>
				<th><h3>Контактний номер телефона</h3></th>
				<th><h3>ФИО</h3></th>
				<th><h3>Абонентский номер</h3></th>
				<th><h3>Место пользования</h3></th>
				<th><h3>Скидка</h3></th>
				<?php 
				if ($_SESSION['sebespriv'] == 1) {
				printf('<th><h3>Себестоимость, грн</h3></th>');
				}
				?>				
				<th><h3>Примечание</h3></th>
				<th><h3>Кем выполнино</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {
		if ($_SESSION['pr_sec_data'] == 'All') {
	$result = mysql_query("SELECT * FROM prodaja ORDER BY ID DESC",$db);
		}
        else {
	$result = mysql_query("SELECT * FROM prodaja WHERE sec_data = '{$_SESSION['pr_sec_data']}' ORDER BY ID DESC",$db);	
	        }
}
else {		
	
	if ($_SESSION['pr_sec_data'] == 'All') {
	$result = mysql_query("SELECT * FROM prodaja WHERE magazin = '{$myrow_mag['name']}' ORDER BY ID DESC",$db);
		}
    else {
	$result = mysql_query("SELECT * FROM prodaja WHERE magazin = '{$myrow_mag['name']}' AND sec_data = '{$_SESSION['pr_sec_data']}' ORDER BY ID DESC",$db);	
	        }
}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)
{

$res_magaz = mysql_query("SELECT `ID`, `name` FROM `magazinu`",$db);
$my_array_magaz = array(); $ind_mag = 0;	
while ($myr_magaz = mysql_fetch_array($res_magaz)) {	
$my_array_magaz['ID'][$ind_mag] = $myr_magaz['ID'];
$my_array_magaz['magaz'][$ind_mag] = $myr_magaz['name'];
$ind_mag++;}

$res_kateg = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii`",$db);
$my_array_kateg = array(); $ind_kat = 0;	
while ($myr_kateg = mysql_fetch_array($res_kateg)) {	
$my_array_kateg['ID'][$ind_kat] = $myr_kateg['ID'];
$my_array_kateg['kateg'][$ind_kat] = $myr_kateg['kateg'];
$ind_kat++;}

while($myrow = mysql_fetch_array($result)) {

if (strlen($myrow['sec_data']) == 16) {$style = 'style="color:#b5b5b5;"';}
else {$style = '';}

if ($myrow['printer_ID'] == '') {$printer_img_path = 'images/print.png';}
else { if ($myrow['printer_ID'] == $myrow['ID']) {$printer_img_path = 'images/print_gr1.png';} else {$printer_img_path = 'images/print_gr2.png';}}

for ($i=0; $i<$ind_mag; $i++) {if ($myrow['magazin'] == $my_array_magaz['magaz'][$i]) {$id_magazine_from_array = $my_array_magaz['ID'][$i];}}

for ($i=0; $i<$ind_kat; $i++) {if ($myrow['kategoria'] == $my_array_kateg['kateg'][$i]) {$id_kategory_from_array = $my_array_kateg['ID'][$i];}}

if (isset($id_kategory_from_array)) {
        $tov_name_with_slash = addslashes($myrow['naimenovanie']);
	$res_tovar = mysql_query("SELECT `ID` FROM `prase` WHERE `ID_kategorii` = '$id_kategory_from_array' AND `tovar` = '{$tov_name_with_slash}'",$db); 
if (mysql_num_rows($res_tovar) > 0)	{
	$myr_tovar = mysql_fetch_array($res_tovar);
	$res_ostatok = mysql_query("SELECT `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '$id_magazine_from_array' AND `ID_kategorii` = '$id_kategory_from_array' AND `ID_tovara` = '{$myr_tovar['ID']}'",$db);
	$myr_ostatok = mysql_fetch_array($res_ostatok);
	if ($myr_ostatok['kolichestvo'] == '') {$div_with_tov = "<div style='float:right; color:red; font-size:7pt; font-weight:bold;'>(нет)</div>";} 
	elseif ($myr_ostatok['kolichestvo'] < '2') {$div_with_tov = "<div style='float:right; color:red; font-size:7pt; font-weight:bold;'>(".$myr_ostatok['kolichestvo'].")</div>";} 
	else {$div_with_tov = "<div style='float:right; color:green; font-size:7pt; font-weight:bold;'>(".$myr_ostatok['kolichestvo'].")</div>";}
	} else {$div_with_tov = "<div style='float:right; color:red; font-size:7pt; font-weight:bold;'>(---)</div>";}
} else {$div_with_tov = "<div style='float:right; color:red; font-size:7pt; font-weight:bold;'>(---)</div>";}
	
if ($_SESSION['ed_priv_pro'] == 1) {
	printf("<tr><td width=15 align='center'><img class=\"btnPrint\" href='printing/print_page_prodaja.php?id=%s' src='%s' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_prodaja.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/del_prodaja.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td>",$myrow['ID'],$printer_img_path,$myrow['ID'],$myrow['ID']);}	
else {
	printf("<tr><td width=15 align='center'><img class=\"btnPrint\" href='printing/print_page_prodaja.php?id=%s' src='%s' width='20' height='20' border='0'></td>",$myrow['ID'],$printer_img_path);
}
	 
printf("<td><p %s>%s</p></td><td><p %s>%s</p></td>",$style,$myrow['data'],$style,$myrow['b']);

if ($_SESSION['id_mag_selected'] == 'all') {printf("<td><p %s>%s</p></td>",$style,$myrow['magazin']);}

printf("<td><p %s>%s</p></td><td><p %s>%s %s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td><td><p %s>%s</p></td>",$style,$myrow['kategoria'],$style,$myrow['naimenovanie'],$div_with_tov,$style,$myrow['voznag_za_jelezo'],$style,$myrow['stoimost'],$style,$myrow['procent_prod'],$style,$myrow['operator'],$style,$myrow['tarifn_plan'],$style,$myrow['voznag_za_tp'],$style,$myrow['oplata_tp_podkluchenie'],$style,$myrow['kluch_evdo'],$style,$myrow['kontakt_nomer_tel'],$style,$myrow['FIO'],$style,$myrow['abonent_nomer'],$style,$myrow['mesto_polz'],$style,$myrow['skidka']);

if ($_SESSION['sebespriv'] == 1) {printf("<td><p %s>%s</p></td>",$style,$myrow['sebestoimost']);}

printf("<td><p %s>%s</p></td><td><p %s>%s</p></td></tr>",$style,$myrow['add'],$style,$myrow['user']);

}

}

else
{
echo "<p>В таблице нет записей</p>";
//exit();
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