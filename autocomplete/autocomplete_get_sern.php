<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $identify_tov=$_REQUEST['identify_tov']; $kat_id=$_REQUEST['kat_id']; $mag_id=$_REQUEST['mag_id']; 

if (isset($_REQUEST['sernum'])) {$sn=$_REQUEST['sernum']; if ($sn == 'Введите и нажмите Enter') {$sn = '';}} else {$sn = '';}
	 
if (($identify_tov <> '') && (($sn == '')))  {
printf("<select name='serialn'>");
$result_tov = mysql_query("SELECT DISTINCT `ID_tovara` FROM `shtrihkod` WHERE `shtrih` = '$identify_tov'",$db);

if (mysql_num_rows($result_tov) > 0) {

$myrow_tov = mysql_fetch_array($result_tov);

if ($kat_id <> '') {
	
$result_sernum = mysql_query("SELECT `serial_number` FROM `serialnum` WHERE `ID_ketegorii` = '$kat_id' AND `ID_tovara` = '{$myrow_tov['ID_tovara']}' AND `ID_shtrihkoda` IN ( SELECT `ID` FROM `shtrihkod` WHERE `shtrih` = '$identify_tov' )",$db);

if (mysql_num_rows($result_sernum) > 0) {
	printf("<option value=''>Выберите серийный номер</option>");
	while($myrow_sernum = mysql_fetch_array($result_sernum)) {
		printf ("<option value='%s'>%s</option>" , $myrow_sernum["serial_number"], $myrow_sernum["serial_number"]);
		}
	}
	else {printf ("<option value=''>Нет</option>");}

}

else {printf('<option value="">Нет записи о товаре в остатках</option>');}
}

else{printf('<option value="">Нет записи о товаре</option>');}
printf("</select><input type='hidden' name='serialn_hidden' value='Введите и нажмите Enter' id='input_sernum'>");
}

else {

printf('<input type="text" name="serialn" value="%s" id="input_sernum" onkeypress="javascript: keyinfo(event);">',$sn);	

}

}
?>