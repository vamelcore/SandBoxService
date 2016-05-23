<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $identify_tov=$_REQUEST['identify_tov']; $mag_id=$_REQUEST['mag_id'];


if ($identify_tov <> '') {

$result_tov = mysql_query("SELECT `ID_ketegorii`, `ID_tovara` FROM `shtrihkod` WHERE `shtrih` = '$identify_tov'",$db);

if (mysql_num_rows($result_tov) > 0) {

$myrow_tov = mysql_fetch_array($result_tov);

$result_sklad = mysql_query("SELECT kolichestvo FROM sklad_tovaru WHERE ID_magazina = '$mag_id' AND ID_kategorii = '{$myrow_tov['ID_ketegorii']}' AND ID_tovara = '{$myrow_tov['ID_tovara']}'",$db);
if (mysql_num_rows($result_sklad) > 0) {
$myrow_sklad = mysql_fetch_array($result_sklad);
if ($myrow_sklad['kolichestvo'] > 0) {
$result_kat = mysql_query("SELECT kateg FROM sklad_kategorii WHERE ID = '{$myrow_tov['ID_ketegorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat);
printf("<option value='%s'>%s</option>",$myrow_tov['ID_ketegorii'],$myrow_kat['kateg']);
}
else {printf('<option value="">Количество товара равно 0</option>');}
}
else {printf('<option value="">Нет записи о товаре в остатках</option>');}
}
else{printf('<option value="">Нет записи о товаре</option>');}
}
else {
$result_kat = mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` WHERE `ID` IN ( SELECT DISTINCT `ID_kategorii` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag_id' ) ORDER BY `kateg`",$db);
printf('<option value="">Выберите категорию</option>');	
while ($myrow_kat = mysql_fetch_array($result_kat)) {
printf ("<option value='%s'>%s</option>" , $myrow_kat["ID"], $myrow_kat["kateg"]);
}
}

}
?>