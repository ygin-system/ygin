<?php

$this->beginContent('/layouts/main');

//if (!$isSortAjax && $seqKeyStr != null) $n .= $seqKeyStr;

$searchModel = $this->searchModel;
if (($searchModel != null && $searchModel->getHasVisibleSearchParameters()) || count($this->buttons) > 0) {

  echo CHtml::openTag('div', array('class'=>'top navbar btn-toolbar'));
  echo CHtml::openTag('div', array('class'=>'navbar-inner'));

  foreach($this->buttons AS $button) {
    if (isset($button['html'])) {
      echo $button['html'];
    } else {
      $link = CHtml::link($button['caption'], $button['url'], array('class'=>'btn '.$button['class']));
      echo CHtml::tag('div', array('class'=>'btn-group'), $link.(isset($button['addButtonData']) ? $button['addButtonData'] : '') );
    }
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
        'class' => 'form-inline navbar-search pull-right input-append',
      ),
      'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
      ),
      'action' => ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(), array(
        ObjectUrlRule::PARAM_OBJECT_INSTANCE, // TODO DA_URL_VNUM, DA_URL_GO
      )),
    ));

    echo $form->dropDownList($searchModel, 'parameter', $searchModel->toListData(), $htmlOptions=array('class'=>'fields'));
    echo $form->textField($searchModel, 'value', array(
      'class' => 'query input-medium',
      'value'=>$searchModel->value,
    ));
    echo CHtml::htmlButton('<i class="icon-search icon-white"></i>', array(
      'class' => 'btn btn-primary',
      'title'=>'Найти',
      'type'=>'submit',
    ));
    $this->endWidget();
  }

  echo CHtml::closeTag('div'); // .navbar-inner
  echo CHtml::closeTag('div'); // .navbar

}

if (!empty($this->breadcrumbs)) { // Цепочка навигации
  //echo '<div><i class="icon-upload" title="Цепочка навигации"></i>&nbsp;';
  $this->widget('BreadcrumbsWidget', array(
    //'homeLink' => array('<i class="icon-upload" title="Цепочка навигации"></i>&nbsp;' => ''),
    'links' => $this->breadcrumbs,
  ));
  //echo '</div>';
}

echo $content;
$this->endContent();

