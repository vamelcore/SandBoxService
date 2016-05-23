<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if ($_SESSION['price_select'] == 'Материалы') {
	if (isset($_SESSION['poisk'])) {
		$res_kat= mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg LIKE '%{$_SESSION['poisk']}%'",$db);
		$myr_kat=mysql_fetch_array($res_kat);
	$result = mysql_query("SELECT * FROM prase WHERE tovar LIKE '%{$_SESSION['poisk']}%' OR cena LIKE '%{$_SESSION['poisk']}%' OR voznag LIKE '%{$_SESSION['poisk']}%' OR ID_kategorii = '{$myr_kat['ID']}'",$db);} else {
		if ($_SESSION['kat_prase'] == 'All') {$result = mysql_query("SELECT * FROM prase ORDER BY ID_kategorii",$db);} else {
		$result = mysql_query("SELECT * FROM prase WHERE ID_kategorii ='{$_SESSION['kat_prase']}'",$db);	
		}
	}
}
else {
	if (isset($_SESSION['poisk'])) {
		$res_op= mysql_query("SELECT `ID` FROM operatoru WHERE oper LIKE '%{$_SESSION['poisk']}%'",$db);
		$myr_op=mysql_fetch_array($res_op);
	$result = mysql_query("SELECT * FROM tarifplan WHERE tarifplan LIKE '%{$_SESSION['poisk']}%' OR stoim_podkl LIKE '%{$_SESSION['poisk']}%' OR voznagtp LIKE '%{$_SESSION['poisk']}%' OR ID_oper = '{$myr_op['ID']}'",$db);} else {
		if ($_SESSION['op_prase'] == 'All')	{$result = mysql_query("SELECT * FROM tarifplan ORDER BY ID_oper",$db);} else {
		$result = mysql_query("SELECT * FROM tarifplan WHERE ID_oper ='{$_SESSION['op_prase']}'",$db);	
		}
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

if ($_SESSION['price_select'] == 'Материалы') {
$page->setCellValue("A1", "Категория")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Имя товара")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Цена")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Вознаграждение")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
} else {
$page->setCellValue("A1", "Тип работы")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Работа")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Стоимость работы")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Вознаграждение")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);	
}
$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);

$no=2;

if ($_SESSION['price_select'] == 'Материалы') {
do {
	$res_kat=mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID ='{$myrow['ID_kategorii']}'");
 $myr_kat=mysql_fetch_array($res_kat);
$page->setCellValue("A".$no, $myr_kat['kateg'])->getStyle('A'.$no)->applyFromArray($baseFont);
$page->setCellValue("B".$no, $myrow['tovar'])->getStyle('B'.$no)->applyFromArray($baseFont);
$page->setCellValue("C".$no, $myrow['cena'])->getStyle('C'.$no)->applyFromArray($baseFont);
$page->setCellValue("D".$no, $myrow['voznag'])->getStyle('D'.$no)->applyFromArray($baseFont);	
$no++;
}
while ($myrow = mysql_fetch_array($result));
} else {
	do {
	$res_op=mysql_query("SELECT `oper` FROM operatoru WHERE ID ='{$myrow['ID_oper']}'");
 $myr_op=mysql_fetch_array($res_op);
$page->setCellValue("A".$no, $myr_op['oper'])->getStyle('A'.$no)->applyFromArray($baseFont);
$page->setCellValue("B".$no, $myrow['tarifplan'])->getStyle('B'.$no)->applyFromArray($baseFont);
$page->setCellValue("C".$no, $myrow['stoim_podkl'])->getStyle('C'.$no)->applyFromArray($baseFont);
$page->setCellValue("D".$no, $myrow['voznagtp'])->getStyle('D'.$no)->applyFromArray($baseFont);	
$no++;
}
while ($myrow = mysql_fetch_array($result));
}
$page->setTitle("Прайс");

$filename='Прайс из раздела'.' '.$_SESSION['price_select'].'.xlsx';
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