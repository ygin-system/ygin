<?php

class PProductController extends ProductController {

  protected $urlAlias = "catalog";

  public function actionIndex() {

    if (Yii::app()->user->hasFlash('offer-success')) {
      $this->widget('AlertWidget', array(
          'title' => 'Оформление заказа',
          'message' => Yii::app()->user->getFlash('offer-success'),
      ));
    }

    $categories = ProductCategory::model()->findAll(array(
        'condition' => 'on_main = 1',
        'order' => 'sequence ASC',
            //'limit' => 3,
    ));
    $deals = Product::model()->findAll(array(
        'condition' => 'spec = 1',
        'limit' => 6,
    ));
    $this->render('/index', array(
        'categories' => $categories,
        'deals' => $deals,
    ));
  }

  public function actionCategory($idCategory, $showAll = false) {
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
    //$criteria->scopes = array('byCategory' => array($category));
    $idCategories[] = $category->primaryKey;

    foreach ($category->getChild() as $subCategory) {
      $idCategories[] = $subCategory->primaryKey;
    }

    $criteria->addInCondition('t.id_product_category', $idCategories);
    $this->renderProductList($criteria, $category, $showAll);
  }

  public function actionBrand($idBrand) {
    $brand = $this->throw404IfNull(ProductBrand::model()->findByPk($idBrand));
    $criteria = new CDbCriteria();
    $criteria->scopes = array('byBrand' => array($brand));
    $this->caption = $brand->name;
    //$this->breadcrumbs[$brand->name] = $brand->getUrl();
    $this->renderProductList($criteria);
  }

  private function renderProductList(CDbCriteria $criteria, $category = null, $showAll = false) {
    $model = new FilterForm;

    if (isset($_GET['FilterForm'])) {
      $model->attributes = $_GET['FilterForm'];

      if ($model->brands) {
        $criteria->addInCondition('id_brand', $model->brands);
      }

      if ($model->minPrice) {
        $criteria->addCondition('retail_price >= :MIN_PRICE');
        $criteria->params[':MIN_PRICE'] = $model->minPrice;
      }
      
      if ($model->maxPrice) {
        $criteria->addCondition('retail_price <= :MAX_PRICE');
        $criteria->params[':MAX_PRICE'] = $model->maxPrice;
      }
      
      if ($model->sizes) {
        $criteria->join = 'LEFT JOIN pr_link_product_size sizes ON sizes.id_product=t.id_product';
        $criteria->addInCondition('sizes.id_size', $model->sizes);
      }

      if ($model->types) {
        $criteria->addInCondition('t.id_product_category', $model->types);
      }
    }

    $pages = null;

    if (isset($this->module->pageSize) && ($this->module->pageSize > 0) && !$showAll) {
      $count = Product::model()->count($criteria);
      $pages = new CPagination($count);
      $pages->pageSize = $this->module->pageSize;
      $pages->applyLimit($criteria);
    }

    $view = Yii::app()->daShop->viewProductList;
    if (Yii::app()->request->cookies['shop_product_list_display'] != null) {
      $val = Yii::app()->request->cookies['shop_product_list_display']->value;
      if ($val == 'byBlock')
        $view = '_product_list';
      else if ($val == 'byTable')
        $view = '_product_list_table';
    }

    $order = 'retail_price DESC'; // дорогие сверху - "-byCost";
    $orderType = '-byCost';
    if (Yii::app()->request->cookies['shop_product_list_order'] != null) {
      $val = Yii::app()->request->cookies['shop_product_list_order']->value;
      $sign = $val{0};
      if ($sign == '+' || $sign == '-') {
        $val = substr($val, 1);
        if ($val == 'byCost')
          $order = 'retail_price';
        else if ($val == 'byName')
          $order = 'name';
        else if ($val == 'byDate')
          $order = 'id_product';
        else
          $order = null;
        if ($order == null) {
          $order = 'retail_price DESC';
        } else {
          if ($sign == '-')
            $order .= ' DESC';
          $orderType = $sign . $val;
        }
      }
    }
    $alias = Product::model()->getTableAlias(true, false);
    //$criteria->order = $alias . '.' . $order;
    // товары из категории
    $products = Product::model()->with('mainPhoto', 'category')->findAll($criteria);  // category необходима, т.к. там содержится наценка
    $dataBrands = $dataSizes = $dataTypes = null;
    $sizeCriteria = new CDbCriteria;
    $idCategories[] = $category->primaryKey;

    foreach ($category->getChild() as $subCategory) {
      $idCategories[] = $subCategory->primaryKey;
    }

    $sizeCriteria->addInCondition('products.id_product_category', $idCategories);
    $sizeCriteria->order = 'sequence ASC';
    $sizes = Size::model()->with('products')->findAll($sizeCriteria);

    if ($sizes) {
      $dataSizes = CHtml::listData($sizes, 'id_size', 'title');
    }

    $brands = ProductBrand::model()->with('products')->findAll($sizeCriteria);

    if ($brands) {
      $dataBrands = CHtml::listData($brands, 'id_brand', 'name');
    }

    $types = $category->getChild();

    if ($types) {
      $dataTypes = CHtml::listData($types, 'id_product_category', 'name');
    }

    if ($showAll) {
      $pagination = false;
    } else {
      $pagination = array(
          'pageSize' => 15,
      );
    }

    $dataProvider = new CActiveDataProvider('Product', array(
        'keyAttribute' => 'id_product',
        'criteria' => $criteria,
        'sort' => array(
            'attributes' => array(
                'retail_price' => array(
                    'label' => 'Цене',
                    'asc' => 'retail_price ASC, name ASC',
                    'desc' => 'retail_price DESC, name ASC',
                ),
            ),
            'defaultOrder' => 'name ASC',
        ),
        'pagination' => $pagination,
    ));
    $this->render('/category', array(
        'category' => $category,
        'products' => $products,
        'pages' => $pages,
        'view' => $view,
        'orderType' => $orderType,
        'brands' => $brands,
        'dataSizes' => $dataSizes,
        'dataProvider' => $dataProvider,
        'model' => $model,
        'dataTypes' => $dataTypes,
        'showAll' => $showAll,
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

    $this->setPageTitle($product->name . ', ' . $this->getPageTitle());

    $this->render('/product', array(
        'product' => $product,
        'category' => $category,
    ));
  }

  public function actionDistribution($idCategory = null) {
    if (isset($_POST['Product'])) {
      foreach ($_POST['Product'] as $product) {
        if (isset($product['save'])) {
          $model = Product::model()->findByPk($product['id']);
          $model->id_product_category = $_POST['idCategory'];
          $model->update();
        }
      }
    }

    $criteria = new CDbCriteria();
    $pages = null;

    if ($idCategory) {
      $criteria->condition = 'id_product_category = :ID_CATEGORY';
      $criteria->params = array(':ID_CATEGORY' => $idCategory);
    } else {
      $count = Product::model()->count($criteria);
      $pages = new CPagination($count);
      $pages->pageSize = 100;
      $pages->applyLimit($criteria);
    }

    if (HU::get('q') != null) {
      $criteria->addCondition('name like :like');
      $criteria->params[':like'] = '%' . HU::get('q') . '%';
    }

    $products = Product::model()->with('mainPhoto')->findAll($criteria);
    $rootCategories = ProductCategory::model()->findAll('id_parent IS NULL');
    $allCategories = ProductCategory::model()->findAll();
    $groupCategories = array();

    foreach ($allCategories as $key => $category) {
      if ($category->id_parent) {
        $parentCategory = ProductCategory::model()->findByPk($category->id_parent);
        $groupCategories[$parentCategory->name][] = $category;
      } else {
        $groupCategories['null'][] = $category;
      }
    }

    $data = '<select name="idCategory" id="idCategory">';

    foreach ($groupCategories as $idParent => $group) {
      if ($idParent != 'null') {
        $data .= '<optgroup label="' . $idParent . '">';

        foreach ($group as $cat) {
          $data .= '<option value="' . $cat->primaryKey . '">' . $cat->name . '</option>';
        }

        $data .= '</optgroup>';
      } else {
        foreach ($group as $cat) {
          $data .= '<option value="' . $cat->primaryKey . '">' . $cat->name . '</option>';
        }
      }
    }

    $data .= '</select>';
    $this->render('application.modules.shop.views.distribution', array(
        'models' => $products,
        'rootCategories' => $rootCategories,
        'data' => $data,
        'pages' => $pages,
        'idCategory' => $idCategory,
    ));
  }

  public function actionDeleteDuplicate() {
    $products = Product::model()->findAll();

    foreach ($products as $product) {
      $duplicates = Product::model()->findAll('name = :NAME AND retail_price = :PRICE', array(
          ':NAME' => $product->name,
          ':PRICE' => $product->retail_price,
      ));

      if (count($duplicates) > 1) {
        foreach ($duplicates as $key => $duplicate) {
          if ($key == 0)
            continue;

          if ($duplicate->image) {
            unlink(Yii::getPathOfAlias('webroot') . '/' . $duplicate->mainPhoto->file_path);
            $duplicate->mainPhoto->delete();
          }

          $duplicate->delete();
        }
      }
    }
  }

}
