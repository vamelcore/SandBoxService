<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['vot_priv_ost'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Остатки</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" type="text/css" href="form/style_popolnenie.css"/>
<script language="JavaScript" src="js/jquery-1.3.2.js"></script>
<script src="form/jquery.js"></script> 
<script>

$(function() {
	$("a[rel]").overlay(function test() {		
   $('#overlay').html('<div class="wrap"></div>');
		var wrap = this.getContent().find("div.wrap");
		if (wrap.is(":empty")) {
			wrap.load(this.getTrigger().attr("href"));
		}
	});
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
<td style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr><td><p style="font-size:10pt;">Категоря:</p></td><td><form method="post"><select name="kat_skl" onchange="javascript:form.submit()"><option value="All" selected="selected">Все</option>
	<?php
	$res_kat= mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii ORDER BY `kateg`",$db);
	$myr_kat=mysql_fetch_array($res_kat);
   if (!isset($_SESSION['kat_skl'])) {$_SESSION['kat_skl'] = 'All';} else if (isset($_POST['kat_skl'])) {$_SESSION['kat_skl'] = $_POST['kat_skl']; unset($_POST['kat_skl']);}
   do {
   	if ($_SESSION['kat_skl'] == $myr_kat['ID']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	} else {printf("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
   } while ($myr_kat=mysql_fetch_array($res_kat)); 
	?></select></form></td><td> <p style="font-size:10pt;">Таблица: "Остатки на всех магазинах" </p></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php 
					printf("<th><h3>Наименование товара</h3></th>");
					$res_magazin = mysql_query("SELECT name FROM magazinu ORDER BY ID",$db);
					while ($myr_magazin = mysql_fetch_array($res_magazin)) {
						printf("<th class=\"nosort\"><h3>%s, количество</h3></th>", $myr_magazin['name']);	
						}					
					printf("<th class=\"nosort\"><h3>Суммарное количество</h3></th>");		
				?>				
			</tr>
		</thead>
		<tbody>
<?php

		if ($_SESSION['kat_skl'] == 'All') {$result = mysql_query("SELECT DISTINCT ID_tovara FROM sklad_tovaru ORDER BY ID_kategorii ASC",$db);}
		else {$result = mysql_query("SELECT DISTINCT ID_tovara FROM sklad_tovaru WHERE ID_kategorii = '{$_SESSION['kat_skl']}' ORDER BY ID_kategorii ASC",$db);}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{
$myrow = mysql_fetch_array($result);

do {
$result_tov = mysql_query("SELECT `tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);	
printf("<tr><td>%s</td>",$myrow_tov['tovar']);

   $summa = 0;
   $res_magazin = mysql_query("SELECT ID FROM magazinu ORDER BY ID",$db);
   while ($myr_magazin = mysql_fetch_array($res_magazin)) {
   	$res_kolich = mysql_query("SELECT kolichestvo FROM sklad_tovaru WHERE ID_magazina = '{$myr_magazin['ID']}' AND ID_tovara = '{$myrow['ID_tovara']}'",$db);
	if (mysql_num_rows($res_kolich) > 0) {
		$myr_kolich = mysql_fetch_array($res_kolich);
		printf("<td>%s</td>",$myr_kolich['kolichestvo']);
		$summa = $summa + $myr_kolich['kolichestvo'];
	} else {printf("<td>----</td>");}		
   }

printf("<td><strong>%s</strong></td></tr>",$summa);	
} 
while ($myrow = mysql_fetch_array($result));	

}

else
{
echo "<p>В таблице нет записей</p>";
//exit();
}
?>
</tbody></table>

<div class="overlay" id="overlay">
<div class="wrap"></div></div>

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
	sorter.init("table",0);
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