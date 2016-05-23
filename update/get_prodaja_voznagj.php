<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tov=$_REQUEST['tov']; $mag=$_REQUEST['mag'];

$res_diff = mysql_query("SELECT `new_bonus` FROM `diff_cena` WHERE `ID_magazina` = '$mag' AND `ID_tovara` = '$tov'",$db);
if (mysql_num_rows($res_diff) > 0) {
$myrow_diff = mysql_fetch_array($res_diff);
$voznag = $myrow_diff['new_bonus'];
}
else {
$result_tov = mysql_query("SELECT `voznag` FROM `prase` WHERE `ID` = '$tov'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
$voznag = $myrow_tov['voznag'];
}


printf("<input type=\"text\" value=\"%s\" readonly=\"true\" name=\"voznag_za_jelezo\">", $voznag);


}
?>