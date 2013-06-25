<form action="<?=Yii::app()->createUrl(SearchModule::ROUTE_SEARCH_VIEW)?>" class="pull-right input-append">
  <input type="text" id="query" name="query" class="span2" placeholder="Найти">
  <button class="btn btn-inverse" type="submit"><i class="icon-search icon-white"></i></button>
</form>