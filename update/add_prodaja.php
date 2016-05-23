<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_pro'] == 1) && ($_SESSION['vot_priv_pro'] == 1)) {

if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['selector_of_stores'] =$_SESSION['id_mag']['1'];}
				else {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
			}
		
	}

if (isset($_SESSION['id_prodaja'])) {unset ($_SESSION['id_prodaja']);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы работ</title>

<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<link href="../autocomplete/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../autocomplete/jquery.autocomplete.js"></script>

<style type="text/css">
   SELECT {width: 205px;}
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
</style>

<!--<script src="../arcticmodal/jquery.min.js"></script>
<script src="../arcticmodal/jquery.arcticmodal-0.3.min.js"></script>
<script>jq = jQuery.noConflict(true);</script>
<link rel="stylesheet" href="../arcticmodal/jquery.arcticmodal-0.3.css">
<link rel="stylesheet" href="../arcticmodal/themes/simple.css">-->

</head>

<body>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_prodaja.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none; height:20px;"><b><p>Добавить работу</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee" height="20">
  	<td width="200"><p>Дата:</p></td>
  	<td align="center"><p align="ceenter"><?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?></p><input name="data" type="hidden" value="<?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?>"><input name="prnt_id" type="hidden" value="<?php if (isset($_GET['prnt_id'])) {echo $_GET['prnt_id'];} ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td>
 <select name="magazine" id="mag"> 			
<?php
if ((isset($_GET['prnt_id'])) && ($_GET['prnt_id'] <> '')) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_magaz'],$_SESSION['name_magaz']); unset($_SESSION['id_magaz']); unset($_SESSION['name_magaz']);}
else {

//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no+1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
if ($_SESSION['id_mag'][$no+1] == 'all') {$no++;}
}
while($no < $_SESSION['count_mag']);
}
 ?>
</select>
  	</td>
    </tr>   
  <tr bgcolor="#dce6ee">
    <td><p>Тип:</p></td>
  	<td><select name="b"><option title="Используется для продажи товаров из условной подкатегории аксесуары" value="А">Аксесуар</option><option title="Используется для продажи товаров из условной подкатегории материалы" value="М">Материал</option><option title="Используется для продажи материал и выполненых работ" value="МР">Материал+Работа</option><option title="Используется для продажи только работ, в этом случае не нужно задавать категорию и наименование материалов" value="Р">Работа</option></select></td>
  </tr>
<!--  <tr bgcolor="#ecf2f6">
    <td><p style="vertical-align:middle;">Штрих-код:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Очистка" style="width:70px;" onClick="javascript: clear_input();" id="example_clear"></p></td>
  	<td><input type="text" name="shtrihkod" id="example"></td>
  </tr>     -->
  <tr bgcolor="#ecf2f6">
	<td><p>Категория:</p></td>
  	<td>
  		<select name="kategory" id="kat"><option value="">Выберите категорию</option>
  			<?php 

$result_kat = mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` WHERE `ID` IN ( SELECT DISTINCT `ID_kategorii` FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ) ORDER BY `kateg`",$db);	


while ($myrow_kat = mysql_fetch_array($result_kat)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_kat["ID"], $myrow_kat["kateg"]);
	
	}
//$result_kat = mysql_query("SELECT DISTINCT `ID_kategorii` FROM sklad_tovaru WHERE ID_magazina = '{$_SESSION['id_mag_selected']}'",$db);
//$myrow_kat = mysql_fetch_array($result_kat);  
//do {
//$result = mysql_query("SELECT `ID`,`kateg` FROM sklad_kategorii WHERE ID = '{$myrow_kat['ID_kategorii']}' ORDER BY `kateg`",$db);	
//$myrow = mysql_fetch_array($result);
	
//     printf ("<option value='%s'>%s</option>" , $myrow["ID"], $myrow["kateg"]);
//    }
//while ($myrow_kat = mysql_fetch_array($result_kat));
  			
  			?>
  		</select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Наименование:</p></td>
  	<td><div id="akc" align="center"></div><select name="tovar" id="tov"></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td height="20"><p>Вознаграждение:</p></td>
  	<td id="voznagj"></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td height="20"><p>Стоимость материалов:</p></td>
  	<td id="stoim"></td>
    </tr>
<!--  <tr bgcolor="#dce6ee">
	<td height="20"><p>Серийный номер:</p></td>
  	<td id="sernum"><input type="text" name="serialn" value="Введите и нажмите Enter" id="input_sernum"></td>
    </tr> -->
  <tr bgcolor="#ecf2f6">
    <td height="20"><p>Тип работы:</p></td>
  	<td><select name="operator" id="operator"><option value=""></option><?php 

$result_op = mysql_query("SELECT `ID`,`oper` FROM operatoru ORDER BY `oper`",$db); 		
$myrow_op = mysql_fetch_array($result_op);  		
 do {
 printf ("<option value='%s'>%s</option>" , $myrow_op["ID"], $myrow_op["oper"]);	
 }
 while ($myrow_op = mysql_fetch_array($result_op));  		
  		
  		
  		?></select></td>
  </tr>
  <tr bgcolor="#dce6ee">
	<td height="20"><p>Работа:</p></td>
  	<td><select name="tarifplan" id="tarpl"><option value=""></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td height="20"><p>Вознаграждение за работу:</p></td>
  	<td id="voznagtp"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td height="20"><p>Оплата за работу:</p></td>
  	<td id="oplata"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Марка авто:</p></td>
  	<td><input type="text" name="kluch_evdo" value=""></td>
    </tr> 
  <tr bgcolor="#dce6ee">
	<td><p>Контактный номер телефона:</p></td>
  	<td><input type="text" name="kontakt_nom_tel" value="<?php if (isset($_SESSION['kontakt_nom_tel'])) {echo $_SESSION['kontakt_nom_tel']; unset($_SESSION['kontakt_nom_tel']);}?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><input type="text" name="fio" value="<?php if (isset($_SESSION['fio_abon'])) {echo $_SESSION['fio_abon']; unset($_SESSION['fio_abon']);}?>"></td>
    </tr>  
  <tr bgcolor="#dce6ee">
	<td><p>Абонентский номер:</p></td>
  	<td><input type="text" name="abon_nomer" value="<?php if (isset($_SESSION['abon_nomer'])) {echo $_SESSION['abon_nomer']; unset($_SESSION['abon_nomer']);}?>"></td>
    </tr>
 <tr bgcolor="#ecf2f6">
	<td><p>Место пользования:</p></td>
  	<td><input type="text" name="mesto_polz" value="<?php if (isset($_SESSION['mesto_polz'])) {echo $_SESSION['mesto_polz']; unset($_SESSION['mesto_polz']);}?>"></td>
    </tr>  
  <tr bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td><input type="text" name="skidka" value=""></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Примечание:</p></td>
  	<td><textarea cols="30" rows="1" name="primech" value=""></textarea>
  	</td>
    </tr>

  <?php 
  if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
  printf("<tr bgcolor=\"#dce6ee\"><td><p>Продавец:</p></td><td><select name = 'user'>");
  $res_usr = mysql_query("SELECT `ID`, `login` FROM `users`",$db);
  $myr_usr = mysql_fetch_array($res_usr);
  do {
  	if ($myr_usr['login'] == $_SESSION['login']) {printf ("<option selected='selected' value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}
  	else {printf ("<option value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}  	
  	} while ($myr_usr = mysql_fetch_array($res_usr));
  printf("<td></tr>");
  } else {
  	printf("<input type='hidden' name='user' value='%s'>",$_SESSION['user_id']);
  	}
	
  $res_check_beznal = mysql_query("SELECT `terminal` FROM `magazinu` WHERE `ID` = '{$_SESSION['id_mag_selected']}'",$db);
  $myr_check_beznal = mysql_fetch_array($res_check_beznal);
  if ($myr_check_beznal['terminal'] <> 'no') {
  printf("<tr bgcolor=\"#ecf2f6\"><td><p>Способ оплаты:</p></td><td><select name= 'sposob_oplatu'>");
  if ($myr_check_beznal['terminal'] == 'k') {printf("<option title='Оплата наличкой: деньги за оборудование идут в кассу магазина, деньги за тарифный план или за акционное оборудование оператора тоже идут в кассу, с персонального счета оператора деньги за тарифный план или за акционное оборудование изымаются' selected='selected' value='k'>Оплата наличкой</option>");} else {printf("<option title='Оплата наличкой: деньги за оборудование идут в кассу магазина, деньги за тарифный план или за акционное оборудование оператора тоже идут в кассу, с персонального счета оператора деньги за тарифный план или за акционное оборудование изымаются' value='k'>Оплата наличкой</option>");}
  if ($myr_check_beznal['terminal'] == 't') {printf("<option title='Безнал для физического лица: деньги за оборудование идут на безналичный счет предпринимателя, деньги за тарифный план или за акционное оборудование также идут на безналичный счет, с персонального счета оператора деньги за тарифный план или за акционное оборудование изымаются' selected='selected' value='tf'>Безнал для физического лица</option><option title='Безнал для юридического лица: деньги за оборудование идут на безналичный счет предпринимателя, деньги за тарифный план или за акционное оборудование идут напрямую на счет оператора, с персонального счета оператора деньги не изымаются' value='tu'>Безнал для юридического лица</option>");} else {printf("<option title='Безнал для физического лица: деньги за оборудование идут на безналичный счет предпринимателя, деньги за тарифный план или за акционное оборудование также идут на безналичный счет, с персонального счета оператора деньги за тарифный план или за акционное оборудование изымаются' value='tf'>Безнал для физического лица</option><option title='Безнал для юридического лица: деньги за оборудование идут на безналичный счет предпринимателя, деньги за тарифный план или за акционное оборудование идут напрямую на счет оператора, с персонального счета оператора деньги не изымаются' value='tu'>Безнал для юридического лица</option>");}
  printf("</td></tr>"); 
  } 
  ?>
   
 </table>
<div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="100" align="center"><input style="width:100px;" name="save" type="button" value="Сохранить" onclick="javascript: form_send(this.form);"></td>
    <td width="100" align="center"><input style="width:100px;" name="save" type="button" value="Добавить еще" onclick="javascript: form_send_add(this.form);"><input style="display:none" type="button" name="save_add"></td>
    <td width="100" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function(){
         $("#mag").change(function(){		 		
         $("#kat").load("./get_kat_from_sklad.php", { mag: $("#mag option:selected").val() });
         });
});

$(document).ready(function(){
         $("#kat").change(function(){		 		
         $("#tov").load("./get_tov_from_sklad.php", { kat: $("#kat option:selected").val(), mag: $("#mag option:selected").val() },

function(){
var kateg = $("#kat option:selected").val();
if (kateg == '') {$("#example").removeAttr("disabled");} else {$("#example").attr("disabled", "disabled");}
if (kateg == '') {$("#example_clear").removeAttr("disabled");} else {$("#example_clear").attr("disabled", "disabled");}
}
		 
		 );
         });
});

$(document).ready(function(){
         $("#tov").change(function(){		 		
         $("#voznagj").load("./get_prodaja_voznagj.php", { tov: $("#tov option:selected").val(), mag: $("#mag option:selected").val() },
         function () {
         $("#stoim").load("./get_prodaja_cena.php", { tov: $("#tov option:selected").val(), mag: $("#mag option:selected").val() },
         function () {
         $("#sernum").load("./get_sernum.php", { tov: $("#tov option:selected").val(), kat: $("#kat option:selected").val() });
         });
         });        
         });
});

$(document).ready(function(){
         $("#operator").change(function(){		 		
         $("#tarpl").load("./get_prodaja_tp.php", { operator: $("#operator option:selected").val() });
         });
});

$(document).ready(function(){
         $("#tarpl").change(function(){		 		
         $("#voznagtp").load("./get_prodaja_voznagtp.php", { tarpl: $("#tarpl option:selected").val() },
         function () {
	      $("#oplata").load("./get_prodaja_tpcena.php", { tarpl: $("#tarpl option:selected").val() });
         });        
         });
});
        
         $("#tarpl").change(function(){
         $("#akc").load("./get_prodaja_akciya_true.php", { tarpl: $("#tarpl option:selected").val(), tov: $("#tov option:selected").val() },
  <!-- setTimeout('secondStep()',1500); -->
function (){  
  var myTextField = document.getElementById('akciyaf').value;
  if (myTextField != ""){        	         			 		
         $("#voznagj").load("./get_prodaja_akc_voznag.php", { tarpl: $("#tarpl option:selected").val(), tov: $("#tov option:selected").val() });
         $("#stoim").load("./get_prodaja_akc_cena.php", { tarpl: $("#tarpl option:selected").val(), tov: $("#tov option:selected").val() });}
       });
      });   


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
$("#example").autocomplete("../autocomplete/autocomplete.php", {
	delay:500,
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
var magazine = $("#mag option:selected").val();
$("#kat").load("../autocomplete/autocomplete_get_kat.php", { identify_tov: identify, mag_id: magazine },
    function () {
		var kategory = $("#kat option:selected").val();
		$("#tov").load("../autocomplete/autocomplete_get_tov.php", { identify_tov: identify, kat_id: kategory, mag_id: magazine },
		    function (){
				var nunber = $("#input_sernum").val(); 
//				var notnunber = $("#undef_sernum").val();
				$("#sernum").load("../autocomplete/autocomplete_get_sern.php", { identify_tov: identify, kat_id: kategory, mag_id: magazine, sernum :  nunber},
				function (){
//					$("#input_sernum").focus();
					 $("#voznagj").load("../autocomplete/autocomplete_get_voznj.php", { identify_tov: identify, kat_id: kategory, mag_id: magazine },
					      function (){
							  $("#stoim").load("../autocomplete/autocomplete_get_stoim.php", { identify_tov: identify, kat_id: kategory, mag_id: magazine }); 
							    });
					    });
				});
		});
}

//function disableid(){
//var kateg = $("#kat option:selected").val();
//if (kateg == '') {$("#example").removeAttr("readonly");} else {$("#example").attr("readonly", "readonly");}
//}
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
function form_send(_form) { 
_form.submit(); 
}

function form_send_add(_form) { 
document.getElementsByName("save_add")[0].setAttribute('type','text');
_form.submit(); 
}

$(document).ready(function() {
 $("#example").focus();
});

function clear_input() {
	$('#example').val('');
	$('#input_sernum').val('');
	$("#example").removeAttr("disabled");
//	document.getElementById('input_sernum').value = "";
	postautocomplete();
}

$(document).ready(function(){
	     	 $("#example").keypress(function(e){
	     	   if(e.keyCode==13){
//	     	   postautocomplete();
			   $('#example').blur();
	     	   }
	     	 });
 
	     });

function keyinfo(event){
	 if(event.keyCode==13){

       var nunber = $("#input_sernum").val();

	    $.ajax({
          type: 'POST',
          url: 'get_response_shtrih.php',
          data: { input: nunber },
          success: function(data){
			  var iddata = data.substring(0,2);
			  if (iddata == 'ID') {
//				  alert(data+' '+data.length);
				  var stringflag = false;
				  var id_kat = '';
				  var id_tov = '';
				  for (var i=2, len=data.length; i<len; i++) {
					  if (data.charAt(i) == '_') {stringflag = true;}
					  else {
					  if (stringflag == false) {id_kat += data.charAt(i);}
                      else {id_tov += data.charAt(i);} 
					  }
					  }					  
//					  alert(id_kat+' '+id_tov);
					  $("#example").val('Не задан');
					  $("#example").attr("disabled", "disabled");
					  var magazine = $("#mag option:selected").val();
					  $("#kat").load("../update/get_serial_kat.php", { idkat: id_kat, idtov: id_tov, magid: magazine },
					     function (){
							 var kategory = $("#kat option:selected").val();							
							 $("#tov").load("../update/get_serial_tov.php", { idtov: id_tov, kateg: kategory  },
							 function (){
								 $("#voznagj").load("../update/get_serial_voznj.php", { idtov: id_tov, magid: magazine, kateg: kategory },
								 function () {
									 $("#stoim").load("../update/get_serial_stoim.php", { idtov: id_tov, magid: magazine, kateg: kategory });
									 });
								 });
							 });
					  
				  }
			  else {
				   $('#example').val(data);
                   postautocomplete();
				  }
			 
          }
        }).done();			   
			   
	}
}
	
</script>

<!--<script type="text/javascript">
//function showmod(){
//	jq('#exampleModal').arcticmodal({
//		afterClose: function(data, el) {
//        alert('afterClose');}
//		});
//		}
//function closemodal(){
//	jq('#exampleModal').arcticmodal('close');
//	}
</script>-->

<!--<div style="display: none;">
    <div class="box-modal" id="exampleModal">
    <div class="box-modal_close arcticmodal-close"><input type="button" value="Закрыть[Х]"></div>
        <div align="center">
        </div>
    </div>
</div>-->

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>