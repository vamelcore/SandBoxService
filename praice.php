<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_pri'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

$_SESSION['lastpagevizitmag'] = 'praice.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Прайс</title>
<link rel="stylesheet" href="style.css" />

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

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><?php include ("includers/header_mag.php");?></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table><tr><td><table><tr><td><form method="post"><select name="price_select" onChange="javascript:form.submit()">
	<?php 
	if (!isset($_SESSION['price_select'])) { $_SESSION['price_select'] = 'Материалы';} else { if (isset($_POST['price_select'])) {$_SESSION['price_select'] = $_POST['price_select'];}}
	if ($_SESSION['price_select'] == 'Материалы') {printf("<option selected='selected' value='Материалы'>Материалы</option>");} else {printf("<option value='Материалы'>Материалы</option>");}
	if ($_SESSION['price_select'] == 'Работы') {printf("<option selected='selected' value='Работы'>Работы</option>");} else {printf("<option value='Работы'>Работы</option>");}
	?>
</select></form></td><td><form method="post"><select name="kat_op" onchange="javascript:form.submit()"><option value="All" selected="selected">Все</option><?php
if ($_SESSION['price_select'] == 'Материалы') {
		$res_kat_pr= mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii ORDER BY `kateg`",$db);
		$myr_kat_pr=mysql_fetch_array($res_kat_pr);
        if (!isset($_SESSION['kat_prase'])) {$_SESSION['kat_prase'] = 'All';} else if (isset($_POST['kat_op'])) {$_SESSION['kat_prase'] = $_POST['kat_op']; unset($_POST['kat_op']);}	
do {
	if ($_SESSION['kat_prase'] == $myr_kat_pr['ID']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_kat_pr['ID'],$myr_kat_pr['kateg']);	
	} else {printf("<option value=\"%s\">%s</option>",$myr_kat_pr['ID'],$myr_kat_pr['kateg']);}
	} while ($myr_kat_pr=mysql_fetch_array($res_kat_pr));
} 
else {
		$res_op_pr= mysql_query("SELECT `ID`, `oper` FROM operatoru ORDER BY `oper`",$db);
		$myr_op_pr=mysql_fetch_array($res_op_pr);
		if (!isset($_SESSION['op_prase'])) {$_SESSION['op_prase'] = 'All';} else if (isset($_POST['kat_op'])) {$_SESSION['op_prase'] = $_POST['kat_op']; unset($_POST['kat_op']);}	
do {
	if ($_SESSION['op_prase'] == $myr_op_pr['ID']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_op_pr['ID'],$myr_op_pr['oper']);	
	} else {printf("<option value=\"%s\">%s</option>",$myr_op_pr['ID'],$myr_op_pr['oper']);}
} while ($myr_op_pr=mysql_fetch_array($res_op_pr));		
		}
 ?></select></form></td><td><p style="font-size:10pt;">Таблица: "Прайс" из базы данных </p></td><td><form action="praice_to_xls.php"><input type="submit" value="Сохранить в XLS"></form></td></tr></table></td></tr><tr><td><table><tr><td><form method="post" action="poisk.php"><table><tr><td><input type="text" name="poisk" style="width: 300px;" value="<?php if (isset($_SESSION['poisk'])) {echo $_SESSION['poisk_view'];}?>"></td><td><input type="submit" value="Искать"></td></tr></table></form></td><td><form method="post" action="poisk.php"><input type="submit" value="Очистить" name="clear"></form></td></tr></table></td></tr></table></td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<th class="nosort" width="30"><h3><></h3></th>
<?php if ($_SESSION['price_select'] == 'Материалы') {	printf(" 			
				<th><h3>Категория</h3></th>
				<th><h3>Имя товара</h3></th>
				<th><h3>Цена</h3></th>
				<th><h3>Вознаграждение</h3></th>"); } else { printf("

				<th><h3>Тип работы</h3></th>
				<th><h3>Работа</h3></th>
				<th><h3>Стоимость работы</h3></th>
				<th><h3>Вознаграждение</h3></th> ");}
?>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['price_select'] == 'Материалы') {
	if (isset($_SESSION['poisk'])) {
		$res_kat= mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg LIKE '%{$_SESSION['poisk']}%'",$db);
		$myr_kat=mysql_fetch_array($res_kat);
	$result = mysql_query("SELECT * FROM prase WHERE tovar LIKE '%{$_SESSION['poisk']}%' OR cena LIKE '%{$_SESSION['poisk']}%' OR voznag LIKE '%{$_SESSION['poisk']}%' OR ID_kategorii = '{$myr_kat['ID']}'",$db);} else {
		if ($_SESSION['kat_prase'] == 'All') {$result = mysql_query("SELECT * FROM prase",$db);} else {
		$result = mysql_query("SELECT * FROM prase WHERE ID_kategorii ='{$_SESSION['kat_prase']}'",$db);	
		}
	}
}
else {
	if (isset($_SESSION['poisk'])) {
		$res_op= mysql_query("SELECT `ID` FROM operatoru WHERE oper LIKE '%{$_SESSION['poisk']}%'",$db);
		$myr_op=mysql_fetch_array($res_op);
	$result = mysql_query("SELECT * FROM tarifplan WHERE tarifplan LIKE '%{$_SESSION['poisk']}%' OR stoim_podkl LIKE '%{$_SESSION['poisk']}%' OR voznagtp LIKE '%{$_SESSION['poisk']}%' OR ID_oper = '{$myr_op['ID']}'",$db);} else {
		if ($_SESSION['op_prase'] == 'All')	{$result = mysql_query("SELECT * FROM tarifplan",$db);} else {
		$result = mysql_query("SELECT * FROM tarifplan WHERE ID_oper ='{$_SESSION['op_prase']}'",$db);	
		}
	}
}


//$result = mysql_query("SELECT * FROM peremeschenie ORDER BY ID DESC",$db);

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{


if ($_SESSION['id_mag_selected'] <> 'all') {

$res_diff_cena = mysql_query("SELECT * FROM `diff_cena` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ORDER BY `ID_tovara` ASC",$db);

$myarray_diff_cena = array(); $index_cena = 0;
while ($myr_diff_cena = mysql_fetch_assoc($res_diff_cena)) {
foreach($myr_diff_cena as $key => $value) {
$myarray_diff_cena[$key][$index_cena] = $value;
}
$index_cena++;
}
//print_r($myarray_diff_cena);
//print_r($index_cena);
}

	
$myrow = mysql_fetch_array($result);
do { 
if ($_SESSION['price_select'] == 'Материалы') {
$res_kat=mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID ='{$myrow['ID_kategorii']}'");
$myr_kat=mysql_fetch_array($res_kat);

$cena = $myrow['cena'];
$vaznag = $myrow['voznag'];
if ($_SESSION['id_mag_selected'] <> 'all') {
for ($no=0; $no<$index_cena; $no++) {if ($myarray_diff_cena['ID_tovara'][$no] == $myrow['ID']) {$cena = $myarray_diff_cena['new_cena'][$no]; $vaznag =$myarray_diff_cena['new_bonus'][$no];}}}

printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$myr_kat['kateg'],$myrow['tovar'],$cena,$vaznag);
	} else {	
$res_op=mysql_query("SELECT `oper` FROM operatoru WHERE ID ='{$myrow['ID_oper']}'");
$myr_op=mysql_fetch_array($res_op);
printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$myr_op['oper'],$myrow['tarifplan'],$myrow['stoim_podkl'],$myrow['voznagtp']);
	}
}
while($myrow = mysql_fetch_array($result));


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
				<option value="10" >10</option>
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