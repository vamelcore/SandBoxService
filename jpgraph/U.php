<?php include ("../config.php");

session_start();
$_SESSION['plot_month'] = '02.2013';
$string_t = $_SESSION['plot_month'];
$date_t = substr($string_t, 3, 6).'-'. substr($string_t, 0, 2);
$day_index = date("t", strtotime($date_t));

$result = mysql_query("SELECT data, stoimost FROM prodaja WHERE sec_data = '{$_SESSION['plot_month']}' ORDER BY ID ASC",$db);

$num_count = mysql_num_rows($result);

$date_array = array();
$stoimost_array = array();
while($myrow = mysql_fetch_array($result)) {
	$date_array[] = substr($myrow['data'], 0, 10);
	$stoimost_array[] = $myrow['stoimost'];	
} 

//print_r($_SESSION['plot_month']);
$ind = 1;




${'ydata'.$ind} = array();

for ($i=1; $i<=$day_index; $i++) { 

$num = str_pad($i, 2, '0', STR_PAD_LEFT);
$compare_data = $num.'.'.$_SESSION['plot_month'];
$plot_summa = 0;

for ($j=0; $j<$num_count; $j++)	{

if  ($date_array[$j] == $compare_data) {$plot_summa = $plot_summa + $stoimost_array[$j];}
   
}

${'ydata'.$ind}[] = $plot_summa;

}
print_r(${'ydata'.$ind}); 
$ydata2=array(12,8,19,3,10,5);
print_r($ydata2);
?>