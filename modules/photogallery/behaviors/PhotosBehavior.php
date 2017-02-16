<?php
class PhotosBehavior extends CActiveRecordBehavior {

  public $idObject;

  public function attach($owner) {
    parent::attach($owner);
    if (empty($this->idObject)) {
      if ($owner instanceOf DaActiveRecord) {
        $this->idObject = $owner->getIdObject();
      }
    }
    $this->getOwner()->getMetaData()->addRelation(
      'photosList',
      array(CActiveRecord::HAS_MANY, 'PhotogalleryPhoto', 'id_photogallery_instance',
        'select' => 'id_photogallery_photo, name',
        'with' => 'image',
        'on' => 'photosList.id_photogallery_object = :PHOTOGALLERY_OBJECT_ID',
        'joinType' => 'JOIN',
        'order' => 'photosList.sequence',
        'params' => array(':PHOTOGALLERY_OBJECT_ID' => $this->idObject),
    ));
    $this->getOwner()->getMetaData()->addRelation(
      'countPhoto',
      array(CActiveRecord::STAT, 'PhotogalleryPhoto', 'id_photogallery_instance',
        'condition' => 'id_photogallery_object = :PHOTOGALLERY_OBJECT_ID',
        'params' => array(':PHOTOGALLERY_OBJECT_ID' => $this->idObject),
    ));
    $this->getOwner()->attachBehaviors(array(
      'CascadeDelete' => array(
        'class' => 'CascadeDeleteBehavior',
        'relations' => array(
          'photosList',
        ),
    )));
  }

}