<?php include ("config.php");

$res_add_culum = mysql_query("ALTER TABLE kassa ADD sec_data varchar(100);",$db);

$res_all_from = mysql_query("SELECT ID, data FROM kassa ORDER BY ID ASC;",$db);
$flag = true;
while ($myr_all_from = mysql_fetch_array($res_all_from)) {
$string = substr($myr_all_from['data'], 3, 7);
$ident = $myr_all_from['ID'];
$res_all_to = mysql_query("UPDATE kassa SET sec_data = '$string' WHERE ID = '$ident'",$db);
if (mysql_errno($db) <> 0) {$flag = false;}
}
if ($flag == true) {echo "all done!";}
else {echo "TROUBLE!";}
?>

