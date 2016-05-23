<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kateg'];  $tov=$_REQUEST['tov'];

if ($kat == 'all') {
printf("<option value=''>Выберите товар</option>");
printf("<option value=''>Все</option>");	
}
else {
$result = mysql_query("SELECT `ID`,`shtrih` FROM `shtrihkod` WHERE `ID_ketegorii` = '$kat' AND `ID_tovara` = '$tov' ORDER BY `shtrih`",$db);
$myrow = mysql_fetch_array($result);
printf("<option value=''>Выберите штрих-код</option>");
 do {	
     printf ("<option value='%s'>%s</option>" , $myrow['ID'], $myrow['shtrih']);
    }
 while ($myrow = mysql_fetch_array($result));}
}
?>