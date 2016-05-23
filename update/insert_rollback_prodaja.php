<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['rollpriv'] == 1)) {

	 if (isset($_POST['id_roll'])) {$id_roll = $_POST['id_roll']; if ($id_roll == '') {unset ($id_roll);}}		   
	 if (isset($_POST['sdata'])) {$sdata = $_POST['sdata']; if ($sdata == '') {unset ($sdata);}}
     if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
     if (isset($_POST['magazine_name'])) {$magazine_name = $_POST['magazine_name']; if ($magazine_name == '') {unset ($magazine_name);}}
     if (isset($_POST['kategory'])) {$kategory = $_POST['kategory']; if ($kategory == '') {unset ($kategory);}}
     if (isset($_POST['tovar'])) {$tovar = $_POST['tovar']; if ($tovar == '') {unset ($tovar);}}
	 if (isset($_POST['voznag_za_jelezo'])) {$voznag_za_jelezo = $_POST['voznag_za_jelezo'];if ($voznag_za_jelezo == '') {unset ($voznag_za_jelezo);}}
     if (isset($_POST['serialn'])) {$serialn = $_POST['serialn']; if ($serialn == '') {unset ($serialn);}}
	 if (isset($_POST['shtrihkod'])) {$shtrihkod = $_POST['shtrihkod']; if ($shtrihkod == '') {unset ($shtrihkod);}}
     if (isset($_POST['stoimost'])) {$stoimost = $_POST['stoimost']; if ($stoimost == '') {unset ($stoimost);}}
     if (isset($_POST['operator'])) {$operator = $_POST['operator']; if ($operator == '') {unset($operator);} }
     if (isset($_POST['operator_schet'])) {$operator_schet = $_POST['operator_schet']; if ($operator_schet == '') {unset($operator_schet);} }
     if (isset($_POST['tarifplan'])) {$tarifplan = $_POST['tarifplan']; if ($tarifplan == '') {unset($tarifplan);}	  }
     if (isset($_POST['voznag_za_tp'])) {$voznag_za_tp = $_POST['voznag_za_tp'];if ($voznag_za_tp == '') {unset($voznag_za_tp);}}
     if (isset($_POST['oplata_tp_podkl'])) {$oplata_tp_podkl = $_POST['oplata_tp_podkl'];if ($oplata_tp_podkl == '') {unset($oplata_tp_podkl);}}
	 if (isset($_POST['skidka'])) {$skidka = $_POST['skidka'];if ($skidka == '') {unset($skidka);}}
     if (isset($_POST['user'])) {$user = $_POST['user'];if ($user == '') {unset($user);}}
	 if (isset($_POST['user_id'])) {$user_id = $_POST['user_id'];if ($user_id == '') {unset($user_id);}}
	 if (isset($_POST['sebestoim'])) {$sebestoim = $_POST['sebestoim'];if ($sebestoim == '') {unset($sebestoim);}}
	  
   if (isset($_POST['ID_sklada'])) {$ID_sklada = $_POST['ID_sklada'];if ($ID_sklada == '') {unset($ID_sklada);}}
   if (isset($_POST['Kol_na_sklade'])) {$Kol_na_sklade = $_POST['Kol_na_sklade'];if ($Kol_na_sklade == '') {unset($Kol_na_sklade);}}
   if (isset($_POST['Add_sklad'])) {$Add_sklad = $_POST['Add_sklad'];if ($Add_sklad == '') {unset($Add_sklad);}}
   if (isset($_POST['Kassa'])) {$Kassa = $_POST['Kassa'];if ($Kassa == '') {unset($Kassa);}}
   if (isset($_POST['Beznal'])) {$Beznal = $_POST['Beznal'];if ($Beznal == '') {unset($Beznal);}}
   if (isset($_POST['Schet_op'])) {$Schet_op = $_POST['Schet_op'];if ($Schet_op == '') {unset($Schet_op);}}
   if (isset($_POST['Zarplata'])) {$Zarplata = $_POST['Zarplata'];if ($Zarplata == '') {unset($Zarplata);}}
		
//echo "ID_ROLL ".$id_roll."<br>";
//echo "DATA ".$data."<br>";
//echo "MAG ".$magazine."<br>";
//echo "MAG_NAME ".$magazine_name."<br>";
//echo "KAT ".$kategory."<br>";
//echo "TOV ".$tovar."<br>";
//echo "VOZNAG_J ".$voznag_za_jelezo."<br>";
//echo "SERIALN ".$serialn."<br>";
//echo "STOIM ".$stoimost."<br>";
//echo "OP ".$operator."<br>";
//echo "TARP ".$tarifplan."<br>";
//echo "VOZNAG_TP ".$voznag_za_tp."<br>";
//echo "OPL_TP ".$oplata_tp_podkl."<br>";
//echo "SKIDKA ".$skidka."<br>";
//echo "USER ".$user."<br>";
//echo "ID_sklada ".$ID_sklada."<br>";
//echo "Kol_na_sklade ".$Kol_na_sklade."<br>";
//echo "Add_sklad ".$Add_sklad."<br>";
//echo "Kassa ".$Kassa."<br>";
//echo "Schet_op ".$Schet_op."<br>";
//echo "Zarplata ".$Zarplata."<br>";
//die();		

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));
$data = $dat.' '.$vremya;
$sys_data = strtotime($data);

if ((isset($ID_sklada)) && (isset($Kol_na_sklade))) {
	$Kol_na_sklade++;
$res_sklad=mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '+1', data_posl_prihoda = '$dat $vremya', kolichestvo = '$Kol_na_sklade' WHERE ID = '$ID_sklada' ",$db);

$res_arch_sklad=mysql_query("INSERT INTO prihodu SET data = '$dat $vremya', ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_prihoda = '+1', primech = 'Отмена продажи', user = '{$_SESSION['login']}', sec_data = '$sec_dat'",$db);
} else {
	if ((isset($Add_sklad)) && ($Add_sklad == 'true')) {
$res_sklad=mysql_query("INSERT INTO sklad_tovaru SET ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_posl_prihoda = '+1', data_posl_prihoda = '$dat $vremya', kolichestvo = '1'",$db);

$res_arch_sklad=mysql_query("INSERT INTO prihodu SET data = '$dat $vremya', ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_prihoda = '+1', primech = 'Отмена продажи', user = '{$_SESSION['login']}', sec_data = '$sec_dat'",$db);	
		}	
	}

if (isset($shtrihkod)) {
$res_shtrihkod = mysql_query("INSERT INTO shtrihkod SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', shtrih = '$shtrihkod'",$db);
$res_id_shtrihkod = mysql_query("SELECT MAX(ID) AS `ID` FROM shtrihkod",$db);
$myr_id_shtrihkod = mysql_fetch_array($res_id_shtrihkod, MYSQL_ASSOC);
}

if (isset($serialn)) {
	if (isset($myr_id_shtrihkod['ID'])) {
		$res_serialnum = mysql_query("INSERT INTO serialnum SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', ID_shtrihkoda = '{$myr_id_shtrihkod['ID']}', serial_number = '$serialn'",$db);
		}
	else {
		$res_serialnum = mysql_query("INSERT INTO serialnum SET ID_ketegorii = '$kategory', ID_tovara = '$tovar', ID_shtrihkoda = '0', serial_number = '$serialn'",$db);
		}
}
	
if (isset($Zarplata)) {

$res_max_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '$user_id' ORDER BY `ID` DESC LIMIT 1");
$myr_max_zap = mysql_fetch_array($res_max_zap);	
$max_zap = $myr_max_zap['k_oplate'] - $Zarplata;	
		
$res_zar = mysql_query("INSERT INTO zarplata SET ID_magazina = '$magazine', ID_usera = '$user_id', data = '$dat', vremya = '$vremya', polniy_den = '----', polov_dnya = '----', voznag_za_tp = '----', prodaja = '----', k_oplate = '$max_zap',vudano = '0', shtraf = '$Zarplata', bonus = '0', user = '{$_SESSION['login']}: Отмена продажи'",$db);
}

if (isset($Kassa)) {

$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '$magazine_name' ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_vkasse = mysql_fetch_array($res_vkasse);
$summa_vkasse = $myr_vkasse['vkasse'] - $Kassa;

$res_kassa = mysql_query("INSERT INTO kassa SET data = '$dat $vremya', magazine = '$magazine_name', vkasse = '$summa_vkasse', inkas = '-$Kassa', user = '{$_SESSION['login']}: Отмена продажи', sec_data = '$sec_dat'",$db);
}


////////////////////////////////BEZNAL!!!!!!!!!!!!!



if (isset($Beznal)) {

$res_beznal = mysql_query("SELECT `summa` FROM `beznal` WHERE `ID_scheta` = '1' ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_beznal = mysql_fetch_array($res_beznal);
$summa_beznal = $myr_beznal['summa'] - $Beznal;

$res_beznal = mysql_query("INSERT INTO beznal SET ID_scheta = '1', ID_prodaja = '0', data = '$dat $vremya', magazine = '$magazine_name', summa = '$summa_beznal', izmenenie = '-$Beznal', user = '{$_SESSION['login']}: Отмена продажи'",$db);
}



////////////////////////////////BEZNAL!!!!!!!!!!!!!



if (isset($sebestoim) && ($sebestoim > 0)) {
$res_sebes = mysql_query("INSERT INTO sebestoim SET ID_magazina = '$magazine', ID_tovara = '$tovar', kolichestvo = '1', sebestoimost = '$sebestoim', data = '$dat $vremya', sys_data = '$sys_data'",$db);
}

if (isset($Schet_op)){

$op_schet = $operator_schet + $Schet_op;
$res_rah_update = mysql_query("UPDATE operatoru SET schet = '$op_schet' WHERE ID = '$operator'",$db);


$res_max_id_ot = mysql_query("SELECT MAX(ID) AS `ID` FROM otchet",$db);
$myr_max_id_ot = mysql_fetch_array($res_max_id_ot);

$res_max_id_rh = mysql_query("SELECT MAX(ID) AS `ID` FROM rahunok",$db);
$myr_max_id_rh = mysql_fetch_array($res_max_id_rh);

$rahunok = $op_schet.' (+'.$Schet_op.')';

if ($myr_max_id_ot['ID'] <= $myr_max_id_rh['ID']) {
$res_rah = mysql_query("INSERT INTO rahunok SET ID = '{$myr_max_id_rh['ID']}'+1, date = '$dat', ID_operatora = '$operator', rahunok = '$rahunok', sec_data = '$sec_dat', user = '{$_SESSION['login']}: Отмена продажи'",$db);
$autoinc = $myr_max_id_rh['ID'] + 2;
$res_alert = mysql_query("ALTER TABLE otchet AUTO_INCREMENT = $autoinc",$db);	
}
else {
$res_rah = mysql_query("INSERT INTO rahunok SET ID = '{$myr_max_id_ot['ID']}'+1, date = '$dat', ID_operatora = '$operator', rahunok = '$rahunok', sec_data = '$sec_dat', user = '{$_SESSION['login']}: Отмена продажи'",$db);
$autoinc = $myr_max_id_ot['ID'] + 2;
$res_alert = mysql_query("ALTER TABLE otchet AUTO_INCREMENT = $autoinc",$db);
}

$res_otchet = mysql_query("UPDATE otchet SET fio = '----', nomer_abon = '----', kontakt_nomer = '----', paket = '----', kluch_evdo = '----', oborudov = 'Отмена продажи' WHERE ID_prodaja = '$id_roll'",$db);

}

//$res = mysql_query("DELETE FROM prodaja WHERE ID='$id'",$db); unset ($_POST['delete']);

$data = $sdata.'_rollback';
$res=mysql_query("UPDATE prodaja SET `add` = 'Отмена прадажи!', sec_data = '$data' WHERE ID='$id_roll'",$db);	

header("Location: ../prodaja.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>