<?php

class BooleanColumn extends BaseColumn {

  public $htmlOptions = array('class'=>'col-ref col-galka');

  private $_permission = array();

  public function init() {
    $data = $this->grid->dataProvider->getData();
    if (count($data) == 0) return;
    $userId = Yii::app()->user->id;
    $idObject = $this->object->id_object;
    $idObjectParameter = $this->objectParameter->getIdParameter();
    $ok = false;
    foreach($data AS $instance) {
      $idInstance = $instance->getIdInstance();
      if (Yii::app()->authManager->checkObjectParameter($userId, $idObject, $idInstance, $idObjectParameter)) {
        $this->_permission[$idInstance] = true;
        $ok = true;
      } else {
        $this->_permission[$idInstance] = false;
      }
    }
    if (!$ok) return;

    Yii::app()->controller->registerJsFile('ygin_visual_element.js', 'backend.assets.js');
    $js = 'function da_booleanColumn(idInstance, idObject, idObjectParameter) {
  '.CHtml::ajax(array(
      'type' => 'POST',
      'dataType' => 'json',
      'url' => Yii::app()->createUrl('backend/ygin/booleanColumn'),
      'data' => 'js:{idObject:idObject, idInstance:idInstance, idObjectParameter:idObjectParameter}',
      'success' => 'function(data){
  if (data.error !== undefined) {
    $.daSticker({text:data.error, type:"error", sticked:true});
  } else {
    $.daSticker({text:data.message, type:"success"});
  }
  newClass = "glyphicon glyphicon-remove icon-red editable";
  if (data.value == 1) newClass = "glyphicon glyphicon-ok icon-green editable";
  $("#bool_" + data.idInstance + "_" + data.idObjectParameter).removeClass().addClass(newClass);
}',
    )).'
}';
    Yii::app()->clientScript->registerScript('admin.booleanColumn-ajax', $js, CClientScript::POS_HEAD);
  }

  protected function renderDataCellContent($row, $data) {
    $field = $this->name;
    $value = $data->$field;
    $htmlOptions = array('class'=>'glyphicon glyphicon-ok icon-green');
    if ($value == 0) $htmlOptions['class'] = 'glyphicon glyphicon-remove icon-red';
    if ($this->objectParameter != null) {
      $idInstance = $data->getIdInstance();
      $idObject = $this->object->id_object;
      $idObjectParameter = $this->objectParameter->getIdParameter();
      if ($this->_permission[$idInstance]) {
        $htmlOptions['onclick'] = 'booleanColumn('.CJavaScript::encode($idInstance).', '.CJavaScript::encode($idObject).', '.CJavaScript::encode($idObjectParameter).');';
        $htmlOptions['class'] .= ' editable';
        $htmlOptions['title'] = 'Изменить';
      }
      $htmlOptions['id'] = 'bool_'.$idInstance.'_'.$idObjectParameter;
    }
    echo CHtml::tag('i', $htmlOptions);
  }
}
