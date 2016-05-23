<?php include ("../config.php"); include ("functions.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

	  $mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $naim = $_REQUEST['naim'];

$result = mysql_query("SELECT DISTINCT `data` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE `ID` = '$mag' ) AND `kategoria` = '$kat' AND `naimenovanie` = '$naim' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC",$db);
$myrow = mysql_fetch_assoc($result);  			

printf("<option value=''>Выберите дату</option>");
do {	
     printf ("<option value='%s'>%s</option>" , $myrow["data"], $myrow["data"]);
    }
while ($myrow = mysql_fetch_array($result));


}
?>