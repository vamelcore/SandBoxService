<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $naim = $_REQUEST['naim']; $pokup = $_REQUEST['pokup'];

$res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$mag'",$db);
$myr_mag=mysql_fetch_array($res_mag);

$result = mysql_query("SELECT `stoimost`, `user`, `voznag_za_jelezo`, `voznag_za_tp`, `oplata_tp_podkluchenie`, `ID`, `procent_prod`, `sebestoimost` FROM prodaja WHERE magazin = '{$myr_mag['name']}' AND kategoria = '$kat' AND naimenovanie = '$naim' AND data = '$pokup'",$db);
$myrow = mysql_fetch_assoc($result);  			

printf("<input type=\"text\" name=\"summanal\" readonly=\"true\" value=\"%s\"><input type=\"hidden\" name=\"user\" value=\"%s\"><input type=\"hidden\" name=\"voznag_za_jelezo\" value=\"%s\"><input type=\"hidden\" name=\"procent_pr\" value=\"%s\"><input type=\"hidden\" name=\"voznag_za_tp\" value=\"%s\"><input type=\"hidden\" name=\"oplata_tp_podkluchenie\" value=\"%s\"><input type=\"hidden\" name=\"ID_prodaja\" value=\"%s\"><input type=\"hidden\" name=\"sebestoim\" value=\"%s\">",$myrow['stoimost'], $myrow['user'], $myrow['voznag_za_jelezo'], $myrow['procent_prod'], $myrow['voznag_za_tp'], $myrow['oplata_tp_podkluchenie'], $myrow['ID'], $myrow['sebestoimost']);

}
?>