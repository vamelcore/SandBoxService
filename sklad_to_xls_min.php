<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if ($_SESSION['kat_skl'] == 'All') {$result = mysql_query("SELECT * FROM sklad_tovaru WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ORDER BY ID_kategorii ASC",$db);}
		else {$result = mysql_query("SELECT * FROM sklad_tovaru WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND ID_kategorii = '{$_SESSION['kat_skl']}' ORDER BY ID_kategorii ASC",$db);}

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

$page->setCellValue("A1", "Категория товара")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Наименование товара")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Количество последненго прихода")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Дата последненго прихода")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("E1", "Количество")->getStyle('E1')->applyFromArray($boldFont)->applyFromArray($center);	

$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);
$page->getColumnDimension("E")->setAutoSize(true);

$no=2;
do {
	 $result_kat = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '{$myrow['ID_kategorii']}'",$db);
	 $myrow_kat = mysql_fetch_array($result_kat);

  $result_tov = mysql_query("SELECT `tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
  $myrow_tov = mysql_fetch_array($result_tov);
$page->setCellValue("A".$no, $myrow_kat['kateg'])->getStyle('A'.$no)->applyFromArray($baseFont);
$page->setCellValue("B".$no, $myrow_tov['tovar'])->getStyle('B'.$no)->applyFromArray($baseFont);
$page->setCellValue("C".$no, $myrow['kol_posl_prihoda'])->getStyle('C'.$no)->applyFromArray($baseFont);
$page->setCellValue("D".$no, $myrow['data_posl_prihoda'])->getStyle('D'.$no)->applyFromArray($baseFont);	
$page->setCellValue("E".$no, $myrow['kolichestvo'])->getStyle('E'.$no)->applyFromArray($baseFont);
$no++;
}
while ($myrow = mysql_fetch_array($result));

$page->setTitle("Остатки");

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));

$result_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		

$filename='Остатки из '.' '.$myrow_mag['name'].' на '.$dat.'.xlsx';
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