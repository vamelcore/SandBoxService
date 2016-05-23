<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);		
//Получение всех переменных.			
      if (isset($_POST['magazine'])) {
      		
      $magazine = $_POST['magazine'];
      if ($magazine == '') {unset ($magazine);}
	  $res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazine'",$db);
	  $myr_mag=mysql_fetch_array($res_mag);
	  }

      if (isset($_POST['data_priema'])) {$data_priema = $_POST['data_priema'];if ($data_priema == '') {unset ($data_priema);}}
      if (isset($_POST['t_a'])) {$t_a = $_POST['t_a'];if ($t_a == '') {unset ($t_a);}}
      if (isset($_POST['kategory'])) {
	  
	  $kategory = $_POST['kategory'];
	  if ($kategory == '') {unset($kategory);}
	  $res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
	  $myr_kat = mysql_fetch_array($res_kat);
	  }
	  
      if (isset($_POST['naimenovanie'])) {$naimenovanie = $_POST['naimenovanie'];if ($naimenovanie == '') {unset($naimenovanie);}}
      if (isset($_POST['esn'])) {$esn = $_POST['esn'];if ($esn == '') {unset($esn);}}
	  if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset($kolichestvo);}}
	  if (isset($_POST['data_pokupki'])) {$data_pokupki = $_POST['data_pokupki'];if ($data_pokupki == '') {unset($data_pokupki);}}
	  if (isset($_POST['summanal'])) {$summanal = $_POST['summanal'];if ($summanal == '') {unset ($summanal);}}
      if (isset($_POST['summabeznal'])) {$summabeznal = $_POST['summabeznal'];if ($summabeznal == '') {unset($summabeznal);}}
      if (isset($_POST['prichina_vozv'])) {$prichina_vozv = $_POST['prichina_vozv'];if ($prichina_vozv == '') {unset($prichina_vozv);}}
      if (isset($_POST['per14dn'])) {$per14dn = $_POST['per14dn'];if ($per14dn == '') {unset($per14dn);}}
	  if (isset($_POST['obmen'])) {
	  	
	    $obmen = $_POST['obmen'];
	    if ($obmen == '') {unset($obmen);} else {
	    	if ($obmen == '0') {$myr_obm['tovar']='Возврат денег';} else {
	    		$res_obm=mysql_query("SELECT `tovar` FROM prase WHERE ID = '$obmen'",$db);
	            $myr_obm=mysql_fetch_array($res_obm);
	    	}
	    }	  
	  }
	  if (isset($_POST['daln_dvizhen'])) {$daln_dvizhen = $_POST['daln_dvizhen'];if ($daln_dvizhen == '') {unset($daln_dvizhen);}}
	  if (isset($_POST['primechanie'])) {$primechanie = $_POST['primechanie'];if ($primechanie == '') {unset($primechanie);}}
      if (isset($_POST['user'])) {$user = $_POST['user'];if ($user == '') {unset($user);}}
if (isset($_POST['voznag_za_jelezo'])) {$voznag_za_jelezo = $_POST['voznag_za_jelezo'];if ($voznag_za_jelezo == '') {$voznag_za_jelezo='0';}}
if (isset($_POST['voznag_za_tp'])) {$voznag_za_tp = $_POST['voznag_za_tp'];if ($voznag_za_tp == '') {$voznag_za_tp='0';}}
if (isset($_POST['procent_pr'])) {$procent_pr = $_POST['procent_pr'];if ($procent_pr == '') {$procent_pr='0';}}
if (isset($_POST['oplata_tp_podkluchenie'])) {$oplata_tp_podkluchenie = $_POST['oplata_tp_podkluchenie'];if ($oplata_tp_podkluchenie == '') {unset($oplata_tp_podkluchenie);}}
if (isset($_POST['ID_prodaja'])) {$ID_prodaja = $_POST['ID_prodaja'];if ($ID_prodaja == '') {unset($ID_prodaja);}}
if (isset($_POST['skidka'])) {$skidka = $_POST['skidka'];if ($skidka == '') {unset($skidka);}}
if (isset($_POST['kto_pvinyal'])) {$kto_pvinyal = $_POST['kto_pvinyal'];if ($kto_pvinyal == '') {unset($kto_pvinyal);}}
if (isset($_POST['sec_data'])) {$second_data = $_POST['sec_data'];if ($second_data == '') {unset($second_data);}}
if (isset($_POST['sebestoim'])) {$sebestoim = $_POST['sebestoim'];if ($sebestoim == '') {unset($sebestoim);}}
if (isset($_POST['abon_ispolz_tp'])) {$abon_ispolz_tp = $_POST['abon_ispolz_tp'];if ($abon_ispolz_tp == '') {unset($abon_ispolz_tp);}}	  
		
if (isset($_SESSION['id_vozvrat'])) {
	
	 if ($_SESSION['ed_priv_voz'] == 1) {
		
	$id = $_SESSION['id_vozvrat'];
	unset ($_SESSION['id_vozvrat']);
    if ($id == '') {unset ($id);}
//Удаление записи в возвратах!!!    
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM vozvratu WHERE ID='$id'",$db); unset ($_POST['delete']);}

     else {
//Обновление записи
      $res=mysql_query("UPDATE vozvratu SET magazin = '{$myr_mag['name']}', data = '$data_priema', t_a = '$t_a', kategoria = '$kategory', naimenovanie = '$naimenovanie', esn = '$esn', kolichestvo = '$kolichestvo', data_pokupki_vozvr_ob = '$data_pokupki', summa_nal = '$summanal', summa_bez_nal = '$summabeznal', prichina_vozvrata = '$prichina_vozv', per_14_dney = '$per14dn', obmen_na = '$obmen', daln_dvijenie_vozvr_tov = '$daln_dvizhen', primechanie = '$primechanie', kto_pvinyal = '$kto_pvinyal' WHERE ID='$id'",$db);
	$sec_dat = $second_data;
	$ind = $id;
}
}
}
else {
	
  if ($_SESSION['add_priv_voz'] == 1) {
	
$hours = date('H') + $_SESSION['time_zone'];
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours)); 
$sec_dat = date ('m.Y', mktime ($hours));
$data = $dat.' '.$vremya;
$sys_data = strtotime($data);
//Добавление новой записи в таблице возвратов
$res=mysql_query("INSERT INTO vozvratu SET magazin = '{$myr_mag['name']}', data = '$data_priema', t_a = '$t_a', kategoria = '$kategory', naimenovanie = '$naimenovanie', esn = '$esn', kolichestvo = '$kolichestvo', data_pokupki_vozvr_ob = '$data_pokupki', summa_nal = '$summanal', summa_bez_nal = '$summabeznal', sebestoim = '$sebestoim', prichina_vozvrata = '$prichina_vozv', per_14_dney = '$per14dn', obmen_na = '{$myr_obm['tovar']}', daln_dvijenie_vozvr_tov = '$daln_dvizhen', primechanie = '$primechanie', sec_data = '$sec_dat', kto_pvinyal = '$kto_pvinyal'",$db);
//Получение зарплатной информации о предыдущем продавце
$res_usr = mysql_query("SELECT `ID`, `bonus_stavka`, `proc_stavka` FROM users WHERE login = '$user'",$db);
$myr_usr = mysql_fetch_array($res_usr);

$res_max_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '{$myr_usr['ID']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_max_zap = mysql_fetch_array($res_max_zap);

//Определение суммы изьятой у продавца после возврата
if ((isset($abon_ispolz_tp)) && ($abon_ispolz_tp == 'yes')) {$vozvrat_voznag_tp = 0;} else {$vozvrat_voznag_tp = $voznag_za_tp;}

$shtraff_zap = $myr_max_zap['k_oplate'];
$myr_max_zap['k_oplate'] = round(($shtraff_zap - $voznag_za_jelezo - $vozvrat_voznag_tp - $procent_pr), 2);
//Определение того будет ли Возврат денег, в случае которого сохранить идентификатор продажи
if ($obmen == '0') {$set_prod_id = $ID_prodaja;} else {$set_prod_id = 0;}
//Обновление зарплатной информации предыдущего продавца
$res_zar = mysql_query("INSERT INTO zarplata SET ID_prodaja = '$set_prod_id', ID_magazina = '$magazine', ID_usera = '{$myr_usr['ID']}', data = '$dat', vremya = '$vremya', polniy_den = '----', polov_dnya = '----', voznag_za_tp = '-$vozvrat_voznag_tp', prodaja = '-$voznag_za_jelezo', procent = '-$procent_pr', k_oplate = '{$myr_max_zap['k_oplate']}',vudano = '----', shtraf = '----', bonus = '----', user = '{$_SESSION['login']}: Возврат!'",$db);

//Получение текущей информации о кассе магазина
$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse = mysql_fetch_array($res_vkasse);

//Рассчет кассы и ее обновление
$summa_vkasse = $myr_vkasse['vkasse'] - $summanal + $summabeznal;
$summa_inkass = $summanal - $summabeznal;

$res_kassa = mysql_query("INSERT INTO kassa SET ID_prodaja = '0', data = '$dat $vremya', magazine = '{$myr_mag['name']}', vkasse = '$summa_vkasse', inkas = '-$summa_inkass', `user` = '{$_SESSION['login']}: Возврат!', sec_data = '$sec_dat'",$db);


//Если был выбран обмен
if ((isset($obmen)) && ($obmen <> '0')) {

//Находится товар из таблицы товаров
$res_tov_obm_diff = mysql_query("SELECT `new_cena`, `new_bonus` FROM `diff_cena` WHERE `ID_magazina` = '$magazine' AND `ID_tovara` = '$obmen'",$db);
if (mysql_num_rows($res_tov_obm_diff) > 0) {
$myr_tov_obm_diff = mysql_fetch_array($res_tov_obm_diff);
$myr_tov = array();
$myr_tov['cena'] = $myr_tov_obm_diff['new_cena'];
$myr_tov['voznag'] = $myr_tov_obm_diff['new_bonus'];
}
else {
$res_tov = mysql_query("SELECT `cena`, `voznag` FROM `prase` WHERE `ID` = '$obmen'",$db);
$myr_tov = mysql_fetch_array($res_tov);
}


//себестоимость!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
$res_sebestoim = mysql_query("SELECT * FROM sebestoim WHERE ID_magazina = '$magazine' AND ID_tovara = '$obmen' ORDER BY ID ASC",$db);
if (mysql_num_rows($res_sebestoim) > 0) {

$sebes_flag = false;

while ($myr_sebestoim = mysql_fetch_array($res_sebestoim)) {

if ($sebes_flag == false) {
if ($myr_sebestoim['kolichestvo'] > 0) {
$sebestoimost = $myr_sebestoim['sebestoimost'];
$myr_sebestoim['kolichestvo'] = $myr_sebestoim['kolichestvo'] - 1;
$sebes_flag = true;
$res_sebest_update = mysql_query("UPDATE sebestoim SET kolichestvo = '{$myr_sebestoim['kolichestvo']}' WHERE ID ='{$myr_sebestoim['ID']}'",$db);
}
}

if ($myr_sebestoim['kolichestvo'] == 0) {$res_sebest_update = mysql_query("DELETE FROM sebestoim WHERE ID ='{$myr_sebestoim['ID']}'",$db);}

}
}
else {$sebestoimost = '0';}


//Находится зарплатная информация о новом продавце
$res_usr_new = mysql_query("SELECT `bonus_stavka`, `proc_stavka` FROM users WHERE ID = '{$_SESSION['user_id']}'",$db);
$myr_usr_new = mysql_fetch_array($res_usr_new);
//Рассчет зарплаты для нового продавца
if ($myr_usr_new['bonus_stavka'] == 1) {$bonus_zp = $myr_tov['voznag'] + $voznag_za_tp; $bonus_jelezo = $myr_tov['voznag']; $bonus_tp = $voznag_za_tp;}	else {$bonus_zp = 0; $bonus_jelezo = 0; $bonus_tp = 0;}
$proc_zp_new = round((($myr_tov['cena'] - $skidka)*($myr_usr_new['proc_stavka']/100)), 2);
//Определение максимального идентификатора таблицы продаж
$res_max_pro = mysql_query("SELECT MAX(ID) AS `ID` FROM prodaja",$db);
$myr_max_pro = mysql_fetch_array($res_max_pro, MYSQL_ASSOC);

$max_pro_id = $myr_max_pro['ID'] + 1;
//Обновление продажи в соответствии с обменом на новый товар
$res_pro = mysql_query("UPDATE `prodaja` SET data = '$data_priema', naimenovanie = '{$myr_obm['tovar']}', voznag_za_jelezo = '$bonus_jelezo', stoimost = '{$myr_tov['cena']}', procent_prod = '$proc_zp_new', skidka = '$skidka', `sebestoimost` = '$sebestoimost', `add` = 'Этот товар был выдан на замену $naimenovanie который был продан $data_pokupki', sec_data = '$sec_dat', ID = '$max_pro_id', `user` = '{$_SESSION['login']}' WHERE ID = '$ID_prodaja'",$db);

//Обновляем АВТО_ИНКРЕМЕНТ для таблицы с движном InnoDB так как MyISAM это делал автоматом
$new_auto_inc = $max_pro_id + 1;
$res_pro_autoincrement = mysql_query("ALTER TABLE `prodaja` AUTO_INCREMENT = $new_auto_inc",$db);

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
//$myr_kat=mysql_fetch_array($res_kat);
	
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM sklad_tovaru WHERE ID_magazina = '$magazine' AND ID_kategorii = '{$myr_kat['ID']}' AND ID_tovara = '$obmen'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);

$myr_sklad['kolichestvo']=$myr_sklad['kolichestvo'] - 1;
$res_sklad=mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '-1', data_posl_prihoda = '$data_priema', kolichestvo = '{$myr_sklad['kolichestvo']}' WHERE ID = '{$myr_sklad['ID']}' ",$db);

//Добавление записи в архив склада
$osnatok_archiv='-1 ('.$myr_sklad['kolichestvo'].')';
$res_arch_sklad=mysql_query("INSERT INTO prihodu SET data = '$data_priema', ID_magazina = '$magazine', ID_kategorii = '{$myr_kat['ID']}', ID_tovara = '$obmen', kol_prihoda = '$osnatok_archiv', primech = 'Обмен!', user = '{$_SESSION['login']}', sec_data = '$sec_dat'",$db);
//Обновление зарплаты нового продавца
$res_max_zap_new = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '{$_SESSION['user_id']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_max_zap_new = mysql_fetch_array($res_max_zap_new);	

$myr_max_zap_new['k_oplate'] = $myr_max_zap_new['k_oplate'] + $bonus_zp + $proc_zp_new;

$res_zar_new = mysql_query("INSERT INTO zarplata SET ID_prodaja = '$max_pro_id', ID_magazina = '$magazine', ID_usera = '{$_SESSION['user_id']}', data = '$dat', vremya = '$vremya', polniy_den = '----', polov_dnya = '----', voznag_za_tp = '$bonus_tp', prodaja = '$bonus_jelezo', procent = '$proc_zp_new', k_oplate = '{$myr_max_zap_new['k_oplate']}',vudano = '----', shtraf = '----', bonus = '----', user = '----'",$db);
//Обновление информации о статой (уже несуществующей) продаже в таблице зарплат.
$res_zar_old_pro = mysql_query("UPDATE zarplata SET ID_prodaja = '0' WHERE ID_prodaja = '$ID_prodaja'",$db);
//Обновление кассы магазина
$res_vkasse_new = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse_new = mysql_fetch_array($res_vkasse_new);

$summa_vkasse = $myr_vkasse_new['vkasse'] + $myr_tov['cena'] - $skidka;
$summa_inkass = $myr_tov['cena'] - $skidka;
$res_kassa_new = mysql_query("INSERT INTO kassa SET `ID_prodaja` = '$max_pro_id', data = '$dat $vremya', magazine = '{$myr_mag['name']}', vkasse = '$summa_vkasse', inkas = '+$summa_inkass', `user` = '{$_SESSION['login']}: Обмен!', sec_data = '$sec_dat'",$db);

	
}
else { if ($obmen == '0'){
$res_secdata=mysql_query("SELECT sec_data FROM prodaja WHERE ID='$ID_prodaja'",$db);
$myr_secdata=mysql_fetch_array($res_secdata);
$new_sec_data = $myr_secdata['sec_data'].'_rollback';
$res_secdata=mysql_query("UPDATE prodaja SET `add` = 'Возврат денег за товар!', sec_data = '$new_sec_data' WHERE ID='$ID_prodaja'",$db);
}}


  $res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM vozvratu",$db);
	$myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);
	$ind = $myr_max['ID'];
}
}

if ($daln_dvizhen == 'Поставлен на приход') {
		
$res_prih = mysql_query("SELECT `flag` FROM vozvratu WHERE ID = '$ind'",$db);	
$myr_prih = mysql_fetch_array($res_prih);


if ($myr_prih['flag'] == 'false') {


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
//	$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
//	$myr_kat = mysql_fetch_array($res_kat);
			
	$res_tovar = mysql_query("SELECT `ID` FROM prase WHERE ID_kategorii = '{$myr_kat['ID']}' AND tovar ='$naimenovanie'",$db);
	
	if (mysql_num_rows($res_tovar) > 0) {$myr_tovar = mysql_fetch_array($res_tovar); $ind_tov = $myr_tovar['ID'];} else {
	    $result_tovar = mysql_query("INSERT INTO prase SET ID_kategorii = '{$myr_kat['ID']}', tovar ='$naimenovanie', cena ='$summanal', voznag = '----'",$db); 
		$res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM prase",$db);
	    $myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);
	    $ind_tov = $myr_max['ID'];	}

    $res_sklad = mysql_query("SELECT `ID`, `kolichestvo` FROM sklad_tovaru WHERE ID_magazina = '$magazine' AND ID_kategorii = '{$myr_kat['ID']}' AND ID_tovara = '$ind_tov'",$db); 
   	
	if (mysql_num_rows($res_sklad) > 0) { $myr_sklad = mysql_fetch_array($res_sklad); $kol = $myr_sklad['kolichestvo']+$kolichestvo; $result_sklad = mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '+$kolichestvo', data_posl_prihoda = '$data_priema', kolichestvo = '$kol' WHERE ID = '{$myr_sklad['ID']}'",$db);} 
else {$kol = $kolichestvo; $result_sklad = mysql_query("INSERT INTO sklad_tovaru SET ID_magazina = '$magazine', ID_kategorii = '{$myr_kat['ID']}', ID_tovara = '$ind_tov', kol_posl_prihoda = '+$kolichestvo', data_posl_prihoda = '$data_priema', kolichestvo = '$kolichestvo'",$db);}

//Добавление записи в архив склада
$kol_prihoda = '+'.$kolichestvo.' ('.$kol.')';
$res_arch_sklad=mysql_query("INSERT INTO prihodu SET data = '$data_priema', ID_magazina = '$magazine', ID_kategorii = '{$myr_kat['ID']}', ID_tovara = '$ind_tov', kol_prihoda = '$kol_prihoda', primech = 'Возврат!', user = '$kto_pvinyal', sec_data = '$sec_dat'",$db);

//возврат себестоимости
if (isset($sebestoim) && ($sebestoim > 0)) {
$res_sebes = mysql_query("INSERT INTO sebestoim SET ID_magazina = '$magazine', ID_tovara = '$ind_tov', kolichestvo = '$kolichestvo', sebestoimost = '$sebestoim', data = '$dat $vremya', sys_data = '$sys_data'",$db);
}

$res_prih = mysql_query("UPDATE vozvratu SET `flag`='true' WHERE ID = '$ind'",$db);	
}


}


header("Location: ../vozvratu.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>