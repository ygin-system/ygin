<?php

class NewsController extends Controller {
  
  protected $urlAlias = "news";  
  
  /**
   * Список новостей
   */
  public function actionIndex($idCategory = null) {
    $criteria = new CDbCriteria();
    $criteria->scopes = array('last');
    
    $newsModule = $this->getModule();
    $category = null;
    $categories = array();
    //Если включено отображение категорий
    if ($newsModule->showCategories) {
      if ($idCategory !== null && $category = $this->loadModelOr404('NewsCategory', $idCategory)) {
        $criteria->compare('t.id_news_category', $idCategory);
      }
      $categories = NewsCategory::model()->findAll(array('order' => 'seq'));
    }

    $count = News::model()->count($criteria);
    
    $pages = new CPagination($count);
    $pages->pageSize = $newsModule->itemsCountPerPage;
    $pages->applyLimit($criteria);
    
    $news = News::model()->findAll($criteria);

    $this->render('/index', array(
      'news' => $news,  // список новостей
      'pages' => $pages,  // пагинатор
      'category' => $category,  // текущая категория
      'categories' => $categories,  // все категории
    ));
  }
  
  /**
   * Одиночная новость
   * @param int $id
   */
  public function actionView($id) {
    $news = $this->loadModelOr404('News', $id);
    $this->caption = $news->title;
    $this->render('/view',array(
      'model'=>$news
    ));
  }

}