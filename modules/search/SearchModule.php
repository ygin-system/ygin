<?php

class SearchModule extends DaWebModuleAbstract {

  const ROUTE_SEARCH_VIEW = 'search/search/index';

  protected $_urlRules = array(
      'search' => SearchModule::ROUTE_SEARCH_VIEW,
  );
  public $lengthPreview = 200;
  public $queryMin = 3;
  public $queryMax = 255;
  public $highlight = '<span class="label label-info">%s</span>';
  public $pageSize = 20;
  public $logQuery = true;

  public $searchModeEnable = false;

  public $objectNotSearch = array(
    512, 505, 504, 506,
  );
  public $objectSearchList = array();

  public function init() {
    // this method is called when the module is being created
    // you may place code here to customize the module or the application
    // import the module-level models and components
    $this->setImport(array(
        'search.models.Search',
        'search.models.SearchHistory',
        'search.widgets.search.SearchWidget',
        'search.components.SearchComponent',
    ));
  }

}
