<form action="<?=Yii::app()->createUrl(SearchModule::ROUTE_SEARCH_VIEW)?>" class="navbar-form navbar-right" role="search">
    <div class="form-group">
      <input type="text" id="query" name="query" class="form-control query-input" placeholder="Найти">
    </div>
    <button class="btn btn-default button-search" type="submit"><span class="glyphicon glyphicon-search"></span></button>
</form>