<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');
session_start();
if (isset($_GET['id'])) {$id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT oper, schet FROM operatoru WHERE ID = '$id'",$db);
$myrow = mysql_fetch_array($result);
?>

		<h1 class='contact-title'>Пополнение счета:</h1>	
	<br><br>
 <form action="form/update_popolnetie.php" method="post">
 <table>
                                <tbody><tr>
                                        <th class="lable">Имя оператора:</th>
                                        <td class="input"><input name="operator" readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['oper']);?>"></td>
                                </tr><tr><th></th><td><input type="hidden" name="id_op" value="<?php echo $id;?>"><br></td></tr>
                              <tr>
                                        <th class="lable">Состояние счета, грн:</th>
                                        <td class="input"><input name="schet" readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['schet'];?>"></td>
                                </tr><tr><th></th><td><br></td></tr>
                               <tr>
                                        <th class="lable">Попролнить на сумму, грн:</th>
                                        <td class="input"><input name="popolnenie" size="30" maxlength="30" class="input" type="text"></td>
                                </tr><tr><th></th><td><br></td></tr>
                                <tr>
                                         <th class="lable">Пополнить с кассы:</th>
                                         <td>
                                         <select style="width:250px;" id="vubor_magazina" name="magazine"><option selected="selected" value="0">Нет</option>
       <?php
       $i = 1;
					do {
						printf("<option value='%s'>%s</option>", $_SESSION['name_mag'][$i], $_SESSION['name_mag'][$i]);
						$i++;
						if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
					} while (isset($_SESSION['name_mag'][$i]));
       ?>                                              
                                         </select>                                                                                 
                                         </td>
                                </tr>        
                                <tr><tr id="kassa_magazina"><th></th><td><br></td></tr><tr><th></th><td><br></td></tr><tr><th></th><td><br></td></tr>
                                <td align="center" colspan="2">
                                	<table width="100%">
                                	<tr>
                                	<td width="50%" align="center"><input style="width: 100px;" name="cancel" type="button" value="Отмена" onclick="top.location.href='../operatoru.php'"></td>
                                	<td width="50%" align="center"><input style="width: 100px;" name="submit" type="submit" value="Пополнить"></td>	
                                	</tr>
                                	</table>
                                </td>                                  
                                </tr>
                        </tbody></table>
</form>
<script type="text/javascript" >
$(document).ready(function () {
         $("#vubor_magazina").change(function(){		 		
         $("#kassa_magazina").load("./form/get_kassa.php", { mag: $("#vubor_magazina option:selected").val() });
         });
});          
</script>
