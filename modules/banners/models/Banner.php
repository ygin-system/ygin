<?php

/**
 * This is the model class for table "pr_banner".
 *
 * The followings are the available columns in table 'pr_banner':
 * @property integer $id_banner
 * @property string $unique_name
 * @property string $link
 * @property string $alt
 * @property integer $file
 * @property integer $width
 * @property integer $height
 * @property integer $id_banner_place
 * @property integer $visible
 * @property integer $sequence
 * @property integer @in_new_window
 * @property File @bannerFile
 */
class Banner extends DaActiveRecord {

  const ID_OBJECT = 260;
  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Banner the static model class
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
    return 'pr_banner';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('file, id_banner_place, sequence', 'required'),
      array('file, id_banner_place, visible, sequence', 'numerical', 'integerOnly'=>true),
      array('unique_name', 'length', 'max'=>100),
      array('link, alt', 'length', 'max'=>255),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'bannerFile' => array(self::BELONGS_TO, 'File', 'file', 'joinType' => 'INNER JOIN'),
      'bannerPlace' => array(self::BELONGS_TO, 'BannerPlace', 'id_banner_place'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id_banner' => 'Id Banner',
      'unique_name' => 'Unique Name',
      'link' => 'Link',
      'alt' => 'Alt',
      'file' => 'File',
      'id_banner_place' => 'Id Banner Place',
      'visible' => 'visible',
      'sequence' => 'Sequence',
    );
  }
    
  public function getClickUrl() {
    return '/rklm-cl/'.$this->unique_name.'/';
  }
  
  public function getShowUrl() {
    $showUrl= '';
    if (!Yii::app()->getModule('banners')->viewStatisticAvailable) {
      $showUrl = $this->bannerFile->getUrlPath();
    } else {
      $showUrl = '/rklm-sh/'.$this->unique_name.'/';
    }
    return $showUrl;
  }

  public function byUnicName($unicName) {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(array(
      'unique_name' => $unicName,
    ));
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  public function defaultScope() {
    $alias =  $this->getTableAlias(true, false);
    return array(
      'condition' => $alias.".visible = 1",
    );
  }
    
  public function isImage() {
    $file = $this->bannerFile->file_path;
    return HFile::isImage(HFile::getExtension($file));
  }
  
  public function isFlash() {
    $file = $this->bannerFile->file_path;
    return HFile::getExtension($file) == 'swf';
  }

  protected function beforeDelete() {
    Yii::app()->db->createCommand('DELETE FROM da_stat_view WHERE id_object=:obj AND id_instance=:inst')->execute(array(':obj'=>$this->getIdObject(), ':inst'=>$this->id_banner));
    return parent::beforeDelete();
  }
  protected function beforeSave() {
    if ($this->isNewRecord) {
      $site = $this->link;
      $site = str_replace(array("http://", "www."), "", $site);
      $site = str_replace("/", "_", $site);
      $site = HText::translit($site)."_".rand(10, 1000);
      $site = str_replace("__", "_", $site);

      $this->unique_name = $site;
    }
    return parent::beforeSave();
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'banners.backend.BannerEventHandler'
    );
  }
  
}