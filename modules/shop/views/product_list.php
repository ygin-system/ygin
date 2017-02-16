<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$this->registerJsFile('shop.js');
Yii::app()->clientScript->registerCoreScript('cookie');
Yii::app()->clientScript->registerScript(
  'cartProduct',
  'initDaCartProducts(".b-emarket_list .element_item, .b-emarket_list_table tr");',
  CClientScript::POS_READY
);

if (Yii::app()->daShop->displayTypeElements == ShopModule::DISPAY_TYPE_ALL && $category != null) {
  $this->renderPartial('/index', array(
    'allCategory' => $category->getChild(),
  ));
}
    
$this->registerCssFile("emarket_category_list.css");

if (count($products) == 0) {
  echo "В данной категории товаров нет.";
  return;
}

if (Yii::app()->daShop->showToolbar) {
  $this->renderPartial('/_tools', array('view' => $view, 'orderType' => $orderType));
}

$this->renderPartial('/'.$view, array('products' => $products));

if ($pages != null) $this->widget('LinkPagerWidget', array(
  'pages' => $pages,
));
