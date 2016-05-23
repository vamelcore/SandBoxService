<?php include ("../config.php");
// content="text/plain; charset=utf-8"
require_once ('jpgraph.php');
require_once ('jpgraph_line.php');

session_start();
// Some data
//${'ydata'.$ind} = array(110,3,8,12,5,1,9,130,5,7);
// Create the graph. These two calls are always required
$res_count = mysql_query("SELECT count(*) as total FROM operatoru",$db);
if (mysql_num_rows($res_count) > 0) {
$myr_count = mysql_fetch_assoc($res_count);
$incriment_graf = round(($myr_count['total']/3), 0);
$heigh_graf = 100 + $incriment_graf*80;
}
else {$heigh_graf = 300;}
$graph = new Graph(600,$heigh_graf);
$graph->SetScale('textint');

// Setup margin and titles
$graph->SetMargin(40,10,10,10);
$graph->SetFrame(false);
$graph->title->Set('График выполнения работ по типам');
$graph->subtitle->Set('(за '.$_SESSION['plot_month'].')');
$graph->xaxis->title->Set('Дни месяца');
$graph->yaxis->title->Set('Количество подключений');
$graph->xaxis->SetTextLabelInterval(1);
$graph->xgrid->Show();

//$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->legend->SetLayout(LEGEND_VERT);
$graph->legend->SetColumns(4);
$graph->legend->Pos(0.5,0.9999,"center","bottom");
$graph->legend->SetFillColor('white@0.99');

if (isset($_GET['plot_oper'])) {$plot_oper = $_GET['plot_oper'];}

$result = mysql_query("SELECT data, operator FROM prodaja WHERE sec_data = '{$_SESSION['plot_month']}' AND operator <> '' ORDER BY ID ASC",$db);
$myrow = mysql_fetch_array($result);
$num_count = mysql_num_rows($result);
if ((isset($plot_oper)) && ($plot_oper <> 'all')) {$result_oper = mysql_query("SELECT oper FROM operatoru WHERE ID = '$plot_oper'",$db);}
else {$result_oper = mysql_query("SELECT oper FROM operatoru ORDER BY ID ASC",$db);}

//$myrow_oper = mysql_fetch_array($result_oper);
$num_count_oper = mysql_num_rows($result_oper);

$string_t = $_SESSION['plot_month'];
$date_t = substr($string_t, 3, 6).'-'. substr($string_t, 0, 2);
$day_index = date("t", strtotime($date_t));

$date_array = array();
$operator_array = array();
do {
	$date_array[] = substr($myrow['data'], 0, 10);
	$operator_array[] = $myrow['operator'];	
	} while($myrow = mysql_fetch_array($result));

$ind = 1;

while ($myrow_oper = mysql_fetch_array($result_oper)) {

${'ydata'.$ind} = array();

for ($i=1; $i<=$day_index; $i++) { 

$num = str_pad($i, 2, '0', STR_PAD_LEFT);
$compare_data = $num.'.'.$_SESSION['plot_month'];
$plot_summa = 0;

for ($j=0; $j<$num_count; $j++)	{

if  (($date_array[$j] == $compare_data) && ($operator_array[$j] == $myrow_oper['oper'])) {$plot_summa++;}
   
}

${'ydata'.$ind}[] = $plot_summa;

} 
$graph->img->SetAntiAliasing(false); 
// Create the linear plot
//$lineplot1=new LinePlot($ydata1);
${'lineplot'.$ind}=new LinePlot(${'ydata'.$ind});
//$lineplot->SetColor('blue');
// Add the plot to the graph
//$graph->Add($lineplot1);
$graph->Add(${'lineplot'.$ind});
// Display the graph

${'lineplot'.$ind}->SetWeight(2);

//$name_oper = substr($myrow_oper['oper'], 0, 33);
$name_oper = mb_substr($myrow_oper['oper'],0,18,'UTF-8');
${'lineplot'.$ind}->SetLegend($name_oper);


$ind++;
}
//mysqli_free_result($result);
//mysqli_free_result($result_oper);
//mysqli_close($db);
$graph->Stroke();
?>
