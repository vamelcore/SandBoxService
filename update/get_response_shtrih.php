<?php include ("../config.php");
$input = $_POST['input'];
//echo $input;

$res_ser = mysql_query("SELECT `ID_ketegorii`, `ID_tovara`, `ID_shtrihkoda` FROM `serialnum` WHERE `serial_number` = '$input'",$db);
if (mysql_num_rows($res_ser) > 0) {
	$myr_ser = mysql_fetch_array($res_ser);
	if ($myr_ser['ID_shtrihkoda'] > 0) {
		$res_shrih = mysql_query("SELECT `shtrih` FROM `shtrihkod` WHERE `ID` = '{$myr_ser['ID_shtrihkoda']}'",$db);
		if (mysql_num_rows($res_shrih) > 0) {
			$myr_shtrih = mysql_fetch_array($res_shrih);
			echo $myr_shtrih['shtrih'];
			}
		else {echo 'Ошибка: нет штрих-кода в таблице сейников!';}
		}
	else {
		echo 'ID'.$myr_ser['ID_ketegorii'].'_'.$myr_ser['ID_tovara'];
		}


}
else {echo 'Ошибка: нет серийника в таблице серийников!';}

?>