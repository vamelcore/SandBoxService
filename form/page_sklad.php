<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');
session_start();
function defender_sql($arr){
    $counter= 0;
    $copy_arr = $arr;
    $filter = array("update","select","group by","from","where","into","set","union","char","order"); 
     foreach($copy_arr as $num=>$xss){
     	  $xss=mysql_real_escape_string($xss);
     	  $xss = strtolower($xss);
        $copy_arr[$num]=str_replace($filter, "WARNING_SQL_INGECT_WORD", $xss, $counter);
     }
     if ($counter == 0) {
     	     foreach($arr as $num=>$xss){
           $arr[$num]=mysql_real_escape_string($xss);
           }
     return $arr;
     }
     else {return $copy_arr;}      
}

if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT ID_kategorii, ID_tovara, kolichestvo FROM sklad_tovaru WHERE ID = '$id'",$db);
$myrow = mysql_fetch_array($result);

$result_kat = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '{$myrow['ID_kategorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat);

$result_tov = mysql_query("SELECT `tovar` FROM prase WHERE ID = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
?>

		<h1 class='contact-title'>Добавление на склад:</h1>	
	<br><br>
 <form action="form/update_sklad.php" method="post">
 <table>
                                <tbody><tr>
                                        <th class="lable">Категория:</th>
                                        <td class="input"><input name="kategory" readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow_kat['kateg']);?>"></td>
                                </tr><tr><th></th><td><input type="hidden" name="id_kat" value="<?php echo $myrow['ID_kategorii'];?>"><br></td></tr>
                              <tr>
                                        <th class="lable">Наименование товара:</th>
                                        <td class="input"><input name="schet" readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow_tov['tovar']);?>"></td>
                                </tr><tr><th></th><td><br><input type="hidden" name="id_tov" value="<?php echo $myrow['ID_tovara'];?>"></td></tr>																
                               <tr>
                                        <th class="lable">Текущее кол-во, шт:</th>
                                        <td class="input"><input name="kolich" readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['kolichestvo'];?>"></td>
                                </tr><tr><th></th><td><br></td></tr>								
                                <tr>
                                        <th class="lable">Добавить, шт:</th>
                                        <td class="input"><input name="add_kolich" size="30" maxlength="30" class="input" type="text" ></td>
                                
                                </tr><tr><th></th><td><br><input name="skl_id" type="hidden" value="<?php echo $id;?>"></td></tr>
<?php if ($_SESSION['sebespriv'] == 1) {
printf('
                               <tr>
                                        <th class="lable">Себестоемость, грн:</th>
                                        <td class="input"><input name="sebestoemost" size="30" maxlength="30" class="input" type="text"></td>
                                </tr><tr><th></th><td><br></td></tr>
');
}?>                               
							   <tr><th></th><td><br></td></tr>        
                                <tr>
                                <td align="center" colspan="2">
                                	<table width="100%">
                                	<tr>
                                	<td width="50%" align="center"><input style="width: 100px;" name="cancel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'"></td>
                                	<td width="50%" align="center"><input style="width: 100px;" name="submit" type="submit" value="Добавить"></td>	
                                	</tr>
                                	</table>
                                </td>                                  
                                </tr>
                        </tbody></table>
</form>

