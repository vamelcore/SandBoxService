<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['id'])) {$id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT * FROM otchet WHERE ID = '$id'",$db);
$myrow = mysql_fetch_array($result);
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
                                        <th class="lable">ФИО абонента:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['fio']);?>"></td>
                                </tr><tr>
                                	<th class="lable">Номер абонента:</th>
                                	<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['nomer_abon'];?>"></td></tr>
                               <tr>
                                        <th class="lable">Контактный номер телефона:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['kontakt_nomer'];?>"></td>
                                </tr><tr>
                                	<th class="lable">Пакет:</th>
                                	<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['paket']);?>"></td>
                                	</tr><tr>
                                		<th class="lable">Ключ EVDO:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['kluch_evdo'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Аванс:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['avans'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Оплата с лицевого счета:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['oplata'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Остаток на лицевом счете:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['ostatok'];?>"></td></tr>
                                		<tr>
                                		<th class="lable">Оборудование:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['oborudov']);?>"></td></tr>        
                                <tr>
                                <td align="center" colspan="2">
                                	<table width="100%">
                                	<tr>
                                	<td width="100%" align="center"><input style="width: 100px;" type="button" value="Закрыть" onclick="top.location.href='../archive_popoln.php'"></td>	
                                	</tr>
                                	</table>
                                </td>                                  
                                </tr>
                        </tbody></table>
</form>