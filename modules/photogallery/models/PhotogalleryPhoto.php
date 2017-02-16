<?php

/**
 * This is the model class for table "pr_photogallery_photo".
 *
 * The followings are the available columns in table 'pr_photogallery_photo':
 * @property integer $id_photogallery_photo
 * @property string $name
 * @property integer $id_photogallery_object
 * @property integer $id_photogallery_instance
 * @property integer $file
 * @property integer $sequence
 */
class PhotogalleryPhoto extends DaActiveRecord {

  const ID_OBJECT = 501;
  const URL_PARAM_OBJECT = "cObj";
  const URL_PARAM_INSTANCE = "cInst";

  protected $idObject = self::ID_OBJECT;

  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PhotogalleryPhoto the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()	{
		return 'pr_photogallery_photo';
	}

  public function behaviors() {
    return array(
             'ImagePreviewBehavior' => array(
               'class' => 'ImagePreviewBehavior',
               'imageProperty' => 'image',
               'formats' => array(
                 '_list' => array(
                   'width' => 288,
                   'height' => 230,
                 ),
               ),
             ),
    );
  }
  
	/**
	 * @return array relational rules.
	 */
	public function relations()	{
		return array(
		  'image' => array(self::HAS_ONE, 'File', array('id_file' => 'file'), 'joinType' => 'INNER JOIN', 'select' => 'id_file, file_path, id_object, id_instance, id_parameter, id_property'),
		);
	}
	
	public function byInstance(DaActiveRecord $model) {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(array(
      'id_photogallery_object' => $model->getIdObject(),
      'id_photogallery_instance' => $model->getPrimaryKey(),
    ));
    $criteria->order = "sequence ASC";
    
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
	}

  protected function beforeSave() {
    if (HU::get(self::URL_PARAM_OBJECT) != null) {
      $this->id_photogallery_object = HU::get(self::URL_PARAM_OBJECT);
    }
    if (HU::get(self::URL_PARAM_INSTANCE) != null) {
      $this->id_photogallery_instance = HU::get(self::URL_PARAM_INSTANCE);
    }
    return parent::beforeSave();
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'photogallery.backend.PhotogalleryPhotoEventHandler'
    );
  }

}