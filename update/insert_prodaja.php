<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

//print_r($_POST); die();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
    

//Проверка масивов переменных.	
$_POST=defender_xss($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);


//Получение всех переменных.		
	  if (isset($_POST['data'])) {$data = $_POST['data']; if ($data == '') {unset ($data);}}
      if (isset($_POST['b'])) {$b = $_POST['b'];if ($b == '') {unset ($b);}}
      if (isset($_POST['magazine'])) {      		
      	$magazine = $_POST['magazine'];
      	if ($magazine == '') {unset ($magazine);}
		else {
	    $res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazine'",$db);
		$myr_mag=mysql_fetch_array($res_mag);		
		}
	  }
      if (isset($_POST['kategory'])) {      		
      	$kategory = $_POST['kategory'];
      	if ($kategory == '') {unset ($kategory);}
		else {
	    $res_kat=mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '$kategory'",$db);
		$myr_kat=mysql_fetch_array($res_kat);		
		}
	  }
      if (isset($_POST['tovar'])) {      		
      	$tovar = $_POST['tovar'];
      	if ($tovar == '') {unset ($tovar);}
		else {
	    $res_tov=mysql_query("SELECT `tovar` FROM prase WHERE ID = '$tovar'",$db);
		$myr_tov=mysql_fetch_array($res_tov);		
		}	  
	  }
          
          
	  if (isset($_POST['voznag_za_jelezo'])) {$voznag_za_jelezo = $_POST['voznag_za_jelezo']; if ($voznag_za_jelezo == '') {$voznag_za_jelezo = 0;}} else {$voznag_za_jelezo = 0;}
      if (isset($_POST['serialn'])) {
      	$serialn = $_POST['serialn'];
      	if ($serialn == '') {unset ($serialn);}
//		else {
//		$res_sn=mysql_query("SELECT `serial_number` FROM serialnum WHERE ID = '$serialn'",$db);
//		$myr_sn=mysql_fetch_array($res_sn);
//		}
	  }
      if (isset($_POST['stoimost'])) {$stoimost = $_POST['stoimost'];if ($stoimost == '') {$stoimost = 0;}} else {$stoimost = 0;}
      if (isset($_POST['operator'])) {      		
      	$operator = $_POST['operator'];
      	if ($operator == '') {unset($operator);}
		else {
      	$res_op=mysql_query("SELECT * FROM operatoru WHERE ID = '$operator'",$db);
		$myr_op=mysql_fetch_array($res_op);		
		}
      }
      if (isset($_POST['tarifplan'])) {      		
      	$tarifplan = $_POST['tarifplan'];
      	if ($tarifplan == '') {unset($tarifplan);}
		else {
	    $res_tp=mysql_query("SELECT `tarifplan` FROM tarifplan WHERE ID = '$tarifplan'",$db);
		$myr_tp=mysql_fetch_array($res_tp);		
		}	  
	  }
      if (isset($_POST['voznag_za_tp'])) {$voznag_za_tp = $_POST['voznag_za_tp'];if ($voznag_za_tp == '') {$voznag_za_tp = 0;}} else {$voznag_za_tp = 0;}
      if (isset($_POST['oplata_tp_podkl'])) {$oplata_tp_podkl = $_POST['oplata_tp_podkl'];if ($oplata_tp_podkl == '') {$oplata_tp_podkl = 0;}} else {$oplata_tp_podkl = 0;}
	  if (isset($_POST['kluch_evdo'])) {$kluch_evdo = $_POST['kluch_evdo'];if ($kluch_evdo == '') {unset($kluch_evdo);}}
	  if (isset($_POST['kontakt_nom_tel'])) {$kontakt_nom_tel = $_POST['kontakt_nom_tel'];if ($kontakt_nom_tel == '') {unset($kontakt_nom_tel);}}
	  if (isset($_POST['fio'])) {$fio = $_POST['fio'];if ($fio == '') {unset($fio);}}
	  if (isset($_POST['abon_nomer'])) {$abon_nomer = $_POST['abon_nomer'];if ($abon_nomer == '') {unset($abon_nomer);}}
	  if (isset($_POST['mesto_polz'])) {$mesto_polz = $_POST['mesto_polz'];if ($mesto_polz == '') {unset($mesto_polz);}}	  
	  if (isset($_POST['skidka'])) {$skidka = $_POST['skidka'];if ($skidka == '') {$skidka = 0;}}
	  if (isset($_POST['primech'])) {$primech = $_POST['primech'];if ($primech == '') {unset($primech);}}
	  
	  if (isset($_POST['user'])) {
	  	$user = $_POST['user'];
	  	if ($user == '') {unset($user);}
		else {
	  	$res_usr = mysql_query("SELECT `ID`, `login`, `bonus_stavka`, `proc_stavka` FROM `users` WHERE ID = '$user'",$db);
        $myr_usr = mysql_fetch_array($res_usr);		
		} 
	  }
   if (isset($_POST['akciya'])) {$akciya = $_POST['akciya'];} else {$akciya = '';}	
   
   if (isset($_POST['prnt_id'])) {$printer_id = $_POST['prnt_id']; if ($printer_id == '') {unset($printer_id);}}
   
   if (isset($_POST['sposob_oplatu'])) {$sposob_oplatu = $_POST['sposob_oplatu']; if ($sposob_oplatu == '') {$sposob_oplatu = 'no';}} else {$sposob_oplatu = 'no';}
   
   if (isset($_POST['shtrihkod'])) {$shtrihkod = $_POST['shtrihkod']; if (($shtrihkod == '') || ($shtrihkod == 'Не задан')) {unset($shtrihkod);}}




//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
clear_old_files();
$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$fname = '../log/error_log_prodaj '.$dat.'.txt';

if (isset($_SESSION['id_prodaja']) && isset($_POST['delete'])) {$informer = 'Удаление записи, мое время:'.$dat.'-'.$vremya;}
if (isset($_SESSION['id_prodaja']) && !isset($_POST['delete'])) {$informer = 'Редактирование записи, мое время:'.$dat.'-'.$vremya;}
if (!isset($_SESSION['id_prodaja']) && !isset($_POST['delete'])) {$informer = 'Добавление записи, мое время:'.$dat.'-'.$vremya;}

if (isset($data)) {$informer .= "/Дата:".$data;} else {$informer .= "/Дата:";}
if (isset($b)) {$informer .="/Тип:".$b;} else {$informer .="/Тип:";}
if (isset($magazine)) {$informer .="/ИД-магазина:".$magazine;} else {$informer .="/ИД-магазина:";}
if (isset($myr_mag['name'])) {$informer .="/Имя магазина:".$myr_mag['name'];} else {$informer .="/Имя магазина:";}
if (isset($kategory)) {$informer .="/ИД-категории:".$kategory;} else {$informer .="/ИД-категории:";}
if (isset($myr_kat['kateg'])) {$informer .="/Имя категории:".$myr_kat['kateg'];} else {$informer .="/Имя категории:";}
if (isset($tovar)) {$informer .="/ИД-товара:".$tovar;} else {$informer .="/ИД-товара:";}
if (isset($myr_tov['tovar'])) {$informer .="/Ноименование товара:".$myr_tov['tovar'];} else {$informer .="/Ноименование товара:";}
if (isset($voznag_za_jelezo)) {$informer .="/Вознаг за железо:".$voznag_za_jelezo;} else {$informer .="/Вознаг за железо:";}
if (isset($serialn)) {$informer .="/ИД-серийника:".$serialn;} else {$informer .="/ИД-серийника:";}
if (isset($shtrihkod)) {$informer .="/Штрих-код:".$shtrihkod;} else {$informer .="/Штрих-код:";}
if (isset($serialn)) {$informer .="/Серийный номер:".$serialn;} else {$informer .="/Серийный номер:";}
if (isset($stoimost)) {$informer .="/Стоемость железа:".$stoimost;} else {$informer .="/Стоемость железа:";}
if (isset($operator)) {$informer .="/ИД-оператора:".$operator;} else {$informer .="/ИД-оператора:";}
if (isset($myr_op['oper'])) {$informer .="/Имя оператора:".$myr_op['oper'];} else {$informer .="/Имя оператора:";}
if (isset($tarifplan)) {$informer .="/ИД-тариф плана:".$tarifplan;} else {$informer .="/ИД-тариф плана:";}
if (isset($myr_tp['tarifplan'])) {$informer .="/Тариф план:".$myr_tp['tarifplan'];} else {$informer .="/Тариф план:";}
if (isset($voznag_za_tp)) {$informer .="/Вознаг за тп:".$voznag_za_tp;} else {$informer .="/Вознаг за тп:";}
if (isset($oplata_tp_podkl)) {$informer .="/Оплата тп:".$oplata_tp_podkl;} else {$informer .="/Оплата тп:";}
if (isset($kluch_evdo)) {$informer .="/Ключ ЕВДО:".$kluch_evdo;} else {$informer .="/Ключ ЕВДО:";}
if (isset($kontakt_nom_tel)) {$informer .="/Контактн ном тел:".$kontakt_nom_tel;} else {$informer .="/Контактн ном тел:";}
if (isset($fio)) {$informer .="/ФИО:".$fio;} else {$informer .="/ФИО:";}
if (isset($abon_nomer)) {$informer .="/Абонентский номер:".$abon_nomer;} else {$informer .="/Абонентский номер:";}
if (isset($mesto_polz)) {$informer .="/Место пользования:".$mesto_polz;} else {$informer .="/Место пользования:";}
if (isset($skidka)) {$informer .="/Скидка:".$skidka;} else {$informer .="/Скидка:";}
if (isset($primech)) {$informer .="/Примечание:".$primech;} else {$informer .="/Примечание:";}
if (isset($user)) {$informer .="/ИД-пользователя:".$user;} else {$informer .="/ИД-пользователя:";}
if (isset($myr_usr['login'])) {$informer .="/Пользователь:".$myr_usr['login'];} else {$informer .="/Пользователь:";}
if (isset($myr_usr['bonus_stavka'])) {$informer .="/Бонус ставка:".$myr_usr['bonus_stavka'];} else {$informer .="/Бонус ставка:";}
if (isset($myr_usr['proc_stavka'])) {$informer .="/Процент ставка:".$myr_usr['proc_stavka'];} else {$informer .="/Процент ставка:";}
if (isset($akciya)) {$informer .="/Акция:".$akciya;} else {$informer .="/Акция:";}
if (isset($printer_id)) {$informer .="/ИД-принтера:".$printer_id;} else {$informer .="/ИД-принтера:";}
if (isset($sposob_oplatu)) {$informer .="/Способ оплаты:".$sposob_oplatu;} else {$informer .="/Способ оплаты:";}

$informer .="\n";

if (file_exists($fname)) {
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
}
else {
$fp = fopen($fname, 'a'); 
fwrite($fp, $informer); 
fclose($fp);
}

//mysql_select_db("nonexistentdb", $db);
//$informer = "Ошибка MySQL: ".mysql_errno($db).":".mysql_error($db)."\n";
//file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////


		
if (isset($_SESSION['id_prodaja'])) {
	
  if ($_SESSION['ed_priv_pro'] == 1) {	
		
	$id = $_SESSION['id_prodaja'];
	unset ($_SESSION['id_prodaja']);
    if ($id == '') {unset ($id);}
//Удаление записи о продаже!!!
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM prodaja WHERE ID='$id'",$db); unset ($_POST['delete']);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "ИД удаленной продажи: ".$id."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
	
}
     else {
//Обновление записи о продаже.
      $res=mysql_query("UPDATE prodaja SET data = '$data', b = '$b', magazin = '{$myr_mag['name']}', kategoria = '{$myr_kat['kateg']}', naimenovanie = '{$myr_tov['tovar']}', serialnum = '$serialn', shtrihkod = '$shtrihkod', voznag_za_jelezo = '$voznag_za_jelezo', stoimost = '$stoimost', operator = '$operator', tarifn_plan = '$tarifplan', voznag_za_tp = '$voznag_za_tp', oplata_tp_podkluchenie = '$oplata_tp_podkl', kluch_evdo = '$kluch_evdo', kontakt_nomer_tel = '$kontakt_nom_tel', fio = '$fio', abonent_nomer = '$abon_nomer', mesto_polz = '$mesto_polz', skidka = '$skidka', `add` = '$primech', `user` = '$user' WHERE ID='$id'",$db);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при редактировании записи о продаже: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
	
}
}
}
else {

if ($_SESSION['add_priv_pro'] == 1) {

if  ((isset($magazine)) && (isset($kategory)) && (isset($tovar))) {
//Получение информации о товаре на складе.
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM sklad_tovaru WHERE ID_magazina = '$magazine' AND ID_kategorii = '$kategory' AND ID_tovara = '$tovar'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);	
	}
//Если это подключение, принудительно присваиваем значение количества товара на складе равным 1
if (($b == 'Р') && (!isset($myr_sklad))) {$myr_sklad['kolichestvo'] = '1';}

if ($myr_sklad['kolichestvo'] > 0) {

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));



//Себестоимость
$res_sebestoim = mysql_query("SELECT * FROM sebestoim WHERE ID_magazina = '$magazine' AND ID_tovara = '$tovar' ORDER BY ID ASC",$db);
$sebestoimost = '0';
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

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL для себестоимости: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////



//Определение зарплаты продавца
if ($myr_usr['bonus_stavka'] == 1) {$bonus_zp = $voznag_za_jelezo + $voznag_za_tp; $bonus_jelezo = $voznag_za_jelezo; $bonus_tp = $voznag_za_tp;}	else {$bonus_zp = 0; $bonus_jelezo = 0; $bonus_tp = 0;}
if ($akciya <> 'true') {$proc_zp = round((($stoimost - $skidka)*($myr_usr['proc_stavka']/100)), 2);}
else {$proc_zp = '0';}

$myr_tov['tovar'] = addslashes($myr_tov['tovar']);

//Если количество товара на складе не 0, добавляем запись о продаже в базу.		
$res=mysql_query("INSERT INTO prodaja SET data = '$data', b = '$b', magazin = '{$myr_mag['name']}', kategoria = '{$myr_kat['kateg']}', naimenovanie = '{$myr_tov['tovar']}', serialnum = '$serialn', shtrihkod = '$shtrihkod', voznag_za_jelezo = '$bonus_jelezo', stoimost = '$stoimost', procent_prod = '$proc_zp', operator = '{$myr_op['oper']}', tarifn_plan = '{$myr_tp['tarifplan']}', voznag_za_tp = '$bonus_tp', oplata_tp_podkluchenie = '$oplata_tp_podkl', kluch_evdo = '$kluch_evdo', kontakt_nomer_tel = '$kontakt_nom_tel', fio = '$fio', abonent_nomer = '$abon_nomer', mesto_polz = '$mesto_polz', skidka = '$skidka', sebestoimost = '$sebestoimost', `add` = '$primech', `user` = '{$myr_usr['login']}', akciya = '$akciya', sposob_opl = '$sposob_oplatu', printer_ID = '$printer_id', sec_data = '$sec_dat'",$db);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при добавлении продажи: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

//Получаем Идентификатор текущей продажы
$res_max_prodaja = mysql_query("SELECT MAX(ID) AS `ID` FROM prodaja WHERE magazin = '{$myr_mag['name']}'",$db);
$myr_max_prodaja = mysql_fetch_array($res_max_prodaja, MYSQL_ASSOC);


//Обновляем количество товара на складе
$myr_sklad['kolichestvo']=$myr_sklad['kolichestvo'] - 1;
$res_sklad=mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '-1', data_posl_prihoda = '$data', kolichestvo = '{$myr_sklad['kolichestvo']}' WHERE ID = '{$myr_sklad['ID']}' ",$db);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при обновении количество товара на складе: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

//Добавление записи в архив склада
$osnatok_archiv='-1 ('.$myr_sklad['kolichestvo'].')';
$res_arch_sklad=mysql_query("INSERT INTO prihodu SET data = '$data', ID_magazina = '$magazine', ID_kategorii = '$kategory', ID_tovara = '$tovar', kol_prihoda = '$osnatok_archiv', primech = 'Продажа!', user = '{$myr_usr['login']}', sec_data = '$sec_dat'",$db);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при добавлении записи в архив склада: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

//Если был выбран серийный номер устройства (продажа) и штрих-код устройства (продажа), то удаляем его серийник и привязаный к нму штрих-код из базы
if ((isset($serialn)) && (isset($shtrihkod))) {	
	$res_serialnum = mysql_query("SELECT ID, ID_shtrihkoda FROM serialnum WHERE serial_number = '$serialn' LIMIT 1",$db);
	$myr_serialnum = mysql_fetch_array($res_serialnum);
	$res_del_shtrihkod = mysql_query("DELETE FROM shtrihkod WHERE ID = '{$myr_serialnum['ID_shtrihkoda']}' LIMIT 1",$db);
	$res_del_serialnum = mysql_query("DELETE FROM serialnum WHERE ID = '{$myr_serialnum['ID']}' LIMIT 1",$db);
	}
//Если был выбран только штрих-код устройства (продажа), то удаляем его из базы, проверяя нет ли его ИД в таблице с серийниками
elseif ((isset($shtrihkod)) && (!isset($serialn))) {
	$res_shtrihkod = mysql_query("SELECT ID FROM serialnum WHERE ID_shtrihkoda IN ( SELECT ID FROM shtrihkod WHERE shtrih = '$shtrihkod' )",$db);
	if (mysql_num_rows($res_shtrihkod) == 0) {
	$res_del_shtrihkod = mysql_query("DELETE FROM shtrihkod WHERE shtrih = '$shtrihkod' LIMIT 1",$db);
		}
	}
//Если был выбран серийник устройства (продажа), то удаляем его из базы. проверяя не привязан ли к ниму штрих-код
elseif ((!isset($shtrihkod)) && (isset($serialn))) {
	$res_serialnum = mysql_query("SELECT ID_shtrihkoda FROM serialnum WHERE serial_number = '$serialn' LIMIT 1",$db);
	$myr_serialnum = mysql_fetch_array($res_serialnum);
	if ($myr_serialnum['ID_shtrihkoda'] == 0) {
	$res_del_serialnum = mysql_query("DELETE FROM serialnum WHERE serial_number = '$serialn' LIMIT 1",$db);
		}
	}
//Обновляем состояние зарплаты для продавца
$res_max_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '$user' ORDER BY `ID` DESC LIMIT 1");
$myr_max_zap = mysql_fetch_array($res_max_zap);

$myr_max_zap['k_oplate'] = $myr_max_zap['k_oplate'] + $bonus_zp + $proc_zp;

$res_zar = mysql_query("INSERT INTO zarplata SET ID_prodaja = '{$myr_max_prodaja['ID']}', ID_magazina = '{$_SESSION['id_mag_selected']}', ID_usera = '$user', data = '$dat', vremya = '$vremya', polniy_den = '----', polov_dnya = '----', voznag_za_tp = '$bonus_tp', prodaja = '$bonus_jelezo', procent = '$proc_zp', k_oplate = '{$myr_max_zap['k_oplate']}',vudano = '----', shtraf = '----', bonus = '----', user = '----'",$db);

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при обновляении состояние зарплаты для продавца: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

//	$res_max_kassa = mysql_query("SELECT MAX(ID) AS `ID` FROM kassa WHERE magazine = '{$myr_mag['name']}'",$db);
//	$myr_max_kassa = mysql_fetch_array($res_max_kassa, MYSQL_ASSOC);
//	$res_vkasse = mysql_query("SELECT `vkasse` FROM kassa WHERE ID = '{$myr_max_kassa['ID']}'",$db);

//Оплата безналом Ф, гроші за обладнання йдуть на безнальний рахунок, гроші за ТП або за акційне обланнання йдуть на безнальний рахунок, з персонального рахунку оператора гроші за ТП або за акційне обланнання знімаються;
if ($sposob_oplatu == 'tf') {
$res_summa = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_summa = mysql_fetch_array($res_summa);
$summa_beznal = $myr_summa['summa'] + $stoimost + $oplata_tp_podkl - $skidka;
$izm = $stoimost + $oplata_tp_podkl - $skidka;
$res_beznal = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '{$myr_max_prodaja['ID']}', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `summa` = '$summa_beznal', `izmenenie` = '+$izm', `user` = '{$myr_usr['login']}: Продажа!'",$db);
}
//Оплата безналом Ю, гроші за обладнання йдуть на безнальний рахунок, гроші за ТП або за акційне обланнання йдуть напряму в обхід каси на рахунок оператора, з персонального рахунку оператора гроші не знімаються;
elseif ($sposob_oplatu == 'tu') {
$res_summa = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_summa = mysql_fetch_array($res_summa);
if ($akciya == 'true') {$summa_beznal = $myr_summa['summa']; $izm = 0;}
else {$summa_beznal = $myr_summa['summa'] + $stoimost - $skidka; $izm = $stoimost - $skidka;}
$res_beznal = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '{$myr_max_prodaja['ID']}', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `summa` = '$summa_beznal', `izmenenie` = '+$izm', `user` = '{$myr_usr['login']}: Продажа!'",$db);
}
//Оплата все налом, гроші за обладнання йдуть в кассу, гроші за ТП або за акційне обланнання йдуть в касу, з персонального рахунку оператора гроші за ТП або за акційне обланнання знімаються;
else {
$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_vkasse = mysql_fetch_array($res_vkasse);
$summa_vkasse = $myr_vkasse['vkasse'] + $stoimost + $oplata_tp_podkl - $skidka;
$izm = $stoimost + $oplata_tp_podkl - $skidka;
$res_kassa = mysql_query("INSERT INTO kassa SET ID_prodaja = '{$myr_max_prodaja['ID']}', data = '$dat $vremya', magazine = '{$myr_mag['name']}', vkasse = '$summa_vkasse', inkas = '+$izm', `user` = '{$myr_usr['login']}: Продажа!', sec_data = '$sec_dat'",$db);
}

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при обновляении состояние кассы магазина или безнал счета: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

//Если в продаже был выбран оператор и тарыфный план, то добавляем записи в базу информацию о снятии со счетов оператора и таблица отчет
if (isset($operator)){

if ($myr_op['priznak'] <> 'Нет') {

if ($sposob_oplatu == 'tu') {
$myr_rahunok = $myr_op['schet'];
$myr_stoim = 0;
}
else {
if ($akciya == 'true') {
	$myr_rahunok = $myr_op['schet'] - $oplata_tp_podkl - $stoimost;
	$myr_stoim = $oplata_tp_podkl + $stoimost;
} else {
	if ($myr_op['priznak'] == 'Тарыфный план') {$myr_rahunok = $myr_op['schet'] - $oplata_tp_podkl;}
	if ($myr_op['priznak'] == 'Оборудование') {$myr_rahunok = $myr_op['schet'] - $stoimost;}
	if ($myr_op['priznak'] == 'Тарыфный план + Оборудование') {$myr_rahunok = $myr_op['schet'] - $oplata_tp_podkl - $stoimost;}
	$myr_stoim = $oplata_tp_podkl;
}
}

$res_otchet = mysql_query("INSERT INTO otchet SET ID_prodaja = '{$myr_max_prodaja['ID']}', data = '$dat', magazin = '{$myr_mag['name']}', ID_operatora = '$operator', fio = '$fio', nomer_abon = '$abon_nomer', kontakt_nomer = '$kontakt_nom_tel', paket = '{$myr_tp['tarifplan']}', kluch_evdo = '$kluch_evdo', avans = '$oplata_tp_podkl', oplata = '$myr_stoim', ostatok = '$myr_rahunok', oborudov = '{$myr_tov['tovar']}', sec_data = '$sec_dat'",$db);

$res_rah_update = mysql_query("UPDATE operatoru SET schet = '$myr_rahunok' WHERE ID = '$operator'",$db);	
} 

else {
$res_otchet = mysql_query("INSERT INTO otchet SET ID_prodaja = '{$myr_max_prodaja['ID']}', data = '$dat', magazin = '{$myr_mag['name']}', ID_operatora = '$operator', fio = '$fio', nomer_abon = '$abon_nomer', kontakt_nomer = '$kontakt_nom_tel', paket = '{$myr_tp['tarifplan']}', kluch_evdo = '$kluch_evdo', avans = '$oplata_tp_podkl', oplata = '----', ostatok = '----', oborudov = '{$myr_tov['tovar']}', sec_data = '$sec_dat'",$db);	
}

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при обновляении состояние счета оператора: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

}
}	
else {?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Этот товар нельзя продать, поскольку его нет на Остаткие. <a href="../sklad.php">На страницу товаров</a>.</p>
</body>
</html>	
	
<?php
die();
}
}
}
//Добавить еще
if (isset($_POST['save_add'])) {
	if (isset($printer_id)) {$last_result = mysql_query("UPDATE `prodaja` SET `printer_ID` = '$printer_id' WHERE `ID` = '{$myr_max_prodaja['ID']}'",$db);}
	else {$last_result = mysql_query("UPDATE `prodaja` SET `printer_ID` = '{$myr_max_prodaja['ID']}' WHERE `ID` = '{$myr_max_prodaja['ID']}'",$db); $printer_id = $myr_max_prodaja['ID'];}	
	header("Location: ./add_prodaja.php?prnt_id={$printer_id}");
	$_SESSION['kontakt_nom_tel'] = $kontakt_nom_tel;
	$_SESSION['fio_abon'] = $fio;
	$_SESSION['abon_nomer'] = $abon_nomer;
	$_SESSION['mesto_polz'] = $mesto_polz;
	$_SESSION['id_magaz'] = $magazine;
	$_SESSION['name_magaz'] = $myr_mag['name'];

//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////
$informer = "Ошибка MySQL при нажатии кнопки Добавить еще: ".mysql_errno($db).":".mysql_error($db)."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
$informer = "ИД-группы для печати: ".$printer_id." Контактный номер тел: ".$_SESSION['kontakt_nom_tel']." ФИО: ".$_SESSION['fio_abon']." Абон номер: ".$_SESSION['abon_nomer']." Место пользов: ".$_SESSION['mesto_polz']." ИД-магазина: ".$_SESSION['id_magaz']."\n";
file_put_contents($fname, $informer, FILE_APPEND | LOCK_EX);
//LOG///////////////////////////////////////////////////////////////////////////////////////////////////////

}
else {header("Location: ../prodaja.php");}	
 //echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>
