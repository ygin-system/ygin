<?php

/**
 * This is the model class for table "pr_news".
 *
 * The followings are the available columns in table 'pr_news':
 * @property integer $id_news
 * @property string $title
 * @property string $date
 * @property integer $id_news_category
 * @property string $short
 * @property string $content
 * @property integer $photo
 * @property integer $is_visible
 */
class News extends DaActiveRecord implements ISearchable {
  
  const ID_OBJECT = 502;
  protected $idObject = self::ID_OBJECT;
  
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return News the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'pr_news';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('title, date, content', 'required'),
      array('id_news_category, photo, is_visible', 'numerical', 'integerOnly'=>true),
      array('title', 'length', 'max'=>255),
      array('date', 'length', 'max'=>10),
      array('short', 'safe'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'image' => array(self::HAS_ONE, 'File', array('id_file' => 'photo'), 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
      'category' => array(self::BELONGS_TO, 'NewsCategory', 'id_news_category'),
    );
  }
  
  public function behaviors() {
    $behaviors = array(
      'ImagePreviewBehavior' => array(
       'class' => 'ImagePreviewBehavior',
       'imageProperty' => 'image',
       'formats' => array(
         '_list' => array(
           'width' => 100,
           'height' => 75,
         ),
       ),
      ),
    );
    return $behaviors;
  }
  
  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_news' => 'Id News',
      'title' => 'Title',
      'date' => 'Date',
      'id_news_category' => 'Id News Category',
      'short' => 'Short',
      'content' => 'Content',
      'photo' => 'Photo',
      'is_visible' => 'Is Visible',
    );
  }
  
  public function getUrl() {
    if ($this->id_news) {
      return Yii::app()->createUrl('news/news/view', array('id' => $this->id_news));
    }
    return Yii::app()->createUrl('news/news/index');
  }
  public function getSearchTitle() {
    return $this->title;
  }
  public function getSearchUrl() {
    return $this->getUrl();
  }
  
  public function defaultScope() {
    $alias =  $this->getTableAlias(true, false);
    return array(
      'condition' => "$alias.is_visible = 1",
    );
  }
    
  public function last($limit=null) {
    $alias = $this->getTableAlias();
    $this->getDbCriteria()->mergeWith(array(
        'with' => 'image',
        'order' => "$alias.date DESC",
        'limit' => $limit,
    ));
    return $this;
  }
  
  public function getIsVisible() {
    return $this->is_visible === 1;
  }
  
 public function getBackendEventHandler() {
   return array(
     'class' => 'ygin.modules.news.backend.NewsEventHandler',
   );
 }
}