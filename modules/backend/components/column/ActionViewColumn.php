<?php

class ActionViewColumn extends ActionColumn {

  private $_availableIdInstance = array();

  protected function initColumn() {
    $collection = new DaActiveRecordCollection($this->grid->dataProvider->getData());
    $idObject = $this->getObject()->id_object;

    foreach($collection AS $key => $obj) {
      if (!Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_VIEW, Yii::app()->user->id, $idObject, $key, false)) {
        $collection->remove($key);
      } else {
        $this->_availableIdInstance[] = $key;
      }
    }
    if ($collection->getCount() == 0) $this->visible = false;
  }

  public function renderDataCell($row) {
    $data=$this->grid->dataProvider->data[$row];
    $idInstance = $data->getIdInstance();
    $contentCell = '';
    if (in_array($idInstance, $this->_availableIdInstance)) {
      $link = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(
        ObjectUrlRule::PARAM_ACTION_VIEW=>$idInstance,
      ), array(
        ObjectUrlRule::PARAM_OBJECT_INSTANCE,
        ObjectUrlRule::PARAM_SYSTEM_MODULE,
      ));
      $contentCell = CHtml::link('<i></i>', $link, array('title'=>'Просмотр свойств'));
      $this->htmlOptions = array('class'=>'col-ref action-view');
    } else {
      $contentCell = '<i></i>';
      $this->htmlOptions = array('class'=>'col-ref action-view-no', 'title'=>'Просмотр не доступен');
    }
    echo CHtml::openTag('td', $this->htmlOptions);
    echo $contentCell;
    echo '</td>';
  }

}
