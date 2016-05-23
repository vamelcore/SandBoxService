<?php include ("../config.php"); 
header('Content-Type: text/html; charset=utf-8');

/*
$result = mysql_query("SELECT FNAME, NAME, ONAME, DOB FROM pacients",$db);
$myrow = mysql_fetch_assoc($result);
do {
$base[] = $myrow["FNAME"]." ".$myrow["NAME"]." ".$myrow["ONAME"].":".$myrow["DOB"].","."\n";
   }
while ($myrow = mysql_fetch_assoc($result));
/*
do {
     print_r ($base);
    }
while ($myrow = mysql_fetch_assoc($result));

//	for($i=0;$i<count($base);$i++){
//	  $row_base = explode(":", $base[$i]);
//	  $res = mb_strpos(mb_strtolower($row_base[0],"UTF-8"), mb_strtolower($_GET['q'],"UTF-8"));
//	  if($res!==false&&$res==0) {
//	  	print $row_base[0]."|".$row_base[1]."\n";
//
//	  }
//    }

*/

if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
if($_GET['q']){ $q=($_GET['q']);
$result = mysql_query("SELECT ID_ketegorii, ID_tovara, shtrih FROM shtrihkod WHERE shtrih LIKE '$q%'",$db);
if (mysql_num_rows($result) > 0) {
$res_kat = mysql_query("SELECT ID, kateg FROM sklad_kategorii ORDER BY ID",$db);
$i = 0; $kategory = array();
while ($myr_kat = mysql_fetch_array($res_kat)) {$kategory['ID'][$i] = $myr_kat['ID']; $kategory['kateg'][$i] = $myr_kat['kateg']; $i++;}
while ($myrow = mysql_fetch_assoc($result)) {
	
	$res_tov = mysql_query("SELECT tovar, cena, voznag FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
	$myr_tov = mysql_fetch_array($res_tov);
    
	for ($j=0; $j<$i; $j++) {if ($myrow["ID_ketegorii"] == $kategory['ID'][$j]) {$kateg_name = $kategory['kateg'][$j];}}

    if (strlen($kateg_name) > 20) {$kateg_name = mb_substr($kateg_name,0,20,'UTF-8').'...';}
    if (strlen($myr_tov["tovar"]) > 20) {$tov_name = mb_substr($myr_tov["tovar"],0,20,'UTF-8').'...';} else {$tov_name = $myr_tov["tovar"];}

    printf("%s|%s - %s - %s грн. - %s грн. &nbsp;\n",$myrow["shtrih"],$kateg_name,$tov_name,$myr_tov["cena"],$myr_tov["voznag"]);
//printf("%s|%s - %s грн. &nbsp;\n",$myrow["shtrih"],$myrow["ID_tovara"],$myrow["ID_ketegorii"]);
}
}
}
}
?>