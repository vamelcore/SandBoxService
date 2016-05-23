<?php
header('Content-Type: text/html; charset=utf-8');

session_start();
//print_r ($_SESSION['xls_data_array']);
$xls_data_array = $_SESSION['xls_data_array'];
$xls_data_array_summ = $_SESSION['xls_data_array_summ'];


require_once 'PHPExcel.php';
$objPHPExcel = new PHPExcel();

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
$boldredFont = array(
  'font'=>array(
    'name'=>'Arial',
	'color' => array('rgb' => 'CC0000'),
    'size'=>'16',
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

//Закраска ячейки цветом:
$default_border = array(
    'style' => PHPExcel_Style_Border::BORDER_THIN,
    'color' => array('rgb'=>'1006A3')
);
$style_header = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FFCC33'),
    ),
    'font' => array(
        'bold' => true,
    )
);

$style_footer = array(
    'borders' => array(
        'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FFFF00'),
    ),
    'font' => array(
        'bold' => true,
    )
);

// устанавливаем метаданные
$objPHPExcel->getProperties()->setCreator("PHP")
                ->setLastModifiedBy("Sand-BOX")
                ->setTitle("Office 2007 XLSX Дилерам")
                ->setSubject("Office 2007 XLSX Дилерам")
                ->setDescription("Файл с расчетом вознаграждения дилерам")
                ->setKeywords("Расчет вознаграждения дилерам")
                ->setCategory("Новый файл");


$index = 0;

foreach ($xls_data_array as $worksheet => $worksheet_data_array) {
	
	$summ_from_array = '';
	$payment_summ = '';

foreach ($xls_data_array_summ as $summ => $worksheet_data_array_summ) {
	if ($summ == $worksheet) {$summ_from_array = $worksheet_data_array_summ[1]; $summ_from_array_clear = $worksheet_data_array_summ[2];}
	if ($summ == 'summa') {$payment_summ = $worksheet_data_array_summ[0]; $procent_stavka = $worksheet_data_array_summ[1]; $name_for_file = $worksheet_data_array_summ[2]; $payment_summ_clear = $worksheet_data_array_summ[3];}
	}
	
	switch ($worksheet) {
    case 'подкл':
        $summ_in_colum = "вознаграждение";
		$global_summ = "plus";
        break;
    case 'отток':
        $summ_in_colum = "Удержать за отток (удержано)";
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
$x = 0; $y = 1;
while (isset($worksheet_data_array[$x][$y])) {$x_mergeCells = $x; $x++;}


$objPHPExcel->createSheet($index);
$objPHPExcel->setActiveSheetIndex($index);

$objPHPExcel->getActiveSheet()->mergeCells('A1:'.chr(65+$x_mergeCells).'1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Суммарное вознаграждение: '.$payment_summ.' грн.')->getStyle('A1')->applyFromArray($boldredFont)->applyFromArray($style_footer);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);

$x = 0; $y = 1; $z = 3; $xiter = '';
while (isset($worksheet_data_array[$x][$y])) {
	while (isset($worksheet_data_array[$x][$y])) {
		
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x, $z, $worksheet_data_array[$x][$y]);		
if ($z == 3) {
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($x, $z)->applyFromArray($boldFont)->applyFromArray($center)->applyFromArray($style_header);
	if ($worksheet_data_array[$x][$y] == $summ_in_colum) {$xiter = $x;}
	}
else {
	if ($x == $xiter) {
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($x, $z)->applyFromArray($baseFont)->applyFromArray($style_footer);
		if ($worksheet <> 'неокуп') {
			if ($worksheet <> 'отток') {
				$cell_with_procent = round($worksheet_data_array[$x][$y]*($procent_stavka/100), 2);
				}
				else {
					preg_match('/\((.+)\)/', $worksheet_data_array[$x][$y], $cell_with_ottok);
					$cell_with_procent = $cell_with_ottok[1];					
					}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($x, $z, $cell_with_procent);
			}

	}
	else {$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($x, $z)->applyFromArray($baseFont);}	
	$objPHPExcel->getActiveSheet()->getColumnDimension(chr(65+$x))->setAutoSize(true);
	}			
		$x++;
		}
	$x = 0;
	$y++;
	$z++;
	}



if ($summ_from_array <> '') {
$objPHPExcel->getActiveSheet()->mergeCells('A'.$z.':'.chr(65+$x_mergeCells).$z);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$z, 'Сумма по столбцу "'.$summ_in_colum.'" равна: '.$summ_from_array.' грн.')->getStyle('A'.$z)->applyFromArray($boldFont)->applyFromArray($style_footer);
}

$objPHPExcel->getActiveSheet()->setTitle($worksheet);
$index++;
}

$objPHPExcel->setActiveSheetIndex(0);

$filename=$name_for_file.'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
      
require_once 'PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// Если вы хотите, то можете сохранить в другом формате, например, PDF:
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//$objWriter->save('MyExcel.xslx');
$objWriter->save('php://output');
?>