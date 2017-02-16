<?php
class CategoryWidget extends DaWidget {

  public function run() {
    $categoriesTree = ProductCategory::model()->getTree();
    $currentCategory = (Yii::app()->daShop->currentIdCategory !== null) ? $categoriesTree->getById(Yii::app()->daShop->currentIdCategory) : null;
    $tree = array('items' => $this->buildTree($categoriesTree, $currentCategory));
    $this->render('categoryWidget', compact('tree'));
  }
  
  protected function buildTree($categoriesTree, $currentCategory) {
    $result = array();
    foreach ($categoriesTree->child as $category) {
      $result[] = array(
        'id' => $category->getPrimaryKey(),
        'name' => $category->name,
        'url' => $category->getUrl(),
        'productCount' => $category->productCount,
        'active' => $currentCategory !== null && $currentCategory->isDescendant($category, true),
        'items' => $this->buildTree($category, $currentCategory),
      );
    }
    return $result;
  }
}
