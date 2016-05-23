<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['id'])) {$id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT * FROM prodaja WHERE ID = '$id'",$db);
$myrow = mysql_fetch_array($result);

	if ($myrow['b'] == "А") {$type = 'Аксесуар';}
	if ($myrow['b'] == "М") {$type = 'Материал';}
	if ($myrow['b'] == "МР") {$type = 'Материал+Работа';}
	if ($myrow['b'] == "Р") {$type = 'Работа';} 

?>

<h1 class='contact-title'>Подробная информация:</h1>
 <form>
 <table>
                                <tbody><tr>
                                        <th class="lable">Дата:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['data'];?>"></td>
                                </tr><tr>
                                	<th class="lable">Магазин:</th>
                                	<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['magazin']);?>"></td></tr>
                              <tr>
                                        <th class="lable">Тип:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $type;?>"></td>
                                </tr><tr>
                                	<th class="lable">Категория:</th>
                                	<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['kategoria']);?>"></td></tr>
                               <tr>
                                        <th class="lable">Наименование:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['naimenovanie']);?>"></td>
                                </tr>
<!--                                <tr>
                                	<th class="lable">Серийный номер устройства:</th>
                                	<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php //echo htmlspecialchars($myrow['serialnum']);?>"></td>
                                	</tr>-->
                                        <tr>
                                		<th class="lable">Стоимость материалов:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['stoimost'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Тип работы:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['operator']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Работа:</th>
                                		<td class="input"><input size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['tarifn_plan']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Оплата за работу:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['oplata_tp_podkluchenie'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Марка авто:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['kluch_evdo'];?>"></td></tr>                          		
                                  <tr>
                                		<th class="lable">Контактний номер телефона:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['kontakt_nomer_tel'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">ФИО:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['FIO']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Абонентский номер:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['abonent_nomer'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Место пользования:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['mesto_polz']);?>"></td></tr>                                		
                                  <tr>
                                		<th class="lable">Скидка:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['skidka'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Примечание:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['add']);?>"></td></tr>                                		                               
                                <tr>
                                <td align="center" colspan="2">
                                	<table width="100%">
                                	<tr>
                                	<td width="100%" align="center"><input style="width: 100px;" type="button" value="Закрыть" onclick="top.location.href='../zarplata.php'"></td>	
                                	</tr>
                                	</table>
                                </td>                                  
                                </tr>
                        </tbody></table>
</form>