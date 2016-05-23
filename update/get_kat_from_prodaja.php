<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag'];

//$res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$mag'",$db);
//$myr_mag=mysql_fetch_array($res_mag);

$result = mysql_query("SELECT DISTINCT `kategoria` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE `ID` = '$mag' ) ORDER BY `kategoria`",$db);
$myrow = mysql_fetch_assoc($result);  			

printf("<option value=''>Выберите категорию</option>");
do {	
  if ($myrow["kategoria"] <> '') {
     printf ("<option value='%s'>%s</option>" , $myrow["kategoria"], $myrow["kategoria"]);}
    }
while ($myrow = mysql_fetch_array($result));


}
?>