<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if ($_SESSION['id_mag_selected'] == 'all') {$result = mysql_query("SELECT * FROM otchet WHERE ID_operatora = '{$_SESSION['ID_oper']}' AND sec_data = '{$_SESSION['sec_data']}' ORDER BY ID DESC",$db);}
else {
$res_mag=mysql_query("SELECT name FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myr_mag=mysql_fetch_array($res_mag);
$result = mysql_query("SELECT * FROM otchet WHERE ID_operatora = '{$_SESSION['ID_oper']}' AND sec_data = '{$_SESSION['sec_data']}' AND magazin = '{$myr_mag['name']}' ORDER BY ID DESC",$db);
}
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


$page->setCellValue("A1", "Дата")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Магазин")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "ФИО")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Номер абонента")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("E1", "Контактный номер телефона")->getStyle('E1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("F1", "Пакет")->getStyle('F1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("G1", "Ключ EVDO")->getStyle('G1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("H1", "Аванс")->getStyle('H1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("I1", "Оплата с лицевого счета")->getStyle('I1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("J1", "Оборудование")->getStyle('J1')->applyFromArray($boldFont)->applyFromArray($center);
$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);
$page->getColumnDimension("E")->setAutoSize(true);
$page->getColumnDimension("F")->setAutoSize(true);
$page->getColumnDimension("G")->setAutoSize(true);
$page->getColumnDimension("H")->setAutoSize(true);
$page->getColumnDimension("I")->setAutoSize(true);
$page->getColumnDimension("J")->setAutoSize(true);


$no=2;
do {
$page->setCellValue("A".$no, $myrow['data'])->getStyle('A'.$no)->applyFromArray($baseFont);
$page->setCellValue("B".$no, $myrow['magazin'])->getStyle('B'.$no)->applyFromArray($baseFont);
$page->setCellValue("C".$no, $myrow['fio'])->getStyle('C'.$no)->applyFromArray($baseFont);
$page->setCellValue("D".$no, $myrow['nomer_abon'])->getStyle('D'.$no)->applyFromArray($baseFont);
$page->setCellValue("E".$no, $myrow['kontakt_nomer'])->getStyle('E'.$no)->applyFromArray($baseFont);
$page->setCellValue("F".$no, $myrow['paket'])->getStyle('F'.$no)->applyFromArray($baseFont);
$page->setCellValue("G".$no, $myrow['kluch_evdo'])->getStyle('G'.$no)->applyFromArray($baseFont);
$page->setCellValue("H".$no, $myrow['avans'])->getStyle('H'.$no)->applyFromArray($baseFont);
$page->setCellValue("I".$no, $myrow['oplata'])->getStyle('I'.$no)->applyFromArray($baseFont);
$page->setCellValue("J".$no, $myrow['oborudov'])->getStyle('J'.$no)->applyFromArray($baseFont);	
$no++;
}
while ($myrow = mysql_fetch_array($result));
$page->setTitle("Отчет");

$hours = date('H') + $_SESSION['time_zone'];
$data = date ('d.m.Y', mktime ($hours));
$res_oper=mysql_query("SELECT oper FROM operatoru WHERE ID = '{$_SESSION['ID_oper']}'");
$myr_oper=mysql_fetch_array($res_oper);

$filename='Отчет по'.' '.$myr_oper['oper'].' '.$data.'.xlsx';

//ob_end_clean();
//include("PHPExcel/Writer/Excel2007.php");

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');  
$objWriter->save('php://output');
}
else {

header("Location: index.php");
die();
}
?>