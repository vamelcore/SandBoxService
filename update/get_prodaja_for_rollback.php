<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){$id_roll = $_REQUEST['id_roll'];}

//Определние продажи
$result = mysql_query("SELECT * FROM `prodaja` WHERE ID = '$id_roll'",$db);
$myrow = mysql_fetch_array($result);

//Определене ID магазина
if  (!empty($myrow['magazin'])) {
$res_mag=mysql_query("SELECT ID FROM magazinu WHERE name = '{$myrow['magazin']}'",$db);
$myr_mag=mysql_fetch_array($res_mag);}

//Определение ID категории
if  (!empty($myrow['kategoria'])) {
$res_kat=mysql_query("SELECT ID FROM sklad_kategorii WHERE  kateg = '{$myrow['kategoria']}'",$db);
$myr_kat=mysql_fetch_array($res_kat);}

//Определение ID товара
if (!empty($myrow['naimenovanie'])) {
$tov_name_with_slash = addslashes($myrow['naimenovanie']);
$res_tov=mysql_query("SELECT ID FROM prase WHERE ID_kategorii = '{$myr_kat['ID']}' AND tovar = '{$tov_name_with_slash}'",$db);
$myr_tov=mysql_fetch_array($res_tov);}

//Определение оператора
if (!empty($myrow['operator'])) {
$res_op=mysql_query("SELECT ID, priznak, schet FROM operatoru WHERE oper = '{$myrow['operator']}'",$db);
$myr_op=mysql_fetch_array($res_op);}

//Определение тарифного плана
if (!empty($myrow['tarifn_plan'])) {
$res_tp=mysql_query("SELECT ID FROM tarifplan WHERE ID_oper = '{$myr_op['ID']}' AND tarifplan = '{$myrow['tarifn_plan']}'",$db);
$myr_tp=mysql_fetch_array($res_tp);}

//Определение юзера
if (!empty($myrow['user'])) {
$res_usr=mysql_query("SELECT ID FROM users WHERE login = '{$myrow['user']}'",$db);
$myr_usr=mysql_fetch_array($res_usr);}

//Определение уникальности штрих-кода
if (!empty($myrow['serialnum'])) {
$res_shtr=mysql_query("SELECT ID FROM serialnum WHERE serial_number = '{$myrow['serialnum']}'",$db);
if (mysql_num_rows($res_shtr) > 0) {$serialnum_uniq = false;} else {$serialnum_uniq = true;}
}
?>

 <table>
  <tr bgcolor="#dce6ee" style="height:20px;">
    <td width="200"><p>Тип:</p></td>
  	<td width="200"><p><?php echo $myrow['b'] ?><input name="sdata" type="hidden" value="<?php echo $myrow['sec_data'] ?>"></p></td>
  </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Магазин:</p></td>
  	<td><p><?php echo $myrow['magazin'] ?></p><input name="magazine" type="hidden" value="<?php echo $myr_mag['ID'] ?>"><input name="magazine_name" type="hidden" value="<?php echo $myrow['magazin'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Категория:</p></td>
  	<td><p><?php echo $myrow['kategoria'] ?><input name="kategory" type="hidden" value="<?php echo $myr_kat['ID'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Наименование:</p></td>
  	<td><p><?php if ($myrow['akciya'] == 'true'){printf("<div align='left'><strong>Акционное оборудование!</strong></div>");} echo $myrow['naimenovanie']; ?><input name="tovar" type="hidden" value="<?php echo $myr_tov['ID'] ?>"></p></td>
    </tr>
<!--  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Серийный номер устройства:</p></td>
  	<td><p><?php //echo $myrow['serialnum'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Штрих-код:</p></td>
  	<td><p><?php //echo $myrow['shtrihkod'] ?></p></td>
    </tr>-->
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Вознаграждение:</p></td>
  	<td><p><?php echo $myrow['voznag_za_jelezo'] ?><input name="voznag_za_jelezo" type="hidden" value="<?php echo $myrow['voznag_za_jelezo'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
  	<td><p>Стоимость материалов:</p></td>
  	<td><p><?php echo $myrow['stoimost'] ?><input name="stoimost" type="hidden" value="<?php echo $myrow['stoimost'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
  	<td><p>Процент от продажи:</p></td>
  	<td><p><?php echo $myrow['procent_prod'] ?><input name="procent_prod" type="hidden" value="<?php echo $myrow['procent_prod'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
    <td><p>Тип работы:</p></td>
  	<td><p><?php echo $myrow['operator'] ?><input name="operator" type="hidden" value="<?php echo $myr_op['ID'] ?>"><input name="operator_schet" type="hidden" value="<?php echo $myr_op['schet'] ?>"></p></td>
  </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Работа:</p></td>
  	<td><p><?php echo $myrow['tarifn_plan'] ?><input name="tarifplan" type="hidden" value="<?php echo $myr_tp['ID'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Вознаграждение за работу:</p></td>
  	<td><p><?php echo $myrow['voznag_za_tp'] ?><input name="voznag_za_tp" type="hidden" value="<?php echo $myrow['voznag_za_tp'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Оплата за работу:</p></td>
  	<td><p><?php echo $myrow['oplata_tp_podkluchenie'] ?><input name="oplata_tp_podkl" type="hidden" value="<?php echo $myrow['oplata_tp_podkluchenie'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Марка авто:</p></td>
  	<td><p><?php echo $myrow['kluch_evdo'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p><?php echo $myrow['kontakt_nomer_tel'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>ФИО:</p></td>
  	<td><p><?php echo $myrow['FIO'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Абонентский номер:</p></td>
  	<td><p><?php echo $myrow['abonent_nomer'] ?></p></td>
    </tr>
    <tr bgcolor="#ecf2f6" style="height:20px;">
 <td><p>Место пользования:</p></td>
  	<td><p><?php echo $myrow['mesto_polz'] ?></p></td>
    </tr> 
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Скидка:</p></td>
  	<td><p><?php echo $myrow['skidka'] ?><input name="skidka" type="hidden" value="<?php echo $myrow['skidka'] ?>"></p></td>
    </tr> 
  <tr bgcolor="#ecf2f6" style="height:20px;">
	<td><p>Примечание:</p></td>
  	<td><p><?php echo $myrow['add'] ?><input name="sebestoim" type="hidden" value="<?php echo $myrow['sebestoimost'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee" style="height:20px;">
	<td><p>Кем выполнино:</p></td>
  	<td><p><?php echo $myrow['user'] ?><input name="user" type="hidden" value="<?php echo $myrow['user'] ?>"><input name="user_id" type="hidden" value="<?php echo $myr_usr['ID'] ?>"></p></td>
    </tr>
<tr><td><input name="id_roll" type="hidden" value="<?php echo $id_roll ?>"><br></td><td><br></td></tr>
<tr><td colspan="2">
<table width="100%">
<tr><td align="center" colspan="2" style='border-bottom:1px solid #c6d5e1;'><strong>Выполняемые дествия:</strong></td></tr>    
<tr><td width="80%"></td><td width="20%"></td></tr>   
<?php 
//Определение наличия товара в остатках 
if  ((!empty($myrow['magazin'])) && (!empty($myrow['kategoria'])) && (!empty($myrow['naimenovanie']))) {
if  ((!empty($myr_mag['ID'])) && (!empty($myr_kat['ID'])) && (!empty($myr_tov['ID']))) {
	
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM sklad_tovaru WHERE ID_magazina = '{$myr_mag['ID']}' AND ID_kategorii = '{$myr_kat['ID']}' AND ID_tovara = '{$myr_tov['ID']}'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);
if  (!empty($myr_sklad['ID'])) {printf ("<tr><td style='border-bottom:1px solid #c6d5e1;'>Возврат товара на остатки:<input name='ID_sklada' type='hidden' value='%s'></td><td style='border-bottom:1px solid #c6d5e1;'><strong>+1</strong> шт<input name='Kol_na_sklade' type='hidden' value='%s'></td></tr>",$myr_sklad['ID'],$myr_sklad['kolichestvo']);}
else {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Создание товара на остатках с количеством:<input name='Add_sklad' type='hidden' value='true'></td><td style='border-bottom:1px solid #c6d5e1;'><strong>+1</strong> шт</td></tr>");}
} else {
	if  (empty($myr_mag['ID'])) {printf("<tr><td id='dissubmit' collspan=2 style='border-bottom:1px solid #c6d5e1;'><p style='color:red;'>В базе данных отсутствует такой магазин!</p></td></tr>");}
	if  (empty($myr_kat['ID'])) {printf("<tr><td id='dissubmit' collspan=2 style='border-bottom:1px solid #c6d5e1;'><p style='color:#078c17;'>В базе данных отсутствует такая категория!</p></td></tr>");}
	if  (empty($myr_tov['ID'])) {printf("<tr><td id='dissubmit' collspan=2 style='border-bottom:1px solid #c6d5e1;'><p style='color:#078c17;'>В базе данных отсутствует товар с таким именем!</p></td></tr>");}
	}
}

if ($myrow['sposob_opl'] == 'tf') {
$summa_beznal = $myrow['stoimost'] + $myrow['oplata_tp_podkluchenie'] - $myrow['skidka'];
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы на безналичном счету :</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Beznal' type='hidden' value='%s'></td></tr>",$summa_beznal,$summa_beznal);
}
elseif ($myrow['sposob_opl'] == 'tu') {
if ($myrow['akciya'] == 'true') {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Из-за акционного оборудования для юридического лица сумма на безналичном счету не изменяется</td><td style='border-bottom:1px solid #c6d5e1;'></td></tr>");}
else {
$summa_beznal = $myrow['stoimost'] - $myrow['skidka'];
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы на безналичном счету :</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Beznal' type='hidden' value='%s'></td></tr>",$summa_beznal,$summa_beznal);
}
}
else {
$summa_vkasse = $myrow['stoimost'] + $myrow['oplata_tp_podkluchenie'] - $myrow['skidka'];
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы в кассе магазина <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Kassa' type='hidden' value='%s'></td></tr>",$myrow['magazin'],$summa_vkasse,$summa_vkasse);
}

if ((isset($myrow['serialnum'])) && ($myrow['serialnum'] <> '')) {
if ($serialnum_uniq == true) {
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Добавление записи в таблицу серийных номеров:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong><input name='serialn' type='hidden' value='%s'></td></tr>",$myrow['serialnum'],$myrow['serialnum']);		
		}
else {
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Этот серийный номер уже присутствует в таблице:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong></td></tr>",$myrow['serialnum']);	
	}
}

if ((isset($myrow['shtrihkod'])) && ($myrow['shtrihkod'] <> '')) {
printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Добавление записи в таблицу штрих-кодов:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong><input name='shtrihkod' type='hidden' value='%s'></td></tr>",$myrow['shtrihkod'],$myrow['shtrihkod']);
}

if ((isset($myr_op['ID'])) && (isset($myr_tp['ID']))) {
 if ((isset($myr_kat['ID'])) && (isset($myr_tov['ID']))) {	
//	    $res_akc=mysql_query("SELECT ID, cena, voznag FROM akciya WHERE ID_kateg = '{$myr_kat['ID']}' AND ID_tov = '{$myr_tov['ID']}' AND ID_oper = '{$myr_op['ID']}' AND ID_tp = '{$myr_tp['ID']}' LIMIT 1",$db);	
//	    if (mysql_num_rows($res_akc) == 1) {
		if ($myrow['akciya'] == 'true') {
		       $summa_akc=$myrow['stoimost'] + $myrow['oplata_tp_podkluchenie'];
			     if ($myrow['sposob_opl'] == 'tu') {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Поскольку этот тарифный план был продан по безналичному расчету для юридического лица, то сумма на персональном счету оператора не меняется</td><td style='border-bottom:1px solid #c6d5e1;'><input name='Schet_op' type='hidden' value='0'></td></tr>");}
				 else {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Увеличение суммы в <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Schet_op' type='hidden' value='%s'></td></tr>",$myrow['operator'],$summa_akc,$summa_akc);}
		       $zarplata_akc=$myrow['voznag_za_jelezo'] + $myrow['voznag_za_tp'] + $myrow['procent_prod'];
		       printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы зарплаты <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Zarplata' type='hidden' value='%s'></td></tr>",$myrow['user'],$zarplata_akc,$zarplata_akc);
		} 		
		else {
	          if ($myr_op['priznak'] == 'Тарыфный план') {$myr_rahunok = $myrow['oplata_tp_podkluchenie'];}
	          if ($myr_op['priznak'] == 'Оборудование') {$myr_rahunok = $myrow['stoimost'];}
	          if ($myr_op['priznak'] == 'Тарыфный план + Оборудование') {$myr_rahunok = $myrow['oplata_tp_podkluchenie'] + $myrow['stoimost'];}
			    if ($myrow['sposob_opl'] == 'tu') {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Поскольку этот тарифный план был продан по безналичному расчету для юридического лица, то сумма на персональном счету оператора не меняется</td><td style='border-bottom:1px solid #c6d5e1;'><input name='Schet_op' type='hidden' value='0'></td></tr>");}
				else {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Увеличение суммы в <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Schet_op' type='hidden' value='%s'></td></tr>",$myrow['operator'],$myr_rahunok,$myr_rahunok);}
			  $summa_zarplata = $myrow['voznag_za_jelezo'] + $myrow['voznag_za_tp'] + $myrow['procent_prod'];
              printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы зарплаты <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Zarplata' type='hidden' value='%s'></td></tr>",$myrow['user'],$summa_zarplata,$summa_zarplata);
		}		
 } 
 else {
      if ($myrow['sposob_opl'] == 'tu') {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Поскольку этот тарифный план был продан по безналичному расчету для юридического лица, то сумма на персональном счету оператора не меняется</td><td style='border-bottom:1px solid #c6d5e1;'><input name='Schet_op' type='hidden' value='0'></td></tr>");}
      else {printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Увеличение суммы в <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Schet_op' type='hidden' value='%s'></td></tr>",$myrow['operator'],$myrow['oplata_tp_podkluchenie'],$myrow['oplata_tp_podkluchenie']);}
      printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы зарплаты <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Zarplata' type='hidden' value='%s'></td></tr>",$myrow['user'],$myrow['voznag_za_tp'],$myrow['voznag_za_tp']);
	  }
} 
else {
	$summa_zarplata = $myrow['voznag_za_jelezo'] + $myrow['procent_prod'];
	printf("<tr><td style='border-bottom:1px solid #c6d5e1;'>Уменьшение суммы зарплаты <strong>%s</strong>:</td><td style='border-bottom:1px solid #c6d5e1;'><strong>%s</strong> грн<input name='Zarplata' type='hidden' value='%s'></td></tr>",$myrow['user'],$summa_zarplata,$summa_zarplata);
}	
?>
</table>
</td></tr>
</table>