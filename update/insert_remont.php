<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);		
		
      if (isset($_POST['magazine'])) {
      		
      	$magazine = $_POST['magazine'];
      	if ($magazine == '') {unset ($magazine);}
	    $res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazine'",$db);
		$myr_mag=mysql_fetch_array($res_mag);
	  }

      if (isset($_POST['data_priema'])) {$data_priema = $_POST['data_priema'];if ($data_priema == '') {unset ($data_priema);}}
      if (isset($_POST['nomer_tel'])) {$nomer_tel = $_POST['nomer_tel'];if ($nomer_tel == '') {unset ($nomer_tel);}}
      if (isset($_POST['model'])) {$model = $_POST['model'];if ($model == '') {unset($model);}}
      if (isset($_POST['prichina_rem'])) {$prichina_rem = $_POST['prichina_rem'];if ($prichina_rem == '') {unset($prichina_rem);}}
      if (isset($_POST['gar'])) {$gar = $_POST['gar'];if ($gar == '') {unset($gar);}}
	  if (isset($_POST['stoimost'])) {$stoimost = $_POST['stoimost'];if ($stoimost == '') {unset($stoimost);}}
	  if (isset($_POST['zakluch'])) {$zakluch = $_POST['zakluch'];if ($zakluch == '') {unset($zakluch);}}
	  
		
if (isset($_SESSION['id_remont'])) {
		
  if ($_SESSION['ed_priv_rem'] == 1) {		
		
	$id = $_SESSION['id_remont'];
	unset ($_SESSION['id_remont']);
    if ($id == '') {unset ($id);}
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM remontu WHERE ID='$id'",$db); unset ($_POST['delete']);}

     else {

      $res=mysql_query("UPDATE remontu SET magazin = '{$myr_mag['name']}', data_priema = '$data_priema', nomer_tel = '$nomer_tel', model = '$model', prichina_remonta = '$prichina_rem', garantiya = '$gar', stoimost = '$stoimost', zacluchenie = '$zakluch' WHERE ID='$id'",$db);	
}
}
}
else {

  if ($_SESSION['add_priv_rem'] == 1) {	
	
$hours = date('H') + $_SESSION['time_zone']; 
$sec_dat = date ('m.Y', mktime ($hours));

$res=mysql_query("INSERT INTO remontu SET magazin = '{$myr_mag['name']}', data_priema = '$data_priema', nomer_tel = '$nomer_tel', model = '$model', prichina_remonta = '$prichina_rem', garantiya = '$gar', stoimost = '$stoimost', zacluchenie = '$zakluch', sec_data = '$sec_dat'",$db);
}
}

header("Location: ../remontu.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>