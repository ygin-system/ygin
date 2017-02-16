<?php

class FolderColumn extends CGridColumn {

  private $link = null;
  private $countData = array();

  public $parentField = null;

  public function init() {
    parent::init();
    $data = $this->grid->dataProvider->getData();
    if (count($data) == 0) return;

    $this->link = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(
      ObjectUrlRule::PARAM_OBJECT_PARENT => '{id}',
    ), array(
      ObjectUrlRule::PARAM_SYSTEM_MODULE,
      ObjectUrlRule::PARAM_PAGER_NUM,
      ObjectUrlRule::PARAM_OBJECT_INSTANCE,
      ObjectUrlRule::PARAM_ACTION_VIEW,
    ));
    $this->countData = $this->grid->dataProvider->model->getCountChildOfInstances($data);
  }
  protected function renderHeaderCellContent() {
  }
  public function renderDataCell($row) {
    $data=$this->grid->dataProvider->data[$row];
    $idInstance =$data->getIdInstance();
    $link = strtr($this->link, array('{id}'=>$idInstance));
    $count = (isset($this->countData[$idInstance]) && $this->countData[$idInstance] > 0) ? $this->countData[$idInstance] : '';
    $cssClass = 'col-ref action-folder';
    if ($count > 0) $cssClass = 'col-ref action-folder-full';
    echo CHtml::openTag('td', array('class'=>$cssClass));
    echo '<a href="'.$link.'" title="Просмотр вложенных разделов"><b>'.$count.'</b></a>';
    echo '</td>';
  }

}
