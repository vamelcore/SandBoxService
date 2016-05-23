<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag']; $kat = $_REQUEST['kat'];
	  
	  
$result = mysql_query("SELECT `ID`, `tovar` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` = '$kat' ) AND `kolichestvo` <> '0' ) ORDER BY `tovar`",$db);

printf("<option value='0'>Возврат денег</option>");
while ($myrow = mysql_fetch_array($result)) {
	
	printf ("<option value='%s'>%s</option>" , $myrow["ID"], $myrow["tovar"]);
	
	
	}  
	  
	  
	  

//$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kat'",$db);
//$myr_kat=mysql_fetch_array($res_kat);

//$result = mysql_query("SELECT `ID_tovara` FROM sklad_tovaru WHERE ID_magazina = '$mag' AND ID_kategorii = '{$myr_kat['ID']}' AND kolichestvo <> '0'",$db);
//$myrow = mysql_fetch_array($result);  			

//printf("<option value='0'>Возврат денег</option>");
//do {
//$res_tov=mysql_query("SELECT `tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
//$myr_tov=mysql_fetch_array($res_tov);		
//     printf ("<option value='%s'>%s</option>" , $myrow["ID_tovara"], $myr_tov["tovar"]);
//    }
//while ($myrow = mysql_fetch_array($result));


}
?>