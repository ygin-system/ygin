<?php

class SearchController extends Controller {
  
  protected $urlAlias = 'search';

  /**
   * @var CDbCriteria Позволяет добавить условия поиска относительно главной таблицы поискового индекса da_search_data
   */
  protected $criteria = null;
  
  public function actionIndex() {
    // объекты, по которым идет поиск
    // SELECT DISTINCT a.id_object, a.name FROM `da_object` a JOIN da_object_parameters b ON a.id_object = b.id_object WHERE b.search =1

    $query = HU::get('query');
    $error = null;
    $searchResult = array();
    $total = 0;
    try {
      $search = new SearchComponent();
      $search->logQuery = true;
      $search->criteria = $this->criteria;
      $paginator = new CPagination();
      $paginator->setPageSize($this->module->pageSize);
      $paginator->validateCurrentPage = false;

      $search->paginator = $paginator;
      $searchMode = SearchComponent::SEARCH_MODE_SOFT;
      if ($this->module->searchModeEnable) {
        $searchMode = HU::get('search_mode', SearchComponent::SEARCH_MODE_SOFT);
      }
      $search->setSearchMode($searchMode);
      $search->setMinQuery($this->module->queryMin);
      $search->setMaxQuery($this->module->queryMax);
      $search->setLenPreviewText($this->module->lengthPreview);
      $search->setHighlightTemplate($this->module->highlight);
      
      // TODO доработать поиск. Чтоб учитывалось отключение и подключение плагинов
      /*if (!Yii::app()->hasModule('news')) {
        $notSearch[] =
      }*/
      $search->setObjectNotSearchList($this->module->objectNotSearch); // объекты, по которым пока не поддерживается работа
      $search->setObjectSearchList($this->module->objectSearchList);
      
      $searchResult = $search->startSearch($query);
      $total = $search->getTotalResult();
    } catch (ErrorException $e) {
      $error = $e->getMessage();
    }
    
    $results = array();
    foreach($searchResult AS $cur) {
      $results[$cur->id_object][$cur->id_instance] = $cur->id_instance;
    }
    $menu = Menu::getAll();
    foreach (array_keys($results) as $idObject) {
      $data = array();
      $model = null;
      switch ($idObject) {
        case Menu::ID_OBJECT:
          foreach ($results[$idObject] AS $id) {
            $item = $menu->getById($id);
            if ($item != null) $data[] = $item;
          }
          break;
/*        case News::ID_OBJECT:
          $model = News::model();
          break;
        case Product::ID_OBJECT:
          $model = Product::model();
          break;
        case ProductCategory::ID_OBJECT:
          $model = ProductCategory::model();
          break;*/
        default:
          $object = DaObject::getById($idObject, false);
          $model = $object->getModel();
          if (!($model instanceof ISearchable)) {
            throw new Exception("Ошибка поиска данных по объекту ".$idObject.", обратитесь к разработчикам.");
          }
      }
      if ($model != null) {
        $cr = new CDbCriteria();
        $cr->addInCondition($model->getPKName(), $results[$idObject]);
        $data = $model->findAll($cr);
      }
      $results[$idObject] = array();
      foreach ($data as $r) $results[$idObject][$r->getPrimaryKey()] = $r;
    }
    
    foreach($searchResult AS $cur) {
      if (isset($results[$cur->id_object][$cur->id_instance])) {
        $model = $results[$cur->id_object][$cur->id_instance];
        $cur->model = $model;
        $cur->link = $model->getSearchUrl();
        $cur->title = $model->getSearchTitle();

/*        switch ($cur->id_object) {
          case Menu::ID_OBJECT:
            $cur->link = $model->getUrl();
            $cur->title = $model->name;
            break;
          case News::ID_OBJECT:
            $cur->link = $model->getUrl();
            $cur->title = $model->title;
            break;
          case Product::ID_OBJECT:
            $cur->link = $model->getUrl();
            $cur->title = $model->name;
            break;
          case ProductCategory::ID_OBJECT:
            $cur->link = $model->getUrl();
            $cur->title = 'Группа товаров: '.$model->name;
            break;
        }*/
      }
    }
    $this->render('/index', array(
      'query' => $query,
      'error' => $error,
      'searchResult' => $searchResult,
      'total' => $total,
      'paginator' => $search->paginator,
      'searchMode' => $searchMode,
    ));
  }
}