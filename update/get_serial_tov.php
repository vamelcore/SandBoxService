<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	 $idtov=$_REQUEST['idtov'];  $kateg=$_REQUEST['kateg'];

if ($kateg <> '') {
	
$result_tname = mysql_query("SELECT `ID`, `tovar` FROM `prase` WHERE `ID` = '$idtov'",$db);
$myrow_tname = mysql_fetch_array($result_tname);
printf("<option value='%s'>%s</option>",$myrow_tname['ID'],$myrow_tname['tovar']);
}

else {printf('<option value="">Нет записи о товаре в остатках</option>');}

}
?>