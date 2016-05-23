<?php include ("config.php"); include ("update/functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'shtrihkod.php';

$_GET=defender_sql($_GET);

if (isset($_GET['al'])) {$alert = $_GET['al'];} else {$alert = '';}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Штрих-коды для оборудования</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="barcode/jquery-barcode.js"></script> 
<style type="text/css">
   SELECT {width: 250px;}
  </style>
</head>
<body onload="javascript: checker(); bar_code_make();">

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button_use" href="prase.php">Товары</a></td><td><a class="like_button" href="operatoru.php">Операторы</a></td><td><a class="like_button" href="tarifplan.php">Тарифы</a></td><td><a class="like_button" href="plan.php">План</a></td><td><a class="like_button" href="PAYment.php">Дилерам</a></td>
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
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td>
	<form action="update/insert_shtrihk.php" method="post"><table><tr>
		<td align="center">Категория</td><td align="center">Наименование товара</td><td align="center">Штрих-код</td><tr><tr>
	<td align="center"><select name="kategory" id="kateg"><option value="all">Все</option>
  			<?php 
$res_kat = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii` ORDER BY `kateg` ASC",$db);	
$myr_kat = mysql_fetch_array($res_kat);
if (isset($_SESSION['selected_kat_shtrih'])) {
do {

if ($myr_kat['ID'] == $_SESSION['selected_kat_shtrih']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
}
else {
do {	
printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
$_SESSION['selected_kat_shtrih'] = 'all';	
}
  			?>
  		</select></td>
	<td align="center"><select name="tovar" id="tovar" onChange="this.form.submit();"><option value="">Все</option>
<?php 
if (isset($_SESSION['selected_tov_shtrih'])) {
$res_tov = mysql_query("SELECT `ID`,`tovar` FROM prase WHERE `ID_kategorii` = '{$_SESSION['selected_kat_shtrih']}' ORDER BY `tovar` ASC",$db);	
$myr_tov = mysql_fetch_array($res_tov);
do {

if ($myr_tov['ID'] == $_SESSION['selected_tov_shtrih']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tov['ID'],$myr_tov['tovar']);}	
}		
while ($myr_tov = mysql_fetch_array($res_tov));
}

  			?>		
	</select></td>
	<td align="center"><input type="text" name="shtrihkod" id="main_input" value=""></td>
	<td rowspan="2" align="center" valign="center"><input type="button" value="Сгенерировать" id="gener" onClick="generator_shtih();"><input type="button" value="Очистить" id="ochistka" onClick="clear_input_shtih();"><input type="submit" id="dobavit" value="Добавить"></td>
	</tr></table></form>
	</td></tr></table></td>
</tr>
<?php 

if ($alert <> '') {
printf('
  <tr>
    <td style="border-bottom:1px solid #c6d5e1;"><p style="text-align:center; font-size:14px; color:red;"><strong>Этот штрих-код привязан к серийному номеру:</strong></p><p style="text-align:center; font-size:14px; color:black;"><strong>%s</strong></p></td>
  </tr>
',$alert);	
}

 ?>
 
<!--  <tr>
    <td style="border-bottom:1px solid #c6d5e1;"><p style="text-align:center; font-size:14px; color:black;">Ширина: <select style="width:auto;" id="wide_codebar"><option value=1>1</option><option value=2 selected="selected">2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option></select> Высота: <select style="width:auto;" id="heigth_codebar"><option value=30>30</option><option value=40>40</option><option value=50 selected="selected">50</option><option value=60>60</option><option value=70>70</option></select> <input type="button" value="Измениить" onclick="bar_code_make()"></p></td>
  </tr>-->

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
			<tr>
				<th width="20" class="nosort"><h3>Удалить</h3></th>
				<?php if ($_SESSION['selected_kat_shtrih'] == 'all') {
					printf ("
					<th><h3>Категория</h3></th>
					<th><h3>Наименование товара</h3></th>
					");
				} ?>
				<th width="90" ><h3>Штрих-код</h3></th>
                <th width="90" class="nosort"><h3>Изображение</h3></th>                
			</tr>
		</thead>
		<tbody>
<?php
if ($_SESSION['selected_kat_shtrih'] == 'all') {$result = mysql_query("SELECT * FROM shtrihkod ORDER BY ID ASC",$db);}
else {
$result = mysql_query("SELECT ID, shtrih FROM shtrihkod WHERE ID_ketegorii = '{$_SESSION['selected_kat_shtrih']}' AND ID_tovara = '{$_SESSION['selected_tov_shtrih']}' ORDER BY ID ASC",$db);}

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
$b = 1;
if ($_SESSION['selected_kat_shtrih'] == 'all') {	

$res_kateg = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);

$myarray_kateg = array(); $index_kat = 0;
while ($myr_kateg = mysql_fetch_assoc($res_kateg)) {
foreach($myr_kateg as $key => $value) {
$myarray_kateg[$key][$index_kat] = $value;
}
$index_kat++;
}

$res_tovar = mysql_query("SELECT `ID`,`tovar` FROM prase",$db);

$myarray_tovar = array(); $index_tov = 0;
while ($myr_tovar = mysql_fetch_assoc($res_tovar)) {
foreach($myr_tovar as $key => $value) {
$myarray_tovar[$key][$index_tov] = $value;
}
$index_tov++;
}

do {
	
//$res_kat_a = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii WHERE ID = '{$myrow['ID_ketegorii']}'",$db);	
//$myr_kat_a = mysql_fetch_array($res_kat_a);
//$res_tov_a = mysql_query("SELECT `ID`,`tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);	
//$myr_tov_a = mysql_fetch_array($res_tov_a);

for ($no=0; $no<$index_kat; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_ketegorii']) {$kategoriya = $myarray_kateg['kateg'][$no];}}
for ($no=0; $no<$index_tov; $no++) {if ($myarray_tovar['ID'][$no] == $myrow['ID_tovara']) {$tovar = $myarray_tovar['tovar'][$no];}}		
		
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_shtrihk.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td align='center'><div  id='bcTarget%s'><input type='hidden' readonly=readonly id='bar_code_%s' value='%s'></div></td></tr>",$myrow['ID'],$kategoriya, $tovar, $myrow['shtrih'], $b, $b, $myrow['shtrih']);
$b++;	
}
while($myrow = mysql_fetch_array($result));	
	
}
else {
do {	
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_shtrihk.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td><strong>%s</strong></td><td align='center'><div id='bcTarget%s'><input type='hidden' readonly=readonly id='bar_code_%s' value='%s'></div></td></tr>",$myrow['ID'],$myrow['shtrih'], $b, $b, $myrow['shtrih']);	
$b++;
}
while($myrow = mysql_fetch_array($result));

}
} 

?>

</tbody></table>


<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)" style="width:45px;">
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
<p>Всего записей на этой странице: <?php echo $num_rows; ?><input type="hidden" id="bar_code_count" value="<?php echo $num_rows; ?>"></p>
</td></tr>

  </table>
</div>
<script type="text/javascript">
function bar_code_make(){
	var bar_code_count = $("#bar_code_count").val();
	for (var i=1; i<=bar_code_count; i++){
		if ($("#bar_code_"+i).length) {
		var bar_code_numb = $("#bar_code_"+i).val();
		if (isNaN(bar_code_numb)) {$("#bcTarget"+i).barcode(bar_code_numb, "code128",{barWidth:2, barHeight:50});}
		else if (bar_code_numb.length == 8) {$("#bcTarget"+i).barcode(bar_code_numb, "ean8",{barWidth:2, barHeight:50});}
		else if (bar_code_numb.length == 13) {$("#bcTarget"+i).barcode(bar_code_numb, "ean13",{barWidth:2, barHeight:50});}
		else {$("#bcTarget"+i).barcode(bar_code_numb, "code128",{barWidth:2, barHeight:50});}				
		}
		}
	}
</script>

<script type="text/javascript">
         $("#kateg").change(function(){			  		
         $("#tovar").load("./update/get_tov_from_prise_serialn.php", { kateg: $("#kateg option:selected").val() },
		 function (){checker();}
		 );
         });

function checker(){
var kateg = $("#kateg option:selected").val();
var tovar = $("#tovar option:selected").val();
if ((kateg == 'all') || (tovar == 'all') || (tovar == '')) {	
		$("#main_input").attr("disabled", "disabled");
		$("#gener").attr("disabled", "disabled");
		$("#ochistka").attr("disabled", "disabled");
		$("#dobavit").attr("disabled", "disabled");
	    } else {
			$("#main_input").removeAttr("disabled");
	        $("#gener").removeAttr("disabled");
	        $("#ochistka").removeAttr("disabled");
	        $("#dobavit").removeAttr("disabled");
		    }
}	

$(document).ready(function() {
  $("#main_input").focus();
});

function clear_input_shtih() {
	$("#main_input").val('');
}

function generator_shtih()
{
    var numb = 2 + "<?php if ((!isset($_SESSION['selected_kat_shtrih'])) || ($_SESSION['selected_kat_shtrih'] == 'all')) {$_ses_selected_kat_shtrih = 000;} else {$_ses_selected_kat_shtrih = $_SESSION['selected_kat_shtrih'];} if (!isset($_SESSION['selected_tov_shtrih'])) {$_ses_selected_tov_shtrih = 00;} else {$_ses_selected_tov_shtrih = $_SESSION['selected_tov_shtrih'];} echo substr(str_pad($_ses_selected_kat_shtrih, 2, '0', STR_PAD_LEFT), -2, 2).substr(str_pad($_ses_selected_tov_shtrih, 2, '0', STR_PAD_LEFT), -2, 2); ?>";
	
    var text = '';
    var possible = '0123456789';

    for(var i=0; i < 7; i++)
    {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    	
    numb += text;
	
//chack sum generator
	
	var sum_o = parseInt(numb[0])+parseInt(numb[2])+parseInt(numb[4])+parseInt(numb[6])+parseInt(numb[8])+parseInt(numb[10]);
	var sum_e = (parseInt(numb[1])+parseInt(numb[3])+parseInt(numb[5])+parseInt(numb[7])+parseInt(numb[9])+parseInt(numb[11]))*3;	
	var checksum_value = sum_o + sum_e;	
	var checksum_digit = 10 - (checksum_value % 10);	
	if (checksum_digit == 10) {checksum_digit = 0;}	
	numb += checksum_digit;

//chack sum generator
	
	$("#main_input").val(numb);
}
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