<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<?php include ("../config.php"); session_start(); 
if (isset($_SESSION['xls_data_array'])) {unset($_SESSION['xls_data_array']);} if (isset($_SESSION['diler_array'])) {unset($_SESSION['diler_array']);}
?>
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


<?php /*?><!--<table>
	<tr>
		<th>Name</th>
		<th>Value</th>
	</tr>
	<?php $count = 0; foreach ($_POST as $name => $value) { ?>
	<tr class="<?php echo $count % 2 == 0 ? 'alt' : ''; ?>">
		<td><?php echo htmlentities(stripslashes($name)); if (htmlentities(stripslashes($name)) =='uploader_0_name') {$filename = nl2br(htmlentities(stripslashes($value)));} ?></td>
		<td><?php echo nl2br(htmlentities(stripslashes($value))) ?></td>
	</tr>
	<?php } ?>
</table>--><?php */
foreach ($_POST as $name => $value) {
if (htmlentities(stripslashes($name)) =='uploader_0_name') {$filename = nl2br(htmlentities(stripslashes($value))); $filename_mysql = nl2br(htmlentities(stripslashes($value)));}
}
?>

<p style="font-size:14px;">Имя файла: <strong><?php echo $filename;?></strong>&nbsp;&nbsp;&nbsp;<input type="button" value="<- Загрузить еще один файл" onClick="top.location.href='uploader.php'" style="width:250px; height:25px; font-size:14px;">&nbsp;&nbsp;&nbsp;<input type="button" value="Анализ загружаемого файла ->" onClick="top.location.href='../PAYment.php'" style="width:250px; height:25px; font-size:14px;"></p>
</br>
</td>
</tr>
<tr>
<td>



<?php
$hours = date('H') + $_SESSION['time_zone']; 
$sec_data = date ('d.m.Y', mktime ($hours));

$ttabs_names = '';
$ttabs_content = '';
$format = 'd.m.Y';

require_once '../PHPExcel/IOFactory.php';
$filename = 'uploads/'.$filename;
//$xls_data_array = array();

$objPHPExcel = PHPExcel_IOFactory::load($filename);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // например, 10
    $highestColumn      = $worksheet->getHighestColumn(); // например, 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;

	switch ($worksheetTitle) {
    case 'подкл':
        $insert_table = "payment_podkl";
		$array_of_colums = array("nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "region", "tip", "oficialn_diler", "proekt", "gruppa_voznag", "kateg_voznag", "tip_voznag", "systema_nalog", "voznagrajdenie", "dop_bonus", "router", "sec_data");
        break;
    case 'отток':
        $insert_table = "payment_ottok";
		$array_of_colums = array("region", "oficialn_diler", "diler", "abonent", "lic_schet", "nomer_tel", "tp_pri_podkl", "tip_tp", "data_podkl", "akciya", "tp_pri_otkl", "data_otkl", "uderjat_za_ottok", "sec_data");
        break;
    case 'неокуп':
        $insert_table = "payment_neokup";
		$array_of_colums = array("nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "data_otkl", "region", "tip", "oficialn_diler", "uderjano", "sec_data");
        break;
    case 'трафик':
        $insert_table = "payment_trafik";
		$array_of_colums = array("region", "oficialn_diler", "diler", "lic_schet", "abonent", "telefon", "tarif_plan", "data_podkl", "bonus", "internet_trafik", "akciya", "paket_v_otchot_mes", "sec_data");
        break;
    case '2ая часть':
        $insert_table = "payment_2chast";
		$array_of_colums = array("poryadok", "nomer", "l_s", "fio_abonenta", "podklucheno", "akciya", "diler", "opisanie", "data", "data_otkl", "region", "tip", "oficialn_diler", "vtoraya_chast_voznag", "sec_data");
        break;
    case 'роутер':
        $insert_table = "payment_router";
		$array_of_colums = array("data", "cena", "l_s", "nomer_telefona", "data_opl_scheta", "klient", "terminal", "diler", "oficialn_diler", "polzovatel", "god", "mesyac", "den", "region_po_dileru", "region_po_nomeru", "summa_nalogu", "tip_voznagrajdeniya", "voznagrajdenie", "sec_data");
        break;
	case 'восстановления':
        $insert_table = "payment_vosstanov";
		$array_of_colums = array("region", "oficialn_diler", "nomer_telefona", "l_s", "data_podkl", "torgovaya_tochka", "klient", "usluga", "operator", "bonus", "sec_data");
        break;
	default:
        $insert_table = "null";
	}
	
	$ttabs_names .= '<span>'.$worksheetTitle.'</span>';
	
	$ttabs_content .= '<div class="tt-panel">'.
	"<br><p style='font-size:14px;'>В таблице \"".$worksheetTitle."\" ".
    $nrColumns . ' колонок (A-' . $highestColumn . ') '.
    ' и ' . $highestRow . ' строк:</p><br>'.
	
    '<table bgcolor=#c6d5e1 border=0 cellpadding=10 cellspacing=2 >';
    for ($row = 1; $row <= $highestRow; ++ $row)
    {
        $ttabs_content .= '<tr>';
		
		$query_string = '';
		
		$flag_not_null = false;
		
        for ($col = 0; $col < $highestColumnIndex; ++ $col) 
        {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
			$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
			
			   if((PHPExcel_Shared_Date::isDateTime($cell)) && ($dataType == 'n')) {
               $val = date($format, PHPExcel_Shared_Date::ExcelToPHP($val)); 
               }
			   
			   if((substr($val,0,1) == '=' ) && (strlen($val) > 1)){
               $boost = $val;
			   $val = $cell->getCalculatedValue();
			   if ($val == "#REF!") {$val = $boost;}
               }
			   
			   if ($val == "") {$val = "(null)";}
			   if ($val <> "(null)") {$flag_not_null = true;}
			   
//			$xls_data_array[$worksheetTitle][$col][$row] = $val;
			if ($row == 1) {$info = '<td bgcolor=#c1cedb>'; $values = '<strong>'.$val.'</strong>';} 
			else {$info = '<td bgcolor=#f6f6f6>'; $values = $val; $xss=mysql_real_escape_string($val); $query_string .= $array_of_colums[$col].'="'.$xss.'", ';}
			if ($val == "(null)") {$values = '<i>'.$values.'</i>';}           
//			$ttabs_content .= $info . $values . '<br>(Тип ' . $dataType . ')</td>';
			$ttabs_content .= $info . $values . '</td>';
        }
		
		if (($insert_table <> "null") && ($row <> 1) && ($flag_not_null == true)) {
			$my_query = 'INSERT INTO '.$insert_table.' SET '.$query_string.'sec_data="'.$sec_data.'", filename="'.$filename_mysql.'"';
			$result = mysql_query($my_query,$db);
			if (mysql_errno($db) <> '0') {
				$informer = "Ошибка MySQL: ".mysql_errno($db).":".mysql_error($db)."\n";
				echo $informer;	
				}					
			}
		
        $ttabs_content .= '</tr>';
    }
    $ttabs_content .= '</table></div>';
}
//$_SESSION['xls_data_array'] = $xls_data_array;
$_SESSION['file_name'] = $filename_mysql;
?>

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
</script>

</body>
</html>
