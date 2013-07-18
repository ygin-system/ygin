<?php

class PhotoColumn extends BaseColumn {

  public $htmlOptions = array('class'=>'ref col-photo');
  protected $photoCountList = array();

  public function init() {
    $arrayOfId = $this->grid->dataProvider->getKeys();
    $whereConfig = array('and', 'id_photogallery_object=:id_photogallery_object', array('in', 'id_photogallery_instance', $arrayOfId));
    $data = Yii::app()->db->createCommand()
        ->select('id_photogallery_instance AS id, count(*) AS cnt')
        ->from(PhotogalleryPhoto::model()->tableName())
        ->where($whereConfig)
        ->group('id_photogallery_instance')
        ->queryAll(true, array(':id_photogallery_object' => $this->object->id_object));
    foreach ($data AS $row) {
      $this->photoCountList[$row['id']] = $row['cnt'];
    }
  }

  protected function renderDataCellContent($row, $data) {
    $idInstance = $data->getIdInstance();
    $photoCount = HArray::val($this->photoCountList, $idInstance, 0);
    $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
      ObjectUrlRule::PARAM_OBJECT=>PhotogalleryPhoto::ID_OBJECT,
      PhotogalleryPhoto::URL_PARAM_OBJECT=>$this->object->id_object,
      PhotogalleryPhoto::URL_PARAM_INSTANCE=>$idInstance,
    ));
    echo CHtml::link('<i class="icon-picture"></i> '.$photoCount, $link, array('title'=>'Фотографии'));
  }

}
