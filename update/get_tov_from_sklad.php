<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kat']; $mag = $_REQUEST['mag'];


$result_tov = mysql_query("SELECT `ID`,`tovar` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` = '$kat' ) ORDER BY `tovar`",$db);	

printf("<option value=''>Выберите товар</option>");
while ($myrow_tov = mysql_fetch_array($result_tov)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_tov["ID"], $myrow_tov["tovar"]);
	
	}


//$result_tov = mysql_query("SELECT `ID_tovara` FROM sklad_tovaru WHERE ID_magazina = '$mag' AND ID_kategorii = '$kat'",$db);
//$myrow_tov = mysql_fetch_array($result_tov);

//printf("<option value=''>Выберите товар</option>");
 //do {
//$result = mysql_query("SELECT `ID`,`tovar` FROM prase WHERE ID = '{$myrow_tov['ID_tovara']}' ORDER BY `tovar`",$db);	
///$myrow = mysql_fetch_array($result); 	

//     printf ("<option value='%s'>%s</option>" , $myrow["ID"], $myrow["tovar"]);
//    }
 //while ($myrow_tov = mysql_fetch_array($result_tov));

}
?>