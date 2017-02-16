<?php

class AutoPrimaryKeyWidget extends TextFieldWidget {

  public $indexView = 'backend.widgets.textField.views.index';

  public $sourceAttr = null;
  public $parentSourceAttr = null;
  public $prefixAttr = '';

  public function init() {
    if ($this->model->isNewRecord) {
      $config = str_replace(array(' ', ','), ';', $this->getObjectParameter()->getSqlParameter());
      $arr = explode(';', $config);
      foreach($arr AS $param) {
        if (trim($param) == '') continue;
        if ($this->sourceAttr == null) {
          $this->sourceAttr = explode('/', $param);
          continue;
        }
        if ($this->parentSourceAttr === null) {
          if ($param == '-') {
            $this->parentSourceAttr = false;
          } else {
            $this->parentSourceAttr = $param;
          }
          continue;
        }
        if ($this->prefixAttr == null) $this->prefixAttr = $param.'-';
      }
    }

    if (!YGIN_DEVELOP) { // генерируем имя автоматически
      $this->render = false;
    }
    parent::init();
  }
  public function run() {
    if (YGIN_DEVELOP && $this->model->isNewRecord) {
      $id = 'ygin-';
      if ($this->parentSourceAttr != null) {
        $id = $this->model->{$this->parentSourceAttr}.'-';
      }
      $id .= $this->prefixAttr;
      $this->model->{$this->attributeName} = $id;
    }
    parent::run();
  }

  public function onPostForm(PostFormEvent $event) {
    if (!YGIN_DEVELOP && $this->model->isNewRecord) {
      // для не разработчиков системы генерируем имя строковых ключей автоматически
      $model = $event->model;
      $id = rtrim(Yii::app()->backend->prefixPkName, '-_').'-';
      if ($this->parentSourceAttr != null) {
        $id = $model->{$this->parentSourceAttr}.'-';
      }
      $id .= $this->prefixAttr;
      foreach($this->sourceAttr AS $attr) {
        if ($model->{$attr} != null && trim($model->{$attr}) != '-') {
          $id .= HText::translit(mb_strtolower($model->{$attr}), '-');
          break;
        }
      }
      $id = str_replace('_', '-', $id);
      $this->model->{$this->attributeName} = $id;
    }
  }


}
