<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
if (isset($_SESSION['id_tovara'])) {
		
	$id = $_SESSION['id_tovara'];
	unset ($_SESSION['id_tovara']);
    if ($id == '') {unset ($id);}

$_POST=defender_xss_min($_POST);    
$_POST=defender_sql($_POST);    
    
      if (isset($_POST['from_mag'])) {$from_mag = $_POST['from_mag']; if ($from_mag == '') {unset ($from_mag);}}
      if (isset($_POST['to_mag'])) {$to_mag = $_POST['to_mag']; if ($to_mag == '') {unset ($to_mag);}}
      if (isset($_POST['kategorya'])) {$kategorya = $_POST['kategorya'];if ($kategorya == '') {unset ($kategorya);}}
      if (isset($_POST['name_tovar'])) {$name_tovar = $_POST['name_tovar'];if ($name_tovar == '') {unset ($name_tovar);}}
      if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);}}
	  
	  if (isset($_POST['from_mag_name'])) {$from_mag_name = $_POST['from_mag_name']; if ($from_mag_name == '') {unset ($from_mag_name);}}
	  if (isset($_POST['kategorya_name'])) {$kategorya_name = $_POST['kategorya_name']; if ($kategorya_name == '') {unset ($kategorya_name);}}
	  if (isset($_POST['tovar_name'])) {$tovar_name = $_POST['tovar_name']; if ($tovar_name == '') {unset ($tovar_name);}}

$hours = date('H') + $_SESSION['time_zone'];
$data = date ('d.m.Y H:i:s',mktime ($hours));
$sec_data = date ('m.Y',mktime ($hours));
$sys_data = strtotime($data);

//$result_kat = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '$kategorya'",$db);
//$myrow_kat = mysql_fetch_array($result_kat);

//$result_mag_from = mysql_query("SELECT `name` FROM magazinu WHERE ID = '$from_mag'",$db);
//$myrow_mag_from = mysql_fetch_array($result_mag_from);

$result_mag_to = mysql_query("SELECT `name` FROM magazinu WHERE ID = '$to_mag'",$db);
$myrow_mag_to = mysql_fetch_array($result_mag_to);

//$result_tov = mysql_query("SELECT `tovar` FROM prase WHERE ID = '$name_tovar'",$db);
//$myrow_tov = mysql_fetch_array($result_tov);

$res_per=mysql_query("INSERT INTO peremeschenie SET data = '$data', kateg = '$kategorya_name', tovar = '$tovar_name', kolichestvo = '$kolichestvo', peremescheno_otkuda = '$from_mag_name', peremescheno_kuda = '{$myrow_mag_to['name']}', sec_data = '$sec_data'",$db);		


$result = mysql_query("SELECT * FROM sklad_tovaru WHERE `ID_magazina` = '{$to_mag}'",$db);
$myrow = mysql_fetch_array($result);
	 
unset($flag);
do { 
if ( ($myrow['ID_kategorii'] == $kategorya) && ($myrow['ID_tovara'] == $name_tovar)) { $flag=$myrow['ID'];}
}
while($myrow = mysql_fetch_array($result));

$result_old = mysql_query("SELECT `kolichestvo` FROM sklad_tovaru WHERE `ID` = '$id'",$db);
$myrow_old = mysql_fetch_array($result_old); 
$myrow_old['kolichestvo'] = $myrow_old['kolichestvo'] - $kolichestvo;
$kol_pos_prihoda = '-'.$kolichestvo;
$result_old=mysql_query("UPDATE sklad_tovaru SET kolichestvo = '{$myrow_old['kolichestvo']}', kol_posl_prihoda = '$kol_pos_prihoda', data_posl_prihoda = '$data' WHERE `ID` = '$id'",$db);

if (isset($flag)) {

$result_new = mysql_query("SELECT `kolichestvo` FROM sklad_tovaru WHERE `ID` = '{$flag}'",$db);
$myrow_new = mysql_fetch_array($result_new); 
$myrow_new['kolichestvo'] = $myrow_new['kolichestvo'] + $kolichestvo;
$kol_pos_prihoda = '+'.$kolichestvo;
$result_new=mysql_query("UPDATE sklad_tovaru SET kolichestvo = '{$myrow_new['kolichestvo']}', kol_posl_prihoda = '$kol_pos_prihoda', data_posl_prihoda = '$data' WHERE `ID` = '{$flag}'",$db);

}
else {

$kol_pos_prihoda = '+'.$kolichestvo;	
$res=mysql_query("INSERT INTO sklad_tovaru SET ID_magazina = '$to_mag', ID_kategorii = '$kategorya', ID_tovara = '$name_tovar', kol_posl_prihoda = '$kol_pos_prihoda', data_posl_prihoda = '$data', kolichestvo = '$kolichestvo'",$db);		
}
//Добавление записи в архив
$res_arch=mysql_query("INSERT INTO prihodu SET data = '$data', ID_magazina = '$from_mag', ID_kategorii = '$kategorya', ID_tovara = '$name_tovar', kol_prihoda = '-$kolichestvo', primech = 'Перемещение товара из магазина', user = '{$_SESSION['login']}', sec_data = '$sec_data'",$db);	

$res_arch=mysql_query("INSERT INTO prihodu SET data = '$data', ID_magazina = '$to_mag', ID_kategorii = '$kategorya', ID_tovara = '$name_tovar', kol_prihoda = '+$kolichestvo', primech = 'Перемещение товара в магазин', user = '{$_SESSION['login']}', sec_data = '$sec_data'",$db);











//себестоимость!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
$res_sebestoim = mysql_query("SELECT * FROM sebestoim WHERE ID_magazina = '$from_mag' AND ID_tovara = '$name_tovar' ORDER BY ID ASC",$db);
if (mysql_num_rows($res_sebestoim) > 0) {

$sebes_kolich = $kolichestvo;

while ($myr_sebestoim = mysql_fetch_array($res_sebestoim)) {

if ($sebes_kolich > 0) {
if ($sebes_kolich >= $myr_sebestoim['kolichestvo']) {
$res_sebest_update = mysql_query("UPDATE sebestoim SET ID_magazina = '$to_mag' WHERE ID ='{$myr_sebestoim['ID']}'",$db);
$sebes_kolich = $sebes_kolich - $myr_sebestoim['kolichestvo'];
}
else {
$new_sebes_kolich = $myr_sebestoim['kolichestvo'] - $sebes_kolich;
$res_sebest_update = mysql_query("UPDATE sebestoim SET kolichestvo = '$new_sebes_kolich' WHERE ID ='{$myr_sebestoim['ID']}'",$db);
$res_sebest_update = mysql_query("INSERT INTO sebestoim SET ID_magazina = '$to_mag', ID_tovara = '$name_tovar', kolichestvo = '$sebes_kolich', sebestoimost = '{$myr_sebestoim['sebestoimost']}', data = '$data', sys_data = '$sys_data'",$db);
$sebes_kolich = 0;
}
}
}
}













}

header("Location: ../sklad.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>