<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'PAYment.php';
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Вознаграждения</title>
<link rel="stylesheet" href="../style_main_page.css" />
<link rel="stylesheet" href="PAYment/dump_style.css" />
<script type="text/javascript" src="PAYment/js/jquery.ui.plupload/jquery.min.js"></script>
<script type="text/javascript" src="PAYment/js/jquery.ttabs.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<!--<script type="text/javascript">
document.write($.fn.jquery);
</script>-->
<script type="text/javascript">
jq = jQuery.noConflict(true);
</script>
<!--<script type="text/javascript">
document.write(jq.fn.jquery);
</script>-->
</head>

<body>
<div align="center">



<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1; height:10px;">

<table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button" href="operatoru.php">Операторы</a></td><td><a class="like_button" href="tarifplan.php">Тарифы</a></td><td><a class="like_button" href="plan.php">План</a></td><td><a class="like_button_use" href="PAYment.php">Дилерам</a></td>
<?php 
if (isset($_SESSION['sebespriv']) &&($_SESSION['sebespriv'] == 1)) {
printf('<td><a class="like_button" href="rashodu.php">Расходы</a></td>');}
if (isset($_SESSION['kontpriv']) &&($_SESSION['kontpriv'] == 1)) {
printf('<td><a class="like_button" href="kontrol.php">Контроль</a></td>');}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table>

</td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1; height:30px;" align="left">
<table><tr><td width="525" align="right"><a class="like_button" href="PAYment/uploader.php">Загрузка файлов</a></td><td><a class="like_button" href="archive_files.php">Архив файлов</a></td><td><a class="like_button" href="dileru.php">Список дилеров</a></td></tr></table>
</td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1; height:30px;">
<form method="post"><p style="font-size:14px;">Файл для анализа: <select name="file_name" onChange="this.form.submit();"><option selected value='none'>Выберите файл</option>
<?php 
if (isset($_POST['file_name'])) {$_SESSION['file_name'] = $_POST['file_name'];} 
elseif (!isset($_SESSION['file_name'])) {$_SESSION['file_name'] = 'none';}

$tables = array('payment_2chast','payment_neokup','payment_ottok','payment_podkl','payment_router','payment_trafik','payment_vosstanov');
$ind = 0;
$files_array = array();
$dates_array = array();
while (isset($tables[$ind])) {

$query = "SELECT DISTINCT `filename`, `sec_data` FROM ".$tables[$ind]." ORDER BY ID";
$result = mysql_query($query,$db);

if (mysql_num_rows($result) > 0) {
	
	while ($myrow = mysql_fetch_array($result)) {
		$iterator = 0; $uniq_flag = true;
		while (isset($files_array[$iterator])) {
			if ($files_array[$iterator] == $myrow['filename']) {$uniq_flag = false;}
			$iterator++;
			}
		if ($uniq_flag == true) {$files_array[] = $myrow['filename']; $dates_array[] = $myrow['sec_data'];}			
		}	
	}		
$ind++;
}


$files_array_sorted = array();
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
sort($files_array, SORT_LOCALE_STRING);
foreach ($files_array as $key => $value){$files_array_sorted[] .= $value;}


$iterator = 0;
while (isset($files_array_sorted[$iterator])) {
	if ($_SESSION['file_name'] == $files_array_sorted[$iterator]) {
		printf("<option selected value='%s'>%s</option>",$files_array_sorted[$iterator],$files_array_sorted[$iterator]);
		}
		else {
			printf("<option value='%s'>%s</option>",$files_array_sorted[$iterator],$files_array_sorted[$iterator]);
			}
	
$iterator++;
}


?>
</select></p></form>
</td>
</tr>
<tr>
<td style="border-bottom:1px solid #c6d5e1;">
<?php if (isset($_POST['file_name']) && ($_POST['file_name'] <> 'none')) {printf('<p style="font-size:14px;">Выборка по дилерам:</p>');}?>
<form method="post" name="form_check">
<?php


$tables = array('payment_2chast','payment_neokup','payment_ottok','payment_podkl','payment_router','payment_trafik');
$ind = 0;
$dilers_array = array();
$isset_diler = false;

while (isset($tables[$ind])) {

$query = "SELECT DISTINCT `diler` FROM ".$tables[$ind]." WHERE `filename` = '{$_SESSION['file_name']}' ORDER BY `diler`";
$result = mysql_query($query,$db);

if (mysql_num_rows($result) > 0) {
	
	while ($myrow = mysql_fetch_array($result)) {
		$iterator = 0; $uniq_flag = true;
		while (isset($dilers_array[$iterator])) {
			if ($dilers_array[$iterator] == $myrow['diler']) {$uniq_flag = false;}
			$iterator++;
			}
		if ($uniq_flag == true) {$dilers_array[] = $myrow['diler'];}			
		}	
	$isset_diler = true;
	}		
$ind++;
}


$dilers_array_sorted = array();
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
sort($dilers_array, SORT_LOCALE_STRING);
foreach ($dilers_array as $key => $value){$dilers_array_sorted[] .= $value;}

$checked_dilers = array();

$iterator = 0; $col_count = 3; $i = 1;
printf("<table cellspacing='10'><tr>");
while (isset($dilers_array_sorted[$iterator])) {

$checked_flag = "";
	
if (isset($_POST['chb_dilers'])) {
foreach($_POST['chb_dilers'] as $key=>$value) {
	if ($value == $dilers_array_sorted[$iterator]) {$checked_flag = "checked"; $checked_dilers[] .= $value;}
	}
}


$checkbox_print = "<td><label style='font-size:12px;'><input type='checkbox' onclick='naiti(event)' ".$checked_flag." name='chb_dilers[]' value='".$dilers_array_sorted[$iterator]."'> ".$dilers_array_sorted[$iterator]."</label></td>";	

if ($i <= $col_count) {printf("%s",$checkbox_print); $i++;}
else {printf("</tr><tr>%s",$checkbox_print); $i = 2;}
			
$iterator++;
}
printf("</tr></table>");
//print_r($checked_dilers);
//print_r($_POST['chb_dilers']);
if (isset($_POST['procent_stavka'])) {$procent_stavka = $_POST['procent_stavka'];} else {$procent_stavka = 0;}

if ($isset_diler == true) {
printf('<table><tr><td><p style="font-size:14px;">Процентрная ставка (в процентах):</p><td><td id="procent_stavka"><input style="width:50px;" type="text" name="procent_stavka" value="%s"></td><td><input style="width:100px;" type="submit" name="dilers_submit" value="Рассчитать"></td><td><input style="width:100px;" type="button" name="ochistka" onClick="top.location.href=\'PAYment.php\'" value="Очистить"></td></tr></table>',$procent_stavka);
}
?>

</form>
</td>
</tr>

<?php
if (isset($_SESSION['file_name'])) {
$tables = array('payment_podkl','payment_ottok','payment_neokup','payment_trafik','payment_2chast','payment_router','payment_vosstanov');
$ind = 0;

$ttabs_names = '';
$ttabs_content = '';
$summ_payment = 0;
$summ_payment_clear = 0;

$xls_data_array = array();
$xls_data_array_summ = array();

while (isset($tables[$ind])) {
	


	switch ($tables[$ind]) {
    case 'payment_podkl':
        $insert_table = "подкл";
		$array_of_colums = array("nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "region", "tip", "oficialn_diler", "proekt", "gruppa_voznag", "kateg_voznag", "tip_voznag", "systema_nalog", "voznagrajdenie", "dop_bonus", "router");
		$array_of_names = array("Номер","л/с","ФИО абонента","Подключено","Акция","Дилер","Описание","Дата","Регион","Тип","Официальный дилер","Проект","Группа_вознагр.","Категория вознаграждения","Тип возн-ия","С-ма налог-ия","вознаграждение","Доп.бонус","Роутер");
		$summ_in_colum = "voznagrajdenie";
		$global_summ = "plus";
        break;
    case 'payment_ottok':
        $insert_table = "отток";
		$array_of_colums = array("region", "oficialn_diler", "diler", "abonent", "lic_schet", "nomer_tel", "tp_pri_podkl", "tip_tp", "data_podkl", "akciya", "tp_pri_otkl", "data_otkl", "uderjat_za_ottok");
		$array_of_names = array("Регион","Официальный дилер","Дилер","Абонент","Лиц. счет","№ телефона","ТП при подкл.","Тип ТП","Дата подкл.","Акция","ТП при откл.","Дата откл.","Удержать за отток (удержано)");
		$summ_in_colum = "uderjat_za_ottok";
		$global_summ = "minus";
        break;
    case 'payment_neokup':
        $insert_table = "неокуп";
		$array_of_colums = array("nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "data_otkl", "region", "tip", "oficialn_diler", "uderjano");
		$array_of_names = array("Номер","л/с","ФИО абонента","Подключено","Акция","Дилер","Описание","Дата","Дата отключения","Регион","Тип","Официальный дилер","Удержано");
		$summ_in_colum = "uderjano";
		$global_summ = "minus";
        break;
    case 'payment_trafik':
        $insert_table = "трафик";
		$array_of_colums = array("region", "oficialn_diler", "diler", "lic_schet", "abonent", "telefon", "tarif_plan", "data_podkl", "bonus", "internet_trafik", "akciya", "paket_v_otchot_mes");
		$array_of_names = array("Регион","Оф. дилер","Дилер","Лиц. счет","Абонент","Телефон","Тариф. план","Дата подкл.","Бонус","Интернет трафик, Мб","Акция","Пакет в отчетном месяце");
		$summ_in_colum = "bonus";
		$global_summ = "plus";
        break;
    case 'payment_2chast':
        $insert_table = "2ая часть";
		$array_of_colums = array("poryadok", "nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "data_otkl", "region", "tip", "oficialn_diler", "vtoraya_chast_voznag");
		$array_of_names = array("1","Номер","л/с","ФИО абонента","Подключено","Акция","Дилер","Описание","Дата","Дата отключения","Регион","Тип","Официальный дилер","Вторая часть вознаграждения");
		$summ_in_colum = "vtoraya_chast_voznag";
		$global_summ = "plus";
        break;
    case 'payment_router':
        $insert_table = "роутер";
		$array_of_colums = array("data", "cena", "l_s", "nomer_telefona", "data_opl_scheta", "klient", "terminal", "diler", "oficialn_diler", "polzovatel", "god", "mesyac", "den", "region_po_dileru", "region_po_nomeru", "summa_nalogu", "tip_voznagrajdeniya", "voznagrajdenie");
		$array_of_names = array("Дата","Цена","Л/С","№ телефона","Дата оплаты счета","Клиент","Терминал","Дилер","Оф.дилер","Пользователь","Год","Месяц","День","Регион по дилеру","Регион по номеру","С-ма налогообложения","Тип вознаграждения","Вознаграждение");
		$summ_in_colum = "voznagrajdenie";
		$global_summ = "plus";
        break;
	case 'payment_vosstanov':
        $insert_table = "восстановления";
		$array_of_colums = array("region", "oficialn_diler", "nomer_telefona", "l_s", "data_podkl", "torgovaya_tochka", "klient", "usluga", "operator", "bonus");
		$array_of_names = array("Регион","Официальный дилер","№ телефона","л/с","Дата подключения","Торговая точка","Клиент","Услуга","Оператор","Бонус");
		$summ_in_colum = "bonus";
		$global_summ = "plus";
        break;
	}


if (isset($_POST['chb_dilers'])) {
	
	$inddil = 0; 
	$array_of_dilers = '';
	if ($procent_stavka == '') {$procent_st = 0;} else {$procent_st = $procent_stavka;}
	
	while (isset($checked_dilers[$inddil])) {
		if ($tables[$ind] == 'payment_vosstanov') {$array_of_dilers .= "`torgovaya_tochka` = '".$checked_dilers[$inddil]."'";}
		else {$array_of_dilers .= "`diler` = '".$checked_dilers[$inddil]."'";}
		
		$res_diler_procent = mysql_query("SELECT procent FROM payment_dilers WHERE name = '{$checked_dilers[$inddil]}' LIMIT 1",$db);
		if (mysql_num_rows($res_diler_procent) > 0) {
			$myr_diler_procent = mysql_fetch_array($res_diler_procent);
			if ($myr_diler_procent['procent'] <> $procent_st) {
			$res_diler_procent = mysql_query("UPDATE payment_dilers SET procent = '$procent_st' WHERE name = '{$checked_dilers[$inddil]}'",$db);
				}
			}
			else {
			$res_diler_procent = mysql_query("INSERT INTO payment_dilers SET name = '{$checked_dilers[$inddil]}', procent = '$procent_st'",$db);
				}
						
		$inddil++;
		if (isset($checked_dilers[$inddil])) {$array_of_dilers .= " OR ";}
		}
	
	$query = "SELECT * FROM ".$tables[$ind]." WHERE `filename` = '{$_SESSION['file_name']}' AND ( ".$array_of_dilers." )";
	
//echo $array_of_dilers;	
	}
else {
	$query = "SELECT * FROM ".$tables[$ind]." WHERE `filename` = '{$_SESSION['file_name']}'";
	}

//echo $query.'</br>';

$result = mysql_query($query,$db);

if (mysql_num_rows($result) > 0) {
$ttabs_names .= '<span>'.$insert_table.'</span>';	

$ttabs_content .= '<div class="tt-panel">'.
'<table bgcolor=#c6d5e1 border=0 cellpadding=10 cellspacing=2 ><tr>';

$summ_in_table = 0;
$summ_in_table_clear = 0;

$i = 0;
while (isset($array_of_names[$i])) {
	$ttabs_content .= '<td bgcolor=#c1cedb align="center"><strong>'.$array_of_names[$i].'</strong></td>';
	$xls_data_array[$insert_table][$i][1] = $array_of_names[$i];
	$i++;
	}
$ttabs_content .= '</tr>';

$j = 2;

while ($myrow = mysql_fetch_array($result)) {
	$ttabs_content .= '<tr>';
	$i = 0;
	while (isset($array_of_colums[$i])) {
		
		if ($tables[$ind] == 'payment_ottok') {
			if ($array_of_colums[$i] == 'lic_schet') {$lic_schet = $myrow[$array_of_colums[$i]];}
			if ($array_of_colums[$i] == 'nomer_tel') {$nomer_tel = $myrow[$array_of_colums[$i]];}
			}
		
		if (isset($_POST['chb_dilers'])) {
			if ($array_of_colums[$i] == $summ_in_colum) {
				
				$real_ottok = '';
				
				if ($tables[$ind] == 'payment_ottok') { 
					$res_ottok = mysql_query("SELECT voznagrajdenie FROM payment_podkl WHERE l_s = '$lic_schet' AND nomer = '$nomer_tel'",$db);
					if (mysql_num_rows($res_ottok) > 0) {
						$myr_ottok = mysql_fetch_array($res_ottok);						
						$proc_voznag = round($myr_ottok['voznagrajdenie']*($procent_stavka/100), 2);
						$voznag_clear = $myr_ottok['voznagrajdenie'];
						if ($proc_voznag < $myrow[$array_of_colums[$i]]) {$summ_in_table = $summ_in_table + $proc_voznag; $real_ottok = ' ('.$proc_voznag.')'; $summ_in_table_clear = $summ_in_table_clear + $voznag_clear;}
						else {$summ_in_table = $summ_in_table + $myrow[$array_of_colums[$i]]; $real_ottok = ' ('.$myrow[$array_of_colums[$i]].')'; $summ_in_table_clear = $summ_in_table_clear + $myrow[$array_of_colums[$i]];}
						}					
					}
				elseif ($tables[$ind] == 'payment_neokup') {$summ_in_table = $summ_in_table + $myrow[$array_of_colums[$i]]; $summ_in_table_clear = $summ_in_table_clear + $myrow[$array_of_colums[$i]];}
				else {$summ_in_table = $summ_in_table + round($myrow[$array_of_colums[$i]]*($procent_stavka/100), 2); $summ_in_table_clear = $summ_in_table_clear + $myrow[$array_of_colums[$i]];} 
				
				
				
//				$summ_in_table = $summ_in_table + round($myrow[$array_of_colums[$i]]*($procent_stavka/100), 2);
				$xls_data_array[$insert_table][$i][$j] = $myrow[$array_of_colums[$i]].$real_ottok;
				$ttabs_content .= '<td bgcolor=#ffe3e3>'.$myrow[$array_of_colums[$i]].$real_ottok.'</td>';
				$summ_in_cname = $array_of_names[$i];
			}
			else {
				$xls_data_array[$insert_table][$i][$j] = $myrow[$array_of_colums[$i]];
				if ($myrow[$array_of_colums[$i]] == '(null)') {$myrow[$array_of_colums[$i]] = '<i>'.$myrow[$array_of_colums[$i]].'</i>';}	
				$ttabs_content .= '<td bgcolor=#f6f6f6>'.$myrow[$array_of_colums[$i]].'</td>';
				}
			
			}
		else{
			$xls_data_array[$insert_table][$i][$j] = $myrow[$array_of_colums[$i]];
			if ($myrow[$array_of_colums[$i]] == '(null)') {$myrow[$array_of_colums[$i]] = '<i>'.$myrow[$array_of_colums[$i]].'</i>';}	
			$ttabs_content .= '<td bgcolor=#f6f6f6>'.$myrow[$array_of_colums[$i]].'</td>';
			}

	$i++;
	}
	$ttabs_content .= '</tr>';
	$j++;
	}


		if ($summ_in_table > 0) {
			
			if ($global_summ == 'plus') {$summ_payment = $summ_payment + $summ_in_table; $summ_payment_clear = $summ_payment_clear + $summ_in_table_clear;}
			elseif ($global_summ == 'minus') {$summ_payment = $summ_payment - $summ_in_table; $summ_payment_clear = $summ_payment_clear - $summ_in_table_clear;}
			
			$ttabs_content .= '<tr>';
			$colsp = $i;
			if ($tables[$ind] == 'payment_neokup') {
				$ttabs_content .= '<td colspan='.$colsp.' bgcolor=#fff6aa><p style="font-size:15px;">Сумма по столбцу "'.$summ_in_cname.'" равна: <strong>'.$summ_in_table.'</strong> грн.</p></td>';
				}
				else {
					$ttabs_content .= '<td colspan='.$colsp.' bgcolor=#fff6aa><p style="font-size:15px;">Сумма по столбцу "'.$summ_in_cname.'" равна: <strong>'.$summ_in_table_clear.'</strong> грн., с учетм процентной ставки: <strong>'.$summ_in_table.'</strong> грн.</p></td>';
					}
			
			$ttabs_content .= '</tr>';
			
			$xls_data_array_summ[$insert_table][0] = $summ_in_cname;
			$xls_data_array_summ[$insert_table][1] = $summ_in_table;
			$xls_data_array_summ[$insert_table][2] = $summ_in_table_clear;
		}


	
$ttabs_content .= '</table>';
$ttabs_content .= '</div>';	
	}


$ind++;	
}
unset($_SESSION['xls_data_array']);
$_SESSION['xls_data_array'] = $xls_data_array;
unset($_SESSION['xls_data_array_summ']);
$xls_data_array_summ['summa'][0] = $summ_payment;
$xls_data_array_summ['summa'][1] = $procent_stavka;
if (isset($checked_dilers[0])) {
$xls_data_array_summ['summa'][2] = $_SESSION['file_name'].' '.$checked_dilers[0];	
	}
$xls_data_array_summ['summa'][3] = $summ_payment_clear;	
$_SESSION['xls_data_array_summ'] = $xls_data_array_summ;

}



?>
<tr>
<td style="border-bottom:1px solid #c6d5e1; height:30px;">
<?php 
if (isset($_POST['chb_dilers'])) {
printf('<table><tr><td><p style="font-size:15px;">Суммарное вознаграждение: <strong><font color="black">%s</font></strong> грн., с учетом процентной ставки: <strong><font color="red">%s</font></strong> грн.</p></td><td><form action="PAYment_to_xls.php"><input type="submit" style="width:120px;" value="Сохранить в XLS"></form></td></tr></table>',$summ_payment_clear,$summ_payment);	
}
?>
</td>
</tr>
<tr>
<td>
 <div class="tt-tabs">
    <div class="index-tabs">
        <?php echo $ttabs_names;?>
    </div>
    <div class="index-panel">
        <?php echo $ttabs_content;?>
    </div>
</div>
</td>
</tr>
</table>
</div>
<script>
$(document).ready(function(){
$('.tt-tabs').ttabs();
});



function naiti() {
      
var checkboxs = document.form_check.getElementsByTagName('input'),
    n = checkboxs.length,
    data = new Array()

    for (var i=0; i<n; i++) {
    if(checkboxs[i].type == 'checkbox' & checkboxs[i].checked) {
        data.push(checkboxs[i].value);
	}
	}
//  alert(data.join('\n'));
	jq("#procent_stavka").load("./PAYment/get_procent.php", { procent_array : data });

}


</script>
<div id="procent_stavka"></div>
</body>
</html>
<?php 
}
else {

header("Location: index.php");
die();
}

?>