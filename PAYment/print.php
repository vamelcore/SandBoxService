<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Дамп выборки</title>
<link rel="stylesheet" href="../style_main_page.css" />
<link rel="stylesheet" href="dump_style.css" />
<script type="text/javascript" src="js/jquery.ui.plupload/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.ttabs.js"></script>
</head>

<body>
<div align="center">
<table border="0" style='border:1px solid #ccc; background:#f6f6f6;'>
<tr>
<td>
<?php
include ("../config.php"); 
session_start();
//print_r ($_SESSION['xls_data_array']);
$xls_data_array = $_SESSION['xls_data_array'];

//if (isset($_POST['procent'])) {$procent = $_POST['procent'];} else {$procent = 0;}

$ttabs_names = '';
$ttabs_content = '';

$diler_array = array();
$summ_payment = 0;
if (isset($_SESSION['diler_array'])) {$diler_array = $_SESSION['diler_array'];}

foreach ($xls_data_array as $worksheet => $worksheet_data_array) {

////////////////////////////////////////not_uni	
	
	switch ($worksheet) {
    case 'подкл':
        $summ_in_colum = "вознаграждение";
		$global_summ = "plus";
        break;
    case 'отток':
        $summ_in_colum = "Удержать за отток";
		$global_summ = "minus";
        break;
    case 'неокуп':
        $summ_in_colum = "Удержано";
		$global_summ = "minus";
        break;
    case 'трафик':
        $summ_in_colum = "Бонус";
		$global_summ = "plus";
        break;
    case '2ая часть':
        $summ_in_colum = "Вторая часть вознаграждения";
		$global_summ = "plus";
        break;
    case 'роутер':
        $summ_in_colum = "Вознаграждение";
		$global_summ = "plus";
        break;
	case 'восстановления':
        $summ_in_colum = "Бонус";
		$global_summ = "plus";
        break;
	default:
	    $summ_in_colum = "null";
		$global_summ = "null";	
}
////////////////////////////////////////not_uni	
$summ_in_table = 0;
//$summ_in_table_ottok = 0;	
$ttabs_names .= '<span>'.$worksheet.'</span>';
$x = 0; $y=1;
$diler_index = '';
$ttabs_content .= '<div class="tt-panel">'.
'<table bgcolor=#c6d5e1 border=0 cellpadding=10 cellspacing=2 >';	

if (isset($_POST['diler']) && ($_POST['diler'] <> '') && ($_POST['diler'] <> 'all')) {
	
	$ttabs_content .= '<tr>';
while (isset($worksheet_data_array[$x][$y])) {
	$ttabs_content .= '<td bgcolor=#c1cedb>'.$worksheet_data_array[$x][$y].'</td>';

	if (($worksheet_data_array[$x][$y] == "Дилер") || ($worksheet_data_array[$x][$y] == "Торговая точка")) {$diler_index = $x;}
	if ($worksheet == 'отток') {if ($worksheet_data_array[$x][$y] == "Лиц. счет") {$l_s_index = $x;} if ($worksheet_data_array[$x][$y] == "№ телефона") {$no_tel_index = $x;}}
	$x_counter = $x;

////////////////////////////////////////not_uni	

	if ($worksheet_data_array[$x][$y] == $summ_in_colum) {$summ_index = $x;}

////////////////////////////////////////not_uni	

	$x++;
	}
	$ttabs_content .= '</tr>';
	
	if ((isset($_POST['procent'])) && (isset($_POST['save']))) {$diler_proc = $_POST['procent'];} 
	else {
	$res_diler_proc = mysql_query("SELECT procent FROM payment_dilers WHERE name='{$_POST['diler']}'",$db);
	$informer = "Ошибка MySQL: ".mysql_errno($db).":".mysql_error($db)."\n";
//	echo $informer;
	if (mysql_num_rows($res_diler_proc) > 0) {$myr_diler_proc = mysql_fetch_array($res_diler_proc); $diler_proc = $myr_diler_proc['procent'];} else {if (isset($_POST['procent'])) {$diler_proc = $_POST['procent'];} else {$diler_proc = 0;}}
	}
	
$y=2; $x = $diler_index; $isset_row_data = false;
while (isset($worksheet_data_array[$x][$y])) {
	
	if ($worksheet_data_array[$x][$y] == $_POST['diler']) {
		$ttabs_content .= '<tr>';
		$xint = 0;
		while (isset($worksheet_data_array[$xint][$y])) {
			
////////////////////////////////////////not_uni				
			$real_ottok = '';
			if ((isset($summ_index)) && ($xint == $summ_index)) {
				$style_td = 'ffe3e3';
				
				if ($worksheet == 'отток') { 
					$res_ottok = mysql_query("SELECT voznagrajdenie FROM payment_podkl WHERE l_s = '{$worksheet_data_array[$l_s_index][$y]}' AND nomer = '{$worksheet_data_array[$no_tel_index][$y]}'",$db);
					if (mysql_num_rows($res_ottok) > 0) {
						$myr_ottok = mysql_fetch_array($res_ottok);						
						$proc_voznag = round($myr_ottok['voznagrajdenie']*($diler_proc/100), 2);
						if ($proc_voznag < $worksheet_data_array[$xint][$y]) {$summ_in_table = $summ_in_table + $proc_voznag; $real_ottok = ' ('.$proc_voznag.')';}
						else {$summ_in_table = $summ_in_table + $worksheet_data_array[$xint][$y]; $real_ottok = ' ('.$worksheet_data_array[$xint][$y].')';}
						}					
					}
				elseif ($worksheet == 'неокуп') {$summ_in_table = $summ_in_table + $worksheet_data_array[$xint][$y];}
				else {$summ_in_table = $summ_in_table + round($worksheet_data_array[$xint][$y]*($diler_proc/100), 2);} 
				
//				$summ_in_table = $summ_in_table + $worksheet_data_array[$xint][$y];
				
				} else {$style_td = 'f6f6f6';}
			
			$ttabs_content .= '<td bgcolor=#'.$style_td.'>'.$worksheet_data_array[$xint][$y].$real_ottok.'</td>';
			
////////////////////////////////////////not_uni				
			
			$xint++;
			}
		$ttabs_content .= '</tr>';
		$isset_row_data = true;
		}
	
	if (!isset($_SESSION['diler_array'])) {
		$iterator = 0; $uniq_flag = true;
		while (isset($diler_array[$iterator])) {
			if (($diler_array[$iterator] == $worksheet_data_array[$diler_index][$y]) || ($worksheet_data_array[$diler_index][$y] == '(null)')) {$uniq_flag = false;}
			$iterator++;
			}
			if ($uniq_flag == true) {$diler_array[] = $worksheet_data_array[$diler_index][$y];}
	}
	
	$y++;
	}

	if ($isset_row_data == false) {
		$ttabs_content .= '<tr>';
		$xint = 0;
		while ($xint <= $x_counter) {
			$ttabs_content .= '<td bgcolor=#f6f6f6>Нет данных</td>';
			$xint++;
			}
		$ttabs_content .= '</tr>';
		}
	
		if ($summ_in_table > 0) {
			
			if ($global_summ == 'plus') {$summ_payment = $summ_payment + $summ_in_table;}
			elseif ($global_summ == 'minus') {$summ_payment = $summ_payment - $summ_in_table;}
			
			$ttabs_content .= '<tr>';
			$colsp = $x_counter+1;
			$ttabs_content .= '<td colspan='.$colsp.' bgcolor=#fff6aa><p style="font-size:15px;">Сумма по столбцу "'.$summ_in_colum.'" с учетм процентной ставки равна: '.$summ_in_table.'</p></td>';
			$ttabs_content .= '</tr>';
		}
	
	
}
else {

while (isset($worksheet_data_array[$x][$y])) {
	$ttabs_content .= '<tr>';
	if ($y == 1) {$info = '<td bgcolor=#c1cedb>'; } else {$info = '<td bgcolor=#f6f6f6>';}
	while (isset($worksheet_data_array[$x][$y])) {		
	$ttabs_content .= $info.$worksheet_data_array[$x][$y].'</td>';
	if (($worksheet_data_array[$x][$y] == "Дилер") || ($worksheet_data_array[$x][$y] == "Торговая точка")) {$diler_index = $x;}
	$x++;
	
	}
	$ttabs_content .= '</tr>';
	if (($diler_index != '') && (!isset($_SESSION['diler_array']))) {
		$iterator = 0; $uniq_flag = true;
		while (isset($diler_array[$iterator])) {
			if (($diler_array[$iterator] == $worksheet_data_array[$diler_index][$y]) || ($worksheet_data_array[$diler_index][$y] == '(null)')) {$uniq_flag = false;}
			$iterator++;
			}
			if ($uniq_flag == true) {$diler_array[] = $worksheet_data_array[$diler_index][$y];}				
		}
	$y++;
	$x=0;

	}	
}

$ttabs_content .= '</table>';
$ttabs_content .= '</div>';

}

//print_r($diler_array); echo '<br><br>';
if ((!isset($_POST['diler']) || ($_POST['diler'] == '') || ($_POST['diler'] == 'all')) && (!isset($_SESSION['diler_array']))) {
	$shift_element = array_shift($diler_array);	
	}
//print_r($diler_array); echo '<br><br>';
//print_r($_SESSION['diler_array']);

if (!isset($_SESSION['diler_array'])) {$_SESSION['diler_array'] = $diler_array;}
?>
<form method="post"><p style="font-size:14px;">Выборка по дилерам: <select name='diler' id='diler' onchange="this.form.submit()"><option value="all">ВСЕ</option>
<?php
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
sort($diler_array, SORT_LOCALE_STRING);
foreach ($diler_array as $key => $value){
	if (isset($_POST['diler']) && ($_POST['diler'] == $value)) {
		printf("<option selected value='%s'>%s</option>",$value,$value);
		$diler_selected = $value;
		$result = mysql_query("SELECT * FROM payment_dilers WHERE name = '$diler_selected'",$db);
		}
	else {printf("<option value='%s'>%s</option>",$value,$value);}
}
?>
</select> Процентрная ставка: <select name='procent' id='procent'>
<?php
if (isset($_POST['procent'])) {$procent = $_POST['procent'];} else {$procent = 0;}
if ((mysql_num_rows($result) > 0) && (isset($_POST['save']))) {
	$result = mysql_query("UPDATE payment_dilers SET procent = '$procent' WHERE name = '$diler_selected'",$db);
	$informer = "Ошибка MySQL: ".mysql_errno($db).":".mysql_error($db)."\n";
	$prosent_db = 'updated_in_db '.$diler_selected.' '.$procent.$informer;
	}
	elseif ((mysql_num_rows($result) > 0) && (!isset($_POST['save']))) {
			$myrow = mysql_fetch_array($result);
			$procent = $myrow['procent'];
			$prosent_db = $myrow['procent'];			
		}
		elseif ($diler_selected <> '') {
				$result = mysql_query("INSERT INTO payment_dilers SET name = '$diler_selected', procent = '$procent'",$db);
				$informer = "Ошибка MySQL: ".mysql_errno($db).":".mysql_error($db)."\n";
				$prosent_db = 'saved_to_db '.$diler_selected.' '.$procent.$informer;
				}
for ($i=0; $i<=100; $i++) {
	if ($i == $procent) {printf('<option value="%s" selected>%s</option>',$i,$i);}
	else {printf('<option value="%s">%s</option>',$i,$i);} 	
	}
?>
</select> <input type="submit" id='sub_button' name="save" value="Сохранить">&nbsp;&nbsp;&nbsp;<input type="button" value="На общую ->" onClick="top.location.href='../page.php'" style="width:160px; height:25px; font-size:14px;"></p></form>
</br>
<?php if (isset($_POST['diler']) && ($_POST['diler'] <> 'all')) {
//$summ_pay = round($summ_payment*($procent/100), 2);	
printf('<p style="font-size:15px;">Суммарное вознаграждение дилера: <strong><font color="red">%s</font></strong> грн.</p></br>',$summ_payment);	
}?>
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
var diler = $('#diler').val();
if (diler == 'all') {$('#sub_button').attr('disabled', 'disabled');}
else {$('#sub_button').removeAttr('disabled');}
});
</script>
<?php //if (isset($prosent_db)) {echo $prosent_db;} print_r($_POST);?>
</body>
</html>