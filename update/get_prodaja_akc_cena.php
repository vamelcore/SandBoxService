<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tarpl=$_REQUEST['tarpl']; $tov = $_REQUEST['tov'];

$result = mysql_query("SELECT `cena` FROM akciya WHERE ID_tp = '$tarpl' AND ID_tov = '$tov'",$db);
if (mysql_num_rows($result) > 0) {
	$myrow = mysql_fetch_array($result);
	printf("<input type=\"text\" value=\"%s\" readonly=\"true\" name=\"stoimost\">", $myrow['cena']);
}else {
	printf("<input type=\"text\" value=\"----\" readonly=\"true\" name=\"stoimost\">");
}

}
?>