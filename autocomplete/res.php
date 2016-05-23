<?php include ("../config.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Видача результатів</title>

	
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="jquery.autocomplete.js"></script>
<link href="autocomplete.css" rel="stylesheet" type="text/css" />
</head>

<body background="../tst/img/patt_4b9f5cb135827.jpg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="border-bottom:1px solid white;">
	<?php include ("../tst/incl/header_reg.php") ?>  
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td width="150">
	<?php include ("../tst/incl/menu_reg.html");?>	
	</td>
	<td align="center" valign="top" bgcolor="#9dcadf">
	<h4>Пошук результатів аналізів</h4>
	<p>&nbsp;</p>
	<form action="../tst/result_view.php" method="post">
	
	<p>Прізвище пацієнта <input name="fio" type="text" id="example" /></p><br><br><br><br><br><br><br><br><br><br><input name="test" type="text" id="test"/><br><select id="test2"><option value="yes">test</option></select><br>
	<input name="" type="submit" value="Пошук">
	</form>
	
	<!--<p align="left">БЛАНКИ<br>
	
	<a href="results/urohenit_inf_blank.php">Урогенітальні інфекції</a><br>
	<a href="results/torch_inf_blank.php">TORCH</a><br>
	<a href="results/tyroidna_panel_blank.php">Тироїдна панель</a><br>
	<a href="results/prenat_diag_blank.php">Пренатальна діагностика</a><br>
	<a href="results/afp_estr_bganad_blank.php">Альфафетопротеїн-естріол-бетаХГЧ</a><br>
	<a href="results/papa_estr_bganad_blank.php">PAP-A-естріол-бетаХГЧ</a><br>
	<a href="results/reprodukt_panel_blank.php">Репродуктивна панель</a></p>
	-->
	
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>

<script type="text/javascript">
$(document).ready(function(){

function liFormat (row, i, num) {
	var result = row[0]+ '<p class=qnt>' + row[1] + '</p>';
	return result;
}
function selectItem(li) {
	if( li == null ) var sValue = 'А ничего не выбрано!';
	if( !!li.extra ) var sValue = li.extra[0];
	else var sValue = li.selectValue;
}

// --- Автозаполнение2 ---
$("#example").autocomplete("autocomplete.php", {
	delay:400,
	minChars:1,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:20,
	onItemSelect:selectItem
}); 
// --- Автозаполнение2 ---
});

function postautocomplete(){
var identify = $("#example").val();
//$("#test").val(value);
$("#test2").load("autocomplete_get_kat.php", { identify_tov: identify });
}


/*$("#example").keyup(function(){ 
                   alert("Hello");
        });*/
//$(document).ready(function() {
//$("#example").blur(function () {
//setTimeout('newe()', 1000);});
//
//
//})

//    $("#example").keyup(function(){
//	var ident_value = $(this).val();	 
//     $("#test").load("get_kat.php", { identify_tov: $ident_value });   
//    });


</script>

</body>
</html>