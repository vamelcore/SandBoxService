<?php

header('Content-Type: text/html; charset=utf-8');


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title></title>	
	</head>
	<body>
<table width="700">
	<tr><td width="300"></td><td width="400"></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td colspan="2" style="border-bottom: 1px solid black;"><h1>Гарантійний талон</h1></td></tr>	
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td><h3>Найменування товару</h3></td><td><h3><?php echo $myrow['naimenovanie'];?></h3></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td><h3>ESN обладнання</h3></td><td><h3><?php echo $myrow['serialnum'];?></h3></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td><h3>Дата продажу (встановлення)</h3></td><td><h3><?php echo $dat[0];?></h3></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td><h3>Продавець<h3></td><td><h3  style="border-bottom: 1px solid black; padding-bottom: 1px;"><?php echo $myr_fio['fio_usera'];?></h3></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td>П.І.Б. власника</td><td>_________________________________________________</td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td>Телефон власника</td><td>_________________________________________________</td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td></td></tr>
	<tr><td></td><td align="center">Цим підтверджую прийняття комплектності</br>
                                     упакованого обладнання, придатного до</br> 
                                     використання, а також прийняття гарантійних</td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td align="center">Місце для штампа</td><td align="center">умов-присутність та цілісність пломби</br>
                                                                    Оператора підтверджую. /</td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td><?php echo $dat[0];?>р.</td><td align="center">Покупець/Customer ________________</td></tr>
        <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
</table>
</br>
<table width="700">
	<tr><td align="center"><h3>Гарантійні зобов’язання.<h3></td></tr>
	<tr><td>Абонентський_________, виготовлений відповідно до вимог ГОСТ 12.2.006.-87.</td></tr>
	<tr><td><em>Продавець гарантує належну роботу товару протягом гарантійного терміну за умови дотримання споживачем правил експлуатації.</em></td></tr>
	<tr><td></td></tr>
	<tr><td><em>Гарантійний термін експлуатації товару становить 12 місяців від дати продажу товару.</em></td></tr>
	<tr><td></td></tr>
	<tr><td align="justify">Протягом гарантійного терміну споживач має право на безоплатне технічне обслуговування товару, а у разі виявлення недоліків (відхилення від вимог нормативних документів) – на безоплатне усунення недоліків або заміну товару, та на інші права відповідно до Закону України “Про захист прав споживачів” (зі змінами та доповненнями) та Порядку гарантійного ремонту (обслуговування) або гарантійної заміни технічно складних побутових товарів, затвердженого постановою Кабінету Міністрів України від 11 квітня 2002 р. №506 зі змінами та доповненнями.</td></tr>
	<tr><td></td></tr>
	<tr><td align="center"><h3>Умови гарантії:<h3></td></tr>
	<tr><td></td></tr>
	<tr><td>1. Гарантійний ремонт здійснюється за таких умов:</td></tr>
	<tr><td>
		<ul>
			<li>наявність цього гарантійного талона та документа, який засвідчує факт купівлі товару;</li>
			<li>пред’явлення на гарантійне обслуговування товару у повній комплектації (оригінальна упаковка, інструкція, зарядний пристрій та інше);</li>
			<li>цілість гарантійних пломб та заводських номерів;</li>
			<li>відсутність механічних, термічних, хімічних пошкоджень;</li>
			<li>відсутність у товарі будь-якої рідини, або сторонніх предметів, або комах, або наслідків їх присутності;</li>
			<li>дотримання правил експлуатації;</li>
			<li>відсутність змін у конструкції товару;</li>
			<li>використання товару за призначенням.</li>
		</ul>
	</td></tr>
	<tr><td>2. Доставка товару здійснюється клієнтом за адресою сервісного центра.</td></tr>
	<tr><td>3. Гарантія включає заміну вузлів, деталей, комплектуючих виробів та здійснення ремонту протягом гарантійного терміну.</td></tr>
	<tr><td>4. Гарантійні зобов’язання не поширюється на аксесуари (акумулятори, шнури, блоки живлення та ін.).</td></tr>
	<tr><td>5. У тому разі, якщо ремонт є неможливим, заміна здійснюється тільки при наявності упаковки, паспорта пристрою, документа, який засвідчує факт купівлі товару (касовий, товарний чек, квитанція тощо), цього гарантійного талона, а також  паспорту покупця.</td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td align="center"><strong>З умовами гарантії ознайомлений та згоден ___________________ (підпис)</strong></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
</table>
</br>
<table>
	
</table>
	</body>
</html>

<?php }?>