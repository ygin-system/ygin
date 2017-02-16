<?php

/**
 * Модель для таблицы "pr_product_category".
 *
 * The followings are the available columns in table 'pr_product_category':
 * @property integer $id_product_category
 * @property string $name
 * @property integer $id_parent
 * @property integer $image
 * @property integer $price_markup
 * @property File $photo
 */
class ProductCategory extends DaActiveRecord implements ISearchable {
  
  const ID_OBJECT = 509;
  protected $idObject = self::ID_OBJECT;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return ProductCategory the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_product_category';
  }

  public function behaviors() {
    $with = array('productCount');
    if (Yii::app()->daShop->imageCategoryOnMain) $with[] = 'photo';
     //Берем конфигурацию из настроек модуля
    $config = HArray::val(Yii::app()->daShop->getModelConfig(__CLASS__), 'ImagePreview');
    return array(
      'tree' => array(
        'class' => 'ActiveRecordTreeBehavior',
        'order' => 'id_parent DESC, sequence ASC',
        'idParentField' => 'id_parent',
        'with' => $with,
      ),
      'ImagePreview' => CMap::mergeArray(array(
        'class' => 'ImagePreviewBehavior',
        'imageProperty' => 'photo',
        'formats' => array(
          '_sm' => array(
            'width' => 170,
            'height' => 130,
          ),
        ),
      ), $config),
    );
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('id_parent, image, price_markup', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),

    );
  }
  
  public function defaultScope() {
    $alias = $this->getTableAlias(true, false);
    return array(
        'condition' => $alias.".visible = 1",
    );
  }
  
  public function getUrl() {
    if (!$this->isNewRecord) {
      $name = HText::translit(mb_strtolower($this->name), "-");
      return Yii::app()->createUrl(ShopModule::ROUTE_PRODUCT_CATEGORY, array('translitName' => $name, 'idCategory' => $this->id_product_category));
    }
    return '/';
  }
  public function getSearchTitle() {
    return 'Группа товаров: '.$this->name;
  }
  public function getSearchUrl() {
    return $this->getUrl();
  }
  
  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'productCount' => array(self::STAT, 'Product', 'id_product_category'),
      'photo' => array(self::HAS_ONE, 'File', array('id_file' => 'image'), 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
      'brands' => array(self::MANY_MANY, 'ProductBrand', 'pr_product(id_product_category, id_brand)')
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_product_category' => 'Id Product Category',
      'name' => 'Name',
      'id_parent' => 'Id Parent',
      'image' => 'Image',
      'price_markup' => 'Price Markup',
    );
  }

}