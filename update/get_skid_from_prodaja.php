<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $naim = $_REQUEST['naim']; $pokup = $_REQUEST['pokup'];

$res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$mag'",$db);
$myr_mag=mysql_fetch_array($res_mag);

$result = mysql_query("SELECT `skidka` FROM prodaja WHERE magazin = '{$myr_mag['name']}' AND kategoria = '$kat' AND naimenovanie = '$naim' AND data = '$pokup'",$db);
$myrow = mysql_fetch_assoc($result);  			

printf("<input type=\"text\" name=\"summabeznal\" readonly=\"true\" value=\"%s\">",$myrow['skidka']);

}
?>