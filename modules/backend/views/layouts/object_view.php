<?php

$this->beginContent('/layouts/main');

//if (!$isSortAjax && $seqKeyStr != null) $n .= $seqKeyStr;

$searchModel = $this->searchModel;
if (($searchModel != null && $searchModel->getHasVisibleSearchParameters()) || count($this->buttons) > 0) {

  echo CHtml::openTag('div', array('class'=>'navbar navbar-default b-toolbar'));

  foreach($this->buttons AS $button) {
    echo CHtml::openTag('div', array('class'=>'btn-group'));
    if (isset($button['html'])) {
      echo $button['html'];
    } else {
      echo CHtml::link($button['caption'], $button['url'], array('class'=>'btn navbar-btn '.$button['class'])).(isset($button['addButtonData']) ? $button['addButtonData'] : '');
    }
    echo CHtml::closeTag('div'); // .btn-group
  }

  if ($searchModel != null) {
    Yii::app()->clientScript->registerScript('search-form-init', '
      $("#'.CHtml::activeId($searchModel, 'value').'").tooltip({
       title: "Вы можете использовать <br>>, <, >=, <=, =, <> <br>в начале искомого выражения, <br>чтобы уточнить, как выполнить поиск.",
       html: true
      });
    ', CClientScript::POS_READY);
    $form = $this->beginWidget('CActiveForm', array(
      'id' => 'SearchForm',
      'method' => 'get',
      'enableAjaxValidation' => false,
      'enableClientValidation' => true,
      'htmlOptions' => array(
        'class' => 'b-navbar-search navbar-form navbar-right form-inline',
        'role'  => 'form',
      ),
      'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
      ),
      'action' => ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(), array(
        ObjectUrlRule::PARAM_OBJECT_INSTANCE, // TODO DA_URL_VNUM, DA_URL_GO
      )),
    ));

    echo CHtml::openTag('div', array('class'=>'form-group'));
    echo $form->dropDownList($searchModel, 'parameter', $searchModel->toListData(), $htmlOptions=array('class'=>'fields form-control'));
    echo CHtml::closeTag('div'); // .form-group

    echo CHtml::openTag('div', array('class'=>'form-group'));
    echo CHtml::openTag('div', array('class'=>'input-group query-group'));
    echo $form->textField($searchModel, 'value', array(
      'class' => 'query form-control',
      'value'=>$searchModel->value,
    ));

    echo CHtml::openTag('div', array('class'=>'input-group-btn'));
    echo CHtml::htmlButton('<i class="glyphicon glyphicon-search"></i>', array(
      'class' => 'btn btn-primary',
      'title'=>'Найти',
      'type'=>'submit',
    ));
    echo CHtml::closeTag('div'); // .input-group-btn

    echo CHtml::closeTag('div'); // .input-group
    echo CHtml::closeTag('div'); // .form-group
    $this->endWidget();
  }

  echo CHtml::closeTag('div'); // .navbar

}

if (!empty($this->breadcrumbs)) { // Цепочка навигации
  //echo '<div><i class="glyphicon glyphicon-upload" title="Цепочка навигации"></i>&nbsp;';
  $this->widget('BreadcrumbsWidget', array(
    //'homeLink' => array('<i class="glyphicon glyphicon-upload" title="Цепочка навигации"></i>&nbsp;' => ''),
    'links' => $this->breadcrumbs,
  ));
  //echo '</div>';
}

echo $content;
$this->endContent();

