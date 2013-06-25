<?php

class VisualElementWidget extends VisualElementBaseWidget {

  private static $_objectParamPermission = 1;
  private $_objectParameter = null;

  public $layout = 'backend.widgets.layouts.default';
  public $autoRequiredValidator = true;
  public $autoUniqueValidator = true;

  public function setObjectParameter($parameter) {
    $this->_objectParameter = $parameter;
  }

  /**
   * @return ObjectParameter
   */
  public function getObjectParameter() {
    if ($this->_objectParameter === null) {
      $object = $this->model->getObjectInstance();
      $this->_objectParameter = $object->getParameterObjectByField($this->attributeName);
    }
    return $this->_objectParameter;
  }
  public function getObject() {
    return $this->model->getObjectInstance();
  }

  public function getElementName() {
    // Имя элемента
    // Menu[name]
    $attr = $this->attributeName;
    if ($attr != null) {
      return CHtml::resolveName($this->model, $attr);
    }

    $elementName = "ve_";

    $elementName .= $this->objectParameter->getIdParameter();
    return $elementName;
  }

  public function isAdditional() {
    return ($this->objectParameter->is_additional == 1);
  }

  public function canNull() {
    return (!$this->getObjectParameter()->isRequired());
  }
  public function getCaption() {
    return $this->objectParameter->getCaption();
  }
  public function getHint() {
    return $this->objectParameter->getHint();
  }
  public function getParameter() {
    $ok = false;
    if (self::$_objectParamPermission == 1) {
      $ok = Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV);
      if ($ok) self::$_objectParamPermission = 2;
      else self::$_objectParamPermission = 3;
    } else if (self::$_objectParamPermission == 2) {
      $ok = true;
    }
    $link = null;
    if ($ok) {
      /**
       * @var DaObject $object
       */
      $object = $this->model->getObjectInstance();
      $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW, array(
        ObjectUrlRule::PARAM_OBJECT => ObjectParameter::ID_OBJECT,
        ObjectUrlRule::PARAM_OBJECT_INSTANCE => $this->objectParameter->getIdParameter(),
        ObjectUrlRule::PARAM_GROUP_OBJECT => DaObject::ID_OBJECT,
        ObjectUrlRule::PARAM_GROUP_INSTANCE => $object->id_object,
        ObjectUrlRule::PARAM_GROUP_PARAMETER => 75,
      ));
    }
    return $link;
  }

  public function init() {
    parent::init();
    if ($this->model->isNewRecord) {
      $field = $this->attributeName;
      if ($field != null && $field != '-' && ($default = $this->getDefaultValue()) != null) {
        $this->model->$field = $default;
      }
    }
    if ($this->autoRequiredValidator && $this->attributeName != null && $this->getObjectParameter() != null && !$this->canNull() && isset($this->model->getMetaData()->columns[$this->attributeName]) ) {
      if (!$this->model->isAttributeRequired($this->attributeName))
        $this->model->addValidator(CValidator::createValidator('required', $this->model, $this->attributeName, array('on' => 'backendInsert, backendUpdate')));
    }
    if ($this->autoUniqueValidator && $this->attributeName != null && $this->getObjectParameter() != null && $this->getObjectParameter()->isUnique() && isset($this->model->getMetaData()->columns[$this->attributeName]) ) {
      if (!$this->model->isAttributeRequired($this->attributeName))
        $this->model->addValidator(CValidator::createValidator('required', $this->model, $this->attributeName, array('on' => 'backendInsert, backendUpdate')));  // добавляем ещё такой валидатор, т.к. если значение === null, то в yii идет неверная проверка
      $this->model->addValidator(CValidator::createValidator('unique', $this->model, $this->attributeName, array('on' => 'backendInsert, backendUpdate')));
    }
  }

  public function getDefaultValue() {
    /**
     * @var DaObject $object
     */
    if ($this->objectParameter == null) return null;
    $defaultValue = $this->objectParameter->getDefaultValue();
    if (mb_strpos($defaultValue, "$") !== false || mb_strpos($defaultValue, "::") !== false) {
      $defaultValue = '$defaultValue = '.addslashes($defaultValue).';';
      eval($defaultValue);
    }
    return $defaultValue;
  }

}
