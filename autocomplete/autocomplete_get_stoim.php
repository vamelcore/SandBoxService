<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $identify_tov=$_REQUEST['identify_tov']; $kat_id=$_REQUEST['kat_id']; $mag_id=$_REQUEST['mag_id'];


if ($identify_tov <> '') {

$result_tov = mysql_query("SELECT `ID_tovara` FROM `shtrihkod` WHERE `shtrih` = '$identify_tov'",$db);

if (mysql_num_rows($result_tov) > 0) {

$myrow_tov = mysql_fetch_array($result_tov);

if ($kat_id <> '') {
	
$res_diff = mysql_query("SELECT `new_cena` FROM `diff_cena` WHERE `ID_magazina` = '$mag_id' AND `ID_tovara` = '{$myrow_tov['ID_tovara']}'",$db);
if (mysql_num_rows($res_diff) > 0) {
$myrow_diff = mysql_fetch_array($res_diff);
$cena = $myrow_diff['new_cena'];
}
else {
$result_tov = mysql_query("SELECT `cena` FROM prase WHERE ID = '{$myrow_tov['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
$cena = $myrow_tov['cena'];
}

printf('<input type="text" value="%s" readonly="true" name="stoimost">', $cena);

}

else {printf('<input type="text" value="----" readonly="true" name="stoimost">');}
}

else {printf('<input type="text" value="----" readonly="true" name="stoimost">');}
}

else {

//printf('<input type="text" value="----" readonly="true" name="stoimost">');	

}

}
?>