<?php

/**
 * This is the model class for table "pr_photogallery".
 *
 * The followings are the available columns in table 'pr_photogallery':
 * @property integer $id_photogallery
 * @property string $name
 * @property string $text_in_list
 * @property string $text_in_gallery
 * @property integer $sequence
 * @property integer $id_parent
 * @property integer $file
 */
class Photogallery extends DaActiveRecord {

  const ID_OBJECT = 500;
	protected $idObject = self::ID_OBJECT;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photogallery the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'pr_photogallery';
	}

	public function byParent($idParent) {
		$criteria = new CDbCriteria();
    $criteria->addColumnCondition(array('id_parent' => $idParent));
    $criteria->order = "sequence ASC";
    
		$this->getDbCriteria()->mergeWith($criteria);
    return $this;
	}
	
  public function behaviors() {
    return array(
      'tree' => array(
        'class' => 'ActiveRecordTreeBehavior',
        'order' => 'id_parent DESC, sequence ASC',
        'idParentField' => 'id_parent',
      ),
      'photos' => array(
        'class' => 'PhotosBehavior',
        'idObject' => $this->getIdObject(),
      ),
    );
  }
	
	public function getUrl() {
		if (!$this->isNewRecord) {
      return Yii::app()->createUrl(PhotogalleryModule::ROUTE_GALLERY_VIEW, array('idGallery' => $this->id_photogallery));
    }
    return '/';
	}

  public function isProcessDeleteChild() {
    return true;
  }

  /**
   * Удаляет вложенные разделы и возвращает истину, если всё удалилось успешно
   */
  public function deleteChildGallery() {
    $child = $this->getChild();
    // Удаляем дочерние разделы, если они есть
    foreach($child AS $childGallery) {
      if ($childGallery->deleteChildGallery()) {
        $childGallery->delete();
      } else {
        return false;
      }
    }
    return true;
  }
  protected function beforeDelete() {
    $all = $this->getTree();
    $sm = $all->getById($this->id_photogallery);
    if ($sm->deleteChildGallery()) {
      return parent::beforeDelete();
    }
    return false;
  }


  /**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
		  //'photos' => array(self::HAS_MANY, 'PhotogalleryPhoto', 'id_photogallery_instance', 'select' => 'id_photogallery_photo', 'with' => 'image', 'on' => 'photos.id_photogallery_object = '.$this->getIdObject(), 'joinType' => 'JOIN', 'order' => 'photos.sequence'),
		  //'photoForList' => array(self::HAS_MANY, 'PhotogalleryPhoto', 'id_photogallery_instance', 'select' => 'id_photogallery_photo', 'with' => 'image', 'on' => 'photoForList.id_photogallery_object = '.$this->getIdObject(), 'limit' => 3, 'joinType' => 'JOIN', 'order' => 'photoForList.sequence'),
		  //'countPhoto' => array(self::STAT, 'PhotogalleryPhoto', 'id_photogallery_instance', 'condition' => 'id_photogallery_object = '.$this->getIdObject()),
		);
	}

}