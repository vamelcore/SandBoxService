<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if ($_SESSION['id_mag_selected'] == 'all') {
	$magazin_n = 'всех магазинах';
		if ($_SESSION['pr_sec_data'] == 'All') {
			$data_n = 'все время';
	$result = mysql_query("SELECT * FROM prodaja ORDER BY ID DESC",$db);
		}
        else {
        	$data_n = $_SESSION['pr_sec_data'];
	$result = mysql_query("SELECT * FROM prodaja WHERE sec_data = '{$_SESSION['pr_sec_data']}' ORDER BY ID DESC",$db);	
	        }
}
else {
		
$result_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		
	$magazin_n = $myrow_mag['name'];
	if ($_SESSION['pr_sec_data'] == 'All') {
		$data_n = 'все время';
	$result = mysql_query("SELECT * FROM prodaja WHERE magazin = '{$myrow_mag['name']}' ORDER BY ID DESC",$db);
		}
    else {
    	$data_n = $_SESSION['pr_sec_data'];
	$result = mysql_query("SELECT * FROM prodaja WHERE magazin = '{$myrow_mag['name']}' AND sec_data = '{$_SESSION['pr_sec_data']}' ORDER BY ID DESC",$db);	
	        }
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
$page->setCellValue("B1", "Тип")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Магазин")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Категория")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("E1", "Наименование")->getStyle('E1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("F1", "Вознаграждение, грн")->getStyle('F1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("G1", "Стоимость материалов, грн")->getStyle('G1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("H1", "Процент от прод, грн")->getStyle('H1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("I1", "Тип работы")->getStyle('I1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("J1", "Работа")->getStyle('J1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("K1", "Вознаграждение за работу, грн")->getStyle('K1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("L1", "Оплата за работу, грн")->getStyle('L1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("M1", "Марка авто")->getStyle('M1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("N1", "Контактний номер телефона")->getStyle('N1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("O1", "ФИО")->getStyle('O1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("P1", "Абонентский номер")->getStyle('P1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("Q1", "Место пользования")->getStyle('Q1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("R1", "Скидка")->getStyle('R1')->applyFromArray($boldFont)->applyFromArray($center);
if ($_SESSION['sebespriv'] == 1) {
$page->setCellValue("S1", "Себестоимость")->getStyle('S1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("T1", "Примечание")->getStyle('T1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("U1", "Кем продано")->getStyle('U1')->applyFromArray($boldFont)->applyFromArray($center);
}
else{
$page->setCellValue("S1", "Примечание")->getStyle('S1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("T1", "Кем продано")->getStyle('T1')->applyFromArray($boldFont)->applyFromArray($center);	
}

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
$page->getColumnDimension("K")->setAutoSize(true);
$page->getColumnDimension("L")->setAutoSize(true);
$page->getColumnDimension("M")->setAutoSize(true);
$page->getColumnDimension("N")->setAutoSize(true);
$page->getColumnDimension("O")->setAutoSize(true);
$page->getColumnDimension("P")->setAutoSize(true);
$page->getColumnDimension("Q")->setAutoSize(true);
$page->getColumnDimension("R")->setAutoSize(true);
if ($_SESSION['sebespriv'] == 1) {
$page->getColumnDimension("S")->setAutoSize(true);
$page->getColumnDimension("T")->setAutoSize(true);
$page->getColumnDimension("U")->setAutoSize(true);
}
else{
$page->getColumnDimension("S")->setAutoSize(true);
$page->getColumnDimension("T")->setAutoSize(true);
}
$no=2;
do {
$page->setCellValue("A".$no, $myrow['data'])->getStyle('A'.$no)->applyFromArray($baseFont);
$page->setCellValue("B".$no, $myrow['b'])->getStyle('B'.$no)->applyFromArray($baseFont);
$page->setCellValue("C".$no, $myrow['magazin'])->getStyle('C'.$no)->applyFromArray($baseFont);
$page->setCellValue("D".$no, $myrow['kategoria'])->getStyle('D'.$no)->applyFromArray($baseFont);
$page->setCellValue("E".$no, $myrow['naimenovanie'])->getStyle('E'.$no)->applyFromArray($baseFont);
$page->setCellValue("F".$no, $myrow['voznag_za_jelezo'])->getStyle('F'.$no)->applyFromArray($baseFont);
$page->setCellValue("G".$no, $myrow['stoimost'])->getStyle('G'.$no)->applyFromArray($baseFont);
$page->setCellValue("H".$no, $myrow['procent_prod'])->getStyle('H'.$no)->applyFromArray($baseFont);
$page->setCellValue("I".$no, $myrow['operator'])->getStyle('I'.$no)->applyFromArray($baseFont);
$page->setCellValue("J".$no, $myrow['tarifn_plan'])->getStyle('J'.$no)->applyFromArray($baseFont);
$page->setCellValue("K".$no, $myrow['voznag_za_tp'])->getStyle('K'.$no)->applyFromArray($baseFont);
$page->setCellValue("L".$no, $myrow['oplata_tp_podkluchenie'])->getStyle('L'.$no)->applyFromArray($baseFont);
$page->setCellValue("M".$no, $myrow['kluch_evdo'])->getStyle('M'.$no)->applyFromArray($baseFont);
$page->setCellValue("N".$no, $myrow['kontakt_nomer_tel'])->getStyle('N'.$no)->applyFromArray($baseFont);
$page->setCellValue("O".$no, $myrow['FIO'])->getStyle('O'.$no)->applyFromArray($baseFont);
$page->setCellValue("P".$no, $myrow['abonent_nomer'])->getStyle('P'.$no)->applyFromArray($baseFont);
$page->setCellValue("Q".$no, $myrow['mesto_polz'])->getStyle('Q'.$no)->applyFromArray($baseFont);
$page->setCellValue("R".$no, $myrow['skidka'])->getStyle('R'.$no)->applyFromArray($baseFont);
if ($_SESSION['sebespriv'] == 1) {
$page->setCellValue("S".$no, $myrow['sebestoimost'])->getStyle('S'.$no)->applyFromArray($baseFont);
$page->setCellValue("T".$no, $myrow['add'])->getStyle('T'.$no)->applyFromArray($baseFont);
$page->setCellValue("U".$no, $myrow['user'])->getStyle('U'.$no)->applyFromArray($baseFont);
}
else {
$page->setCellValue("S".$no, $myrow['add'])->getStyle('S'.$no)->applyFromArray($baseFont);
$page->setCellValue("T".$no, $myrow['user'])->getStyle('T'.$no)->applyFromArray($baseFont);
}
	
$no++;
}
while ($myrow = mysql_fetch_array($result));

$page->setTitle("Отчет");

$filename='Отчет '.' '.$magazin_n.' за '.$data_n.'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
//$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');


//function SaveViaTempFile($objWriter){
//    $filePath = '/tmp/' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
//    $objWriter->save($filePath);
//    readfile($filePath);
//    unlink($filePath);
//}
//
//SaveViaTempFile($objWriter);

$objWriter->save('php://output');
}
else {

header("Location: index.php");
die();
}
?>