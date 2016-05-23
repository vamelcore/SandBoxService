<?php include ("../config.php");

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
if (isset($_REQUEST['procent_array'])) {$procent_array = $_REQUEST['procent_array'];

$xss=mysql_real_escape_string($procent_array);

$result = mysql_query("SELECT procent FROM payment_dilers WHERE name = '$xss' LIMIT 1",$db);
if (mysql_num_rows($result) > 0) {
	$myrow = mysql_fetch_array($result);
	printf('<input style="width:50px;" type="text" name="procent_stavka" value="%s">',$myrow['procent']);
	}
	else {
		printf('<input style="width:50px;" type="text" name="procent_stavka" value="0">');
		}
}
else {
	printf('<input style="width:50px;" type="text" name="procent_stavka" value="0">');
	}
	
}
?>