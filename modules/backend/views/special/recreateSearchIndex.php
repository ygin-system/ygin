<?php
	if(HU::get ("start")=="1") {
		SearchComponent::recreateIndex ();
		echo '<p>Процедура завершена</p>';
	}
	else if(HU::get ("start")=="2") {
		Yii::app ()->db->createCommand ('REPAIR TABLE da_search_data')->execute ();
		echo '<p>Процедура завершена</p>';
	}
?>
<form method="get" submit="">
	<input type="hidden" name="start" value="1">
	<button type="submit" class="btn btn-default">Запустить пересоздание поискового индекса</button>
</form>
<br>
<form method="get" submit="">
	<input type="hidden" name="start" value="2">
	<button type="submit" class="btn btn-default">Починить таблицу da_search_data</button>
</form>