<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_ost'] == 1) && ($_SESSION['vot_priv_ost'] == 1)) {

if (isset($_SESSION['shtrihkod_array'])) {$shtrihkod_array = $_SESSION['shtrihkod_array']; unset($_SESSION['shtrihkod_array']);}

$shtrihkod_array=defender_sql($shtrihkod_array);

   if (isset($shtrihkod_array['k'])) {$kateg = $shtrihkod_array['k']; if ($kateg == '') {unset($kateg);}}
   if (isset($shtrihkod_array['t'])) {$tovar = $shtrihkod_array['t']; if ($tovar == '') {unset($tovar);}}
   if (isset($shtrihkod_array['kc'])) {$kol = $shtrihkod_array['kc']; if ($kol == '') {$kol = 0;}}
   if (isset($shtrihkod_array['al'])) {$alert = $shtrihkod_array['al'];} else {$alert = '';}
   if (isset($shtrihkod_array['sh'])) {$shtr = $shtrihkod_array['sh'];} else {$shtr = '';}
   if (isset($shtrihkod_array['r'])) {$rangr = $shtrihkod_array['r'];} else {$rangr = '';}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Добавление штрих-кодов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<style type="text/css">
   INPUT {width: 100px;}
  </style>

</head>

<body>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_shtrihk_sernum.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="4" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none" height="20px"><b><p>Добавить штрих-код/серийный номер</p></b></td>
    </tr>
<?php
if ($alert <> '') {
printf('
  <tr bgcolor="#dce6ee">
  	<td width="25" height="50" colspan="4"><p style="text-align:center; font-size:14px; color:red;"><strong>Этот серийный номер уже существует в базе!</strong></p></td>
    </tr>
');	
	}
	
if ($kol > '0') {

$select_string = '<select name="rangrand" id="rangrand">';
for ($i=8; $i<=16; $i++) {
	if ($rangr == $i) {$select_string .= '<option selected value="'.$i.'">'.$i.'</option>';}
    else {$select_string .= '<option value="'.$i.'">'.$i.'</option>';}
	}
$select_string .= '</select>';
	
printf('
  <tr bgcolor="#ecf2f6">
  	<td width="100" align="left">
	<p>Штрих-код:</p>
  	</td>
  	<td width="130" align="center">
	<input style="width:130px;" type="text" name="shtrih" value="%s" id="shtih_input">
  	</td>
	<td width="100" align="center">
	<input type="button" value="Сгенерировать" onClick="generator_shtih();">
  	</td>
	<td width="70" align="center">
	<input type="button" style="width:70px" value="Очистить" onClick="clear_input_shtih();">
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="100" align="left">
	<p>Серийник:%s</p>
  	</td>
  	<td width="130" align="center">
	<input style="width:130px;" type="text" name="serialnum" value="%s" id="serial_input">
  	</td>
	<td width="100" align="center">
	<input type="button" value="Сгенерировать" onClick="generator_serial();">
  	</td>
	<td width="70" align="center">
	<input type="button" style="width:70px" value="Очистить" onClick="clear_input_serial();">
  	</td>
    </tr>
',$shtr,$select_string,$alert);

$kol_more = $kol - 1;

if ($kol_more > 0) {
printf('
  <tr bgcolor="#ecf2f6">
  	<td width="25" height="20" colspan="4"><p>Осталось еще <strong>%s</strong> позиций.</p></td>
    </tr>
',$kol_more);
}
else {
printf('
  <tr bgcolor="#ecf2f6">
  	<td width="25" height="20" colspan="4"><p>Это последняя позиция.</p></td>
    </tr>
');	
}
}

?>
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" type="button" value="Сохранить" onclick="javascript: form_send(this.form);"></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ><input type="hidden" name="kategory" value="<?php echo $kateg;?>"><input type="hidden" name="tovar" value="<?php echo $tovar;?>"><input type="hidden" name="kolichestvo" value="<?php echo $kol;?>"></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script>
function form_send(_form) { 
_form.submit(); 
}

$(document).ready(function() {
	var shtrih = document.getElementById('shtih_input').value;
	if (shtrih == '') {$("#shtih_input").focus();}
	else {$("#serial_input").focus();} 
});

function clear_input_shtih() {
	$("#shtih_input").val('');
}
function clear_input_serial() {
	$("#serial_input").val('');
}

function generator_shtih()
{
    var numb = 2 + "<?php echo substr(str_pad($kateg, 2, '0', STR_PAD_LEFT), -2, 2).substr(str_pad($tovar, 2, '0', STR_PAD_LEFT), -2, 2); ?>";
    var text = '';
    var possible = '0123456789';

    for(var i=0; i < 7; i++)
    {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    	
    numb += text;
	
//chack sum generator
	
	var sum_o = parseInt(numb[0])+parseInt(numb[2])+parseInt(numb[4])+parseInt(numb[6])+parseInt(numb[8])+parseInt(numb[10]);
	var sum_e = (parseInt(numb[1])+parseInt(numb[3])+parseInt(numb[5])+parseInt(numb[7])+parseInt(numb[9])+parseInt(numb[11]))*3;	
	var checksum_value = sum_o + sum_e;	
	var checksum_digit = 10 - (checksum_value % 10);	
	if (checksum_digit == 10) {checksum_digit = 0;}	
	numb += checksum_digit;

//chack sum generator
	
	$("#shtih_input").val(numb);
}

function generator_serial()
{   
    var n = $("#rangrand option:selected").val();
	if(!n){n = 8;}
    var text = '';
//    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var possible = 'ABCDEF0123456789';
    for(var i=0; i < n; i++)
    {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

	$("#serial_input").val(text);
}
</script>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>