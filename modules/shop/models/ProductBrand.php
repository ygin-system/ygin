<?php

/**
 * Модель для таблицы "pr_product_brand".
 *
 * The followings are the available columns in table 'pr_product_brand':
 * @property integer $id_brand
 * @property string $name
 * @property integer $id_parent
 * @property integer $image
 * @property integer $sequence
 */
class ProductBrand extends DaActiveRecord
 {
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return ProductBrand the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'pr_product_brand';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('name', 'required'),
      array('id_parent, image, sequence', 'numerical', 'integerOnly'=>true),
      array('name', 'length', 'max'=>255),

    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
        'productCount' => array(self::STAT, 'Product', 'id_brand'),
    );
  }

  public function defaultScope() {
    $alias = $this->getTableAlias(true, false);
    return array(
        'order' => $alias.".sequence",
    );
  }
  
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
      'id_brand' => 'Id Brand',
      'name' => 'Name',
      'id_parent' => 'Id Parent',
      'image' => 'Image',
      'sequence' => 'Sequence',
    );
  }
  
  public function getUrl() {
    if (!$this->isNewRecord) {
      $name = HText::translit(mb_strtolower($this->name), "-");
      return Yii::app()->createUrl(ShopModule::ROUTE_PRODUCT_BRAND, array('translitName' => $name, 'idBrand' => $this->id_brand));
    }
    return '/';
  }

}