<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
		if ($_SESSION['kat_skl'] == 'All') {$result = mysql_query("SELECT DISTINCT ID_tovara FROM sklad_tovaru ORDER BY ID_kategorii ASC",$db);}
		else {$result = mysql_query("SELECT DISTINCT ID_tovara FROM sklad_tovaru WHERE ID_kategorii = '{$_SESSION['kat_skl']}' ORDER BY ID_kategorii ASC",$db);}

$myrow = mysql_fetch_array($result);
 
require_once 'PHPExcel.php';
$phpexcel = new PHPExcel();
$page = $phpexcel->setActiveSheetIndex(0);

//настройки для шрифтов
$baseFont = array(
	'font'=>array(
		'name'=>'Arial',
		'size'=>'10',
		'bold'=>false
	)
);
$boldFont = array(
	'font'=>array(
		'name'=>'Arial',
		'size'=>'12',
		'bold'=>true
	)
);
//и позиционирование
$center = array(
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

$page->setCellValue("A1", "Наименование товара")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->getColumnDimension("A")->setAutoSize(true);
$i = 1; $x = 'B';
do {
$page->setCellValue($x.'1', $_SESSION['name_mag'][$i])->getStyle($x.'1')->applyFromArray($boldFont)->applyFromArray($center);
$page->getColumnDimension($x)->setAutoSize(true);
$i++; $x++;
if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
} while (isset($_SESSION['name_mag'][$i]));
$page->setCellValue($x.'1', "Суммарное количество")->getStyle($x.'1')->applyFromArray($boldFont)->applyFromArray($center);
$page->getColumnDimension($x)->setAutoSize(true);

$y = 2;
do {
$result_tov = mysql_query("SELECT `tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);	
$page->setCellValue("A".$y, $myrow_tov['tovar'])->getStyle('A'.$y)->applyFromArray($baseFont);
   $i = 1; $summa = 0; $x = 'B';
   do {
   	$res_kolich = mysql_query("SELECT kolichestvo FROM sklad_tovaru WHERE ID_magazina = '{$_SESSION['id_mag'][$i]}' AND ID_tovara = '{$myrow['ID_tovara']}'",$db);
	if (mysql_num_rows($res_kolich) > 0) {
		$myr_kolich = mysql_fetch_array($res_kolich);		
		$page->setCellValue($x.$y, $myr_kolich['kolichestvo'])->getStyle($x.$y)->applyFromArray($baseFont);
		$summa = $summa + $myr_kolich['kolichestvo'];
	} else {$page->setCellValue($x.$y, "----")->getStyle($x.$y)->applyFromArray($baseFont);}	
	$i++; $x++;
	if ($_SESSION['id_mag'][$i] == 'all') {$i++;}
   } while (isset($_SESSION['id_mag'][$i]));
$page->setCellValue($x.$y, $summa)->getStyle($x.$y)->applyFromArray($baseFont);	
$y++;
} 
while ($myrow = mysql_fetch_array($result));

$page->setTitle("Остатки");

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));

$filename='Остатки на '.$dat.'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
//$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');  
$objWriter->save('php://output');
}
else {

header("Location: index.php");
die();
}
?>