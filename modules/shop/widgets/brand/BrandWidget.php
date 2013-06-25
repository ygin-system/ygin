<?php
class BrandWidget extends DaWidget {

  public function run() {
    $categoriesTree = ProductCategory::model()->getTree();
    
    $currentCategory = (Yii::app()->daShop->currentIdCategory !== null) ? $categoriesTree->getById(Yii::app()->daShop->currentIdCategory) : null;
    if ($currentCategory == null) return; // брэнды рисуем только для текущей категории
    
    $brands = $currentCategory->brands(array('with' => 'productCount'));
    if (count($brands) == 0) return;
    
    $this->render('brandWidget', compact('brands'));
  }
}
