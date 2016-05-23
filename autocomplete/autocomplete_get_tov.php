<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $identify_tov=$_REQUEST['identify_tov']; $kat_id=$_REQUEST['kat_id']; $mag_id=$_REQUEST['mag_id'];


if ($identify_tov <> '') {

$result_tov = mysql_query("SELECT `ID_tovara` FROM `shtrihkod` WHERE `shtrih` = '$identify_tov'",$db);

if (mysql_num_rows($result_tov) > 0) {

$myrow_tov = mysql_fetch_array($result_tov);

if ($kat_id <> '') {
	
$result_tname = mysql_query("SELECT tovar FROM prase WHERE ID = '{$myrow_tov['ID_tovara']}'",$db);
$myrow_tname = mysql_fetch_array($result_tname);
printf("<option value='%s'>%s</option>",$myrow_tov['ID_tovara'],$myrow_tname['tovar']);
}

else {printf('<option value="">Нет записи о товаре в остатках</option>');}
}

else {printf('<option value="">Нет записи о товаре</option>');}
}

else {

printf('<option value=""></option>');	

}

}
?>