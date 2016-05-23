<?php
if (($day >= '26') && ($day <= '30')) {
$res_sysconfig = mysql_query("SELECT `value`, `enabled` FROM `sysconfig` WHERE `param` = 'pay_message'",$db);
$myr_sysconfig = mysql_fetch_array($res_sysconfig);
if ($myr_sysconfig['enabled'] == 'yes') {printf('<p style="font-size:10pt; color:#FF0000">&nbsp;&nbsp;&nbsp;%s</p>',$myr_sysconfig['value']);}
}
?>
