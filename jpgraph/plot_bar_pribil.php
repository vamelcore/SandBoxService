<?php include ("../config.php");

require_once ('jpgraph.php');
require_once ('jpgraph_bar.php');

session_start();
//$_SESSION['plot_month'] = '11.2014';
$string_t = $_SESSION['plot_month'];
$date_t = substr($string_t, 3, 6).'-'. substr($string_t, 0, 2);
$day_index = date("t", strtotime($date_t));



$res_pashodu = mysql_query("SELECT `p_m`, `summ` FROM `rashodu` WHERE `sec_data` = '{$_SESSION['plot_month']}'",$db);
$rashodu_plus_all = 0; $rashodu_minus_all = 0;
if (mysql_num_rows($res_pashodu) > 0) {
while ($myr_pashodu = mysql_fetch_array($res_pashodu)) {

if ($myr_pashodu['p_m'] == 'plus') {$rashodu_plus_all = $rashodu_plus_all + $myr_pashodu['summ'];}
if ($myr_pashodu['p_m'] == 'minus') {$rashodu_minus_all = $rashodu_minus_all + $myr_pashodu['summ'];}

}
$rashodu_all = round((($rashodu_plus_all - $rashodu_minus_all)/$day_index), 2);

}
else {$rashodu_all = 0;}



$result = mysql_query("SELECT data, stoimost, sebestoimost, skidka FROM prodaja WHERE sec_data = '{$_SESSION['plot_month']}' AND `akciya` <> 'true' ORDER BY ID ASC",$db);

$num_count = mysql_num_rows($result);

$date_array = array();
$stoimost_array = array();
$sebestoimost_array = array();
$skidka_array = array();
while($myrow = mysql_fetch_array($result)) {
	$date_array[] = substr($myrow['data'], 0, 10);
	$stoimost_array[] = $myrow['stoimost'];
	$sebestoimost_array[] = $myrow['sebestoimost'];
	$skidka_array[] = $myrow['skidka'];	
} 

$res_zarplata_rashod = mysql_query("SELECT data, polniy_den, polov_dnya, voznag_za_tp, prodaja, procent, shtraf, bonus FROM `zarplata` WHERE `data` LIKE '%{$_SESSION['plot_month']}'",$db);

$num_zp_count = mysql_num_rows($res_zarplata_rashod);

$date_zp_array=array();
$rashod_zp_poln_den=array();
$rashod_zp_pol_dnya=array();
$rashod_zp_prod_tp=array();
$rashod_zp_prod_j=array();
$rashod_zp_proc=array();
$rashod_zp_shtraff=array();
$rashod_zp_bonus=array();
while ($myr_zarplata_rashod = mysql_fetch_array($res_zarplata_rashod)) {
$date_zp_array[] = $myr_zarplata_rashod['data'];
$rashod_zp_poln_den[] = $myr_zarplata_rashod['polniy_den'];
$rashod_zp_pol_dnya[] = $myr_zarplata_rashod['polov_dnya'];
$rashod_zp_prod_tp[] = $myr_zarplata_rashod['voznag_za_tp'];
$rashod_zp_prod_j[] = $myr_zarplata_rashod['prodaja'];
$rashod_zp_proc[] = $myr_zarplata_rashod['procent'];
$rashod_zp_shtraff[] = $myr_zarplata_rashod['shtraf'];
$rashod_zp_bonus[] = $myr_zarplata_rashod['bonus'];
}


$graph = new Graph(1120,300);    
$graph->SetScale("textint");
$graph->SetShadow();

$graph->title->Set("График чистой прибыли по дням");
$graph->subtitle->Set('(за '.$_SESSION['plot_month'].')');
$graph->xaxis->title->Set("Дни месяца");
$graph->yaxis->title->Set("Сумма, грн");
//$graph->xaxis->title->SetMargin(30);
$graph->yaxis->title->SetMargin(30);
$graph->img->SetMargin(70,10,10,10);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xgrid->Show();

$graph->legend->SetLayout(LEGEND_VERT);
$graph->legend->SetColumns(4);
$graph->legend->Pos(0.5,0.9999,"center","bottom");
$graph->legend->SetFillColor('white@0.99');

$datay=array();


for ($i=1; $i<=$day_index; $i++) { 

$num = str_pad($i, 2, '0', STR_PAD_LEFT);
$compare_data = $num.'.'.$_SESSION['plot_month'];
$plot_summa = 0;
$prod_summa = 0; 
$zp_summa = 0;
for ($j=0; $j<$num_count; $j++)	{
if  ($date_array[$j] == $compare_data) {$prod_summa = $prod_summa + ($stoimost_array[$j] - $sebestoimost_array[$j] - $skidka_array[$j]);}  
}

for ($j=0; $j<$num_zp_count; $j++)	{
if  ($date_zp_array[$j] == $compare_data) {$zp_summa = $zp_summa + ($rashod_zp_poln_den[$j] + $rashod_zp_pol_dnya[$j] + $rashod_zp_prod_tp[$j] + $rashod_zp_prod_j[$j] + $rashod_zp_proc[$j] - $rashod_zp_shtraff[$j] + $rashod_zp_bonus[$j]);}  
}
$plot_summa = $prod_summa + $rashodu_all - $zp_summa;

if ($plot_summa > 0) {$data1y[] = $plot_summa; $data2y[] = 0;}
else {$data1y[] = 0; $data2y[] = $plot_summa;}
//$data1y[] = $plot_summa;
//$data2y[] = $plot_summa - 100;
}


//$data2y=array(8,2,11,7,14,4);

// Create the graph. These two calls are always required
//$graph = new Graph(310,200);	
//$graph->SetScale("textlin");

//$graph->SetShadow();
//$graph->img->SetMargin(40,30,20,40);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b1plot->SetFillColor("orange");
$b2plot = new BarPlot($data2y);
$b2plot->SetFillColor("blue");

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
//$gbplot = new GroupBarPlot(array($b1plot));
$gbplot->SetWidth(0.5);
// ...and add it to the graPH
$graph->Add($gbplot);

//$graph->title->Set("Example 21");
//$graph->xaxis->title->Set("X-title");
//$graph->yaxis->title->Set("Y-title");

//$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();
?>
