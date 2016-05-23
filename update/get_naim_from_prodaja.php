<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag']; $kat = $_REQUEST['kat'];

$result = mysql_query("SELECT DISTINCT `naimenovanie` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `naimenovanie`",$db);
$myrow = mysql_fetch_array($result);  			

printf("<option value=''>Выберите товар</option>");
do {	
     printf ("<option value='%s'>%s</option>" , $myrow["naimenovanie"], $myrow["naimenovanie"]);
    }
while ($myrow = mysql_fetch_array($result));


}
?>