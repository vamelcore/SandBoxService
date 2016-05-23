<?php
$host = 'localhost'; 
$user = 'osmaster_sbglysh'; 
$pass = 'u!a&)Y6o1Gld'; 
$base = 'osmaster_sandbox_glyshutelservise';  


@$db = mysql_connect ($host,$user,$pass);
@mysql_select_db($base,$db);
mysql_query("SET NAMES 'utf8'");
ini_set('display_errors', '0');

?>