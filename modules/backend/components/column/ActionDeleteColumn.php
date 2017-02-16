<?php

class ActionDeleteColumn extends ActionColumn {

  private $_availableIdInstance = array();
  private $_unavailableInfo = array();

  protected function initColumn() {
    $collection = new DaActiveRecordCollection($this->grid->dataProvider->getData());
    $idObject = $this->getObject()->id_object;

    foreach($collection AS $key => $obj) {
      if (!Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_DELETE, Yii::app()->user->id, $idObject, $key, false)) {
        $collection->remove($key);
      } else {
        $this->_availableIdInstance[] = $key;
      }
    }
    if ($collection->getCount() == 0) {
      $this->visible = false;
      return;
    }

    $info = $this->grid->dataProvider->model->isInstancesAvailableForDelete($collection);
    foreach($info AS $id => $availableInfo) {
      if (!$availableInfo['result']) {
        $key = array_search($id, $this->_availableIdInstance);
        unset($this->_availableIdInstance[$key]);
        $this->_unavailableInfo[$id] = implode(', ', $availableInfo['info']);
      }
    }

    $js = 'function da_deleteRecord(idObject, idInstance) {
  '.CHtml::ajax(array(
        'type' => 'POST',
        'dataType' => 'json',
        'url' => Yii::app()->createUrl('backend/ygin/deleteRecord'),
        'data' => 'js:{idObject:idObject, idInstance:idInstance}',
        'success' => 'function(data){
  if (data.error !== undefined) {$.daSticker({text:data.error, type:"error", sticked:true}); $("#ygin_inst_" + data.idInstance + " .action-delete a").removeClass("process"); return;}
  $.daSticker({text:data.message, type:"success"});
  $("#ygin_inst_" + data.idInstance).remove();
  if ($(".b-instance-list tbody tr").length == 0) {$(".b-instance-list, .b-instance-list-count").remove();}
}',
      )).'
}';
    Yii::app()->clientScript->registerScript('admin.delete-record-ajax', $js, CClientScript::POS_HEAD);
  }

  public function renderDataCell($row) {
    $data=$this->grid->dataProvider->data[$row];
    $idInstance = $data->getIdInstance();
    $contentCell = '';
    if (in_array($idInstance, $this->_availableIdInstance)) {
      $link = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(
        ObjectUrlRule::PARAM_OBJECT_INSTANCE=>$idInstance,
      ), array(
        ObjectUrlRule::PARAM_ACTION_VIEW,
        ObjectUrlRule::PARAM_SYSTEM_MODULE,
      ));
      $idObject = $this->getObject()->id_object;
      $js = CJavaScript::encode(array(
        'idObject' => $idObject,
        'idInstance' => $idInstance,
        'text' => 'Внимание! Информация будет безвозвратно удалена. Продолжить?',
      ));
      $contentCell = '<a onclick="$(this).daDeleteRecord('.$js.'); return false;" href="#" title="Удалить"></a>';
      $this->htmlOptions = array('class'=>'col-ref action-delete');
    } else {
      $contentCell = '<i></i>';
      $info = (isset($this->_unavailableInfo[$idInstance]) ? ', т.к. экземпляр связан с другими данными ('.$this->_unavailableInfo[$idInstance].')' : '');
      $this->htmlOptions = array('class'=>'col-ref action-delete-no', 'title'=>'Удаление не доступно'.$info);
    }
    echo CHtml::openTag('td', $this->htmlOptions);
    echo $contentCell;
    echo '</td>';
  }

}
