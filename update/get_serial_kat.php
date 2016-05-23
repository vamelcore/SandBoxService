<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $idkat=$_REQUEST['idkat']; $idtov=$_REQUEST['idtov']; $magid=$_REQUEST['magid'];


$result_sklad = mysql_query("SELECT kolichestvo FROM sklad_tovaru WHERE ID_magazina = '$magid' AND ID_kategorii = '$idkat' AND ID_tovara = '$idtov'",$db);
if (mysql_num_rows($result_sklad) > 0) {
$myrow_sklad = mysql_fetch_array($result_sklad);
if ($myrow_sklad['kolichestvo'] > 0) {
$result_kat = mysql_query("SELECT ID, kateg FROM sklad_kategorii WHERE ID = '$idkat'",$db);
$myrow_kat = mysql_fetch_array($result_kat);
printf("<option value='%s'>%s</option>",$myrow_kat['ID'],$myrow_kat['kateg']);
}
else {printf('<option value="">Количество товара равно 0</option>');}
}
else {printf('<option value="">Нет записи о товаре в остатках</option>');}
}



?>