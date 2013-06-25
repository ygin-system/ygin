<?php
if (HU::get("start") == "1") {
  SearchComponent::recreateIndex();
  echo "Процедура завершена<br><br>";
} else if (HU::get("start") == "2") {
  Yii::app()->db->createCommand('REPAIR TABLE da_search_data')->execute();
  echo "<br>Процедура завершена<br><br>";
}
?>
<form method="get" submit="">
<input type="hidden" name="start" value="1">
<input type="submit" value="Запустить пересоздание поискового индекса">
</form>
<br>
<form method="get" submit="">
<input type="hidden" name="start" value="2">
<input type="submit" value="Починить таблицу da_search_data">
</form>