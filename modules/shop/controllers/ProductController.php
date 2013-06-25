<?php

class ProductController extends Controller {
  
  protected $urlAlias = "catalog";
  
  public function actionIndex() {
    
    if (Yii::app()->user->hasFlash('offer-success')) {
      $this->widget('AlertWidget', array(
        'title' => 'Оформление заказа',
        'message' => Yii::app()->user->getFlash('offer-success'),
      ));
    }

    $this->render('/index', array(
      'allCategory' => ProductCategory::model()->getTree()->getChild(),
    ));
  }
  
  public function actionCategory($idCategory) {
    // выбранная категория
    $category = $this->throw404IfNull(ProductCategory::model()->getTree()->getById($idCategory));
    Yii::app()->daShop->currentIdCategory = $category->id_product_category;

    if (Yii::app()->daShop->displayTypeElements == ShopModule::DISPAY_TYPE_ONLY_CATEGORY) {
      $this->render('/index', array(
        'allCategory' => $category->getChild(),
      ));
      return;
    }
    
    $this->caption = $category->name;
    
    $criteria = new CDbCriteria();
    $criteria->scopes = array('byCategory' => array($category));
    $this->renderProductList($criteria, $category);
  }
  
  public function actionBrand($idBrand) {
    $brand = $this->throw404IfNull(ProductBrand::model()->findByPk($idBrand));
    $criteria = new CDbCriteria();
    $criteria->scopes = array('byBrand' => array($brand));
    $this->caption = 'Продукция брэнда "'.$brand->name.'"';
    $this->breadcrumbs[$brand->name] = $brand->getUrl();
    $this->renderProductList($criteria);
  }
  
  private function renderProductList(CDbCriteria $criteria, $category=null) {
    $pages = null;
    if (isset($this->module->pageSize) && ($this->module->pageSize > 0)) {
      $count = Product::model()->count($criteria);
      $pages = new CPagination($count);
      $pages->pageSize = $this->module->pageSize;
      $pages->applyLimit($criteria);
    }
    
    $view = Yii::app()->daShop->viewProductList;
    if (Yii::app()->request->cookies['shop_product_list_display'] != null) {
      $val = Yii::app()->request->cookies['shop_product_list_display']->value;
      if ($val == 'byBlock') $view = '_product_list';
        else if ($val == 'byTable') $view = '_product_list_table';
    }

    $order = 'retail_price DESC'; // дорогие сверху - "-byCost";
    $orderType = '-byCost';
    if (Yii::app()->request->cookies['shop_product_list_order'] != null) {
      $val = Yii::app()->request->cookies['shop_product_list_order']->value;
      $sign = $val{0};
      if ($sign == '+' || $sign == '-') {
        $val = substr($val, 1);
        if ($val == 'byCost') $order = 'retail_price';
          else if ($val == 'byName') $order = 'name';
            else if ($val == 'byDate') $order = 'id_product';
              else $order = null;
        if ($order == null) {
          $order = 'retail_price DESC';
        } else {
          if ($sign == '-') $order .= ' DESC';
          $orderType = $sign.$val;
        }
      }
    }
    $alias = Product::model()->getTableAlias(true, false);
    $criteria->order = $alias.'.'.$order;
    
    // товары из категории
    $products = Product::model()->with('mainPhoto', 'category')->findAll($criteria);  // category необходима, т.к. там содержится наценка

    $this->render('/product_list', array(
      'category' => $category,
      'products' => $products,
      'pages' => $pages,
      'view' => $view,
      'orderType' => $orderType,
    ));
  }
  
  public function actionView($idProduct) {
    /**
     * @var Product $product
     */
    $product = $this->throw404IfNull(Product::model()->with('mainPhoto')->findByPk($idProduct));
    //категория может быть скрыта, и тогда этот раздел не должен показываться
    $category = $this->throw404IfNull(
      ProductCategory::model()->getTree()->getById($product->id_product_category)
    );
    Yii::app()->daShop->currentIdCategory = $category->id_product_category;
    $this->breadcrumbs[$product->name] = $product->getUrl();

    $this->setPageTitle($product->name.', '.$this->getPageTitle());

    $this->render('/product', array(
      'product' => $product,
    ));
    
  }
  
}
