<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Первый запуск</title>
<link rel="stylesheet" href="style.css" />


</head>
<body>

<div align="center">

<table width="400" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;'>
<tr>
<td style="border-bottom:1px solid #c6d5e1;"><p style="font-size:16pt;">Первый запуск</p></td>
</tr>
<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><p style="font-size:10pt;">Перед началом работы необходимо ввести название для первого магазина. <br> <strong>Внимание:</strong> названия магазинов фигурируют в отчетах, поэтому возможность изменять их в процессе работы была отключена.</p></td>
</tr>
<tr><td style="border-bottom:1px solid #c6d5e1;"></td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;"><form action="update/insetr_first_mag.php" method="post">
<table>
<tr>
<td>Название первого магазина:</td>
<td><input type="text" name="first_mag_name" value=""></td>
<td><input type="submit" value="Сохранить"></td>
</tr>
</table></form>
</td></tr>

  
  </table>

</div>
  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>