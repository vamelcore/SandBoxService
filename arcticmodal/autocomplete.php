<div class="b-modal">
<link href="../autocomplete/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="../autocomplete/jquery.autocomplete.js"></script>
<form method="post" action="../update/add_prodaja.php">
<br>
<table width="100%" align="center"><tr><td>Введите штрих-код с помощью</br> сканера или клавиатуры:</td></tr>
<tr><td><input type="text" name="shtrihkod" id="example" style="width:210px;"></td></tr>
<tr><td><input type="submit" name="submit" value="Отправить" style="width:105px;"></td></tr>
</table>
</form>
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
</script>
</div>
