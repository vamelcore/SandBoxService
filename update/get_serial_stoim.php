<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $idtov=$_REQUEST['idtov']; $magid=$_REQUEST['magid']; $kateg=$_REQUEST['kateg'];

if ($kateg <> '') {
	
$res_diff = mysql_query("SELECT `new_cena` FROM `diff_cena` WHERE `ID_magazina` = '$magid' AND `ID_tovara` = '$idtov'",$db);
if (mysql_num_rows($res_diff) > 0) {
$myrow_diff = mysql_fetch_array($res_diff);
$cena = $myrow_diff['new_cena'];
}
else {
$result_tov = mysql_query("SELECT `cena` FROM prase WHERE ID = '$idtov'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
$cena = $myrow_tov['cena'];
}

printf('<input type="text" value="%s" readonly="true" name="stoimost">', $cena);

}

else {printf('<input type="text" value="----" readonly="true" name="stoimost">');}

}
?>