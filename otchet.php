<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_otch'] == 1)) {
 
 	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}
	
$_SESSION['lastpagevizitmag'] = 'otchet.php';	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Отчет по операторам</title>
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
<td style="border-bottom:1px solid #c6d5e1;"><?php if ($_SESSION['tabl_store_show'][2] <> '1') {header("Location: index.php"); die();} include ("includers/header_mag.php");?></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td><p style="font-size:10pt;">Оператор</p></td><td><form action="" method="post"><select name="operator" onchange="javascript:form.submit()"><?php
	$result_oper = mysql_query("SELECT `ID`, `oper` FROM `operatoru` ORDER BY `oper`",$db);
	$myrow_oper = mysql_fetch_array($result_oper);
	if (isset ($_POST['operator'])) {$_SESSION['ID_oper'] = $_POST['operator'];}
	do {
	if (!isset($_SESSION['ID_oper'])) {$_SESSION['ID_oper'] = $myrow_oper['ID']; $_POST['operator'] = $myrow_oper['ID'];}
	if ($_SESSION['ID_oper'] == $myrow_oper['ID']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_oper['ID'],$myrow_oper['oper']);  $_SESSION['ID_oper'] = $myrow_oper['ID'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_oper['ID'],$myrow_oper['oper']);
	}
	}
	while ($myrow_oper = mysql_fetch_array($result_oper));
	
		?></select></form></td><td><p style="font-size:10pt;">Дата</p></td><td><form action="" method="post"><select name="sec_data" onchange="javascript:form.submit()"><?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM `otchet` ORDER BY `ID` DESC",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset ($_POST['sec_data'])) {$_SESSION['sec_data'] = $_POST['sec_data'];}
	do {
	if (!isset($_SESSION['sec_data'])) {$_SESSION['sec_data'] = $myrow_date['sec_data']; $_POST['sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['sec_data'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
	
		?></select></form></td><td><form action="./otchet_to_xls.php"><input type="submit" value="Сохранить в XLS"></form></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>				
				<?php if($_SESSION['ed_priv_otch'] == 1) {
				printf("<th class=\"nosort\"><h3><strong>E</strong></h3></th>");
				printf("<th class=\"nosort\"><h3><strong>D</strong></h3></th>");
				} else {
					printf("<th class=\"nosort\"><h3></h3></th>");
				} 
				?>
				<th><h3>Дата</h3></th>
				<th><h3>Магазин</h3></th>
				<th><h3>ФИО</h3></th>
				<th><h3>Номер абонента</h3></th>
				<th><h3>Контактный номер телефона</h3></th>
				<th><h3>Пакет</h3></th>
				<th><h3>Ключ EVDO</h3></th>
				<th><h3>Аванс</h3></th>
				<th><h3>Оплата с лицевого счета</h3></th>
				<th><h3>Остаток на лицевом счете</h3></th>
				<th><h3>Оборудование</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {$result = mysql_query("SELECT * FROM otchet WHERE ID_operatora = '{$_SESSION['ID_oper']}' AND sec_data = '{$_SESSION['sec_data']}' ORDER BY ID DESC",$db);}
else {
$res_mag=mysql_query("SELECT name FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myr_mag=mysql_fetch_array($res_mag);
$result = mysql_query("SELECT * FROM otchet WHERE ID_operatora = '{$_SESSION['ID_oper']}' AND sec_data = '{$_SESSION['sec_data']}' AND magazin = '{$myr_mag['name']}' ORDER BY ID DESC",$db);
}

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {
	
if ($_SESSION['ed_priv_otch'] == 1) {
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_otchet.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/del_otchet.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td>",$myrow['ID'],$myrow['ID']);}	
else {
	printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td>");
}
	
	
	printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$myrow['data'],$myrow['magazin'],$myrow['fio'],$myrow['nomer_abon'],$myrow['kontakt_nomer'],$myrow['paket'],$myrow['kluch_evdo'],$myrow['avans'],$myrow['oplata'],$myrow['ostatok'],$myrow['oborudov']);
	
}
while($myrow = mysql_fetch_array($result));

} else{
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