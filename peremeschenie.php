<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_per'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}
	
$_SESSION['lastpagevizitmag'] = 'peremeschenie.php';	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Перемещение</title>
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
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table><tr><td><p style="font-size:10pt;">Таблица: "Перемещение" из базы данных. Дата: </p></td><td>
<form action="" method="post"><select name="per_sec_data" onchange="javascript:form.submit()"><option value="All">Все</option>
	<?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM peremeschenie ORDER BY `ID` DESC LIMIT 0 , 24",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset ($_POST['per_sec_data'])) {$_SESSION['per_sec_data'] = $_POST['per_sec_data'];}
	do {
	if (!isset($_SESSION['per_sec_data'])) {$_SESSION['per_sec_data'] = $myrow_date['sec_data']; $_POST['per_sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['per_sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['per_sec_data'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
?></select></form></td></tr></table>
</td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<th class="nosort"><h3><></h3></th>
				<th class="nosort"><h3>Дата/Время</h3></th>
				<th><h3>Категория товара</h3></th>
				<th><h3>Имя товара</h3></th>
				<th><h3>Сколько перемещено</h3></th>
				<th><h3>Из магазина</h3></th>
				<th><h3>В магазин</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {
if ($_SESSION['per_sec_data'] == 'All') {$result = mysql_query("SELECT * FROM peremeschenie ORDER BY ID DESC",$db);}
else {$result = mysql_query("SELECT * FROM peremeschenie WHERE sec_data = '{$_SESSION['per_sec_data']}' ORDER BY ID DESC",$db);}
}
else {
		
$result_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		

if ($_SESSION['per_sec_data'] == 'All') {$result = mysql_query("SELECT * FROM peremeschenie WHERE `peremescheno_otkuda` = '{$myrow_mag['name']}' OR `peremescheno_kuda` = '{$myrow_mag['name']}' ORDER BY ID DESC",$db);}
else {$result = mysql_query("SELECT * FROM peremeschenie WHERE (`peremescheno_otkuda` = '{$myrow_mag['name']}' OR `peremescheno_kuda` = '{$myrow_mag['name']}') AND sec_data = '{$_SESSION['per_sec_data']}' ORDER BY ID DESC",$db);}
}


//$result = mysql_query("SELECT * FROM peremeschenie ORDER BY ID DESC",$db);

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{
	
$myrow = mysql_fetch_array($result);
do {
	if ($_SESSION['id_mag_selected'] == 'all') { $src = 'images/brow_icon.png'; }
else {
if ($myrow['peremescheno_otkuda'] == $myrow_mag['name']) { $src = 'images/rrow_icon.png';}
else {$src = 'images/brow_icon.png';}	
	}

printf("<tr><td width=15 align='center'><img src='%s' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$src,$myrow['data'],$myrow['kateg'],$myrow['tovar'],$myrow['kolichestvo'],$myrow['peremescheno_otkuda'],$myrow['peremescheno_kuda']);



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