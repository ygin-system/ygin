<?php
Yii::import('xupload.models.XUploadForm');
class FileUploadForm extends XUploadForm {
  /**
   * запрещенные типы файлов
   * @var array
   */
  private static $deniedExtensions = array('php', 'php3', 'php4', 'php5', 'phps');
  public $objectId, $instanceId, $parameterId, $tmpId;
  private $_instanceModel = null;
  public function rules() {
    return CMap::mergeArray(parent::rules(), array(
      array('objectId, parameterId', 'required'),
      array('instanceId', 'numerical', 'integerOnly' => true),
      array('tmpId', 'length', 'min' => 32, 'max' => 32),
      array('parameterId, objectId', 'length', 'max' => 255),
    ));
  }
  public function toRequestParams() {
    $attributes = array('objectId', 'instanceId', 'parameterId', 'tmpId');
    $result = array();
    foreach ($attributes as $attrName) {
      if ($this->$attrName === null) continue;
      $result[CHtml::activeName($this, $attrName)] = $this->$attrName;
    }
    return $result;
  }
  protected function beforeValidate() {
    if (empty($this->instanceId) && empty($this->tmpId)) {
      $this->addError('instanceId', 'Не указан instanceId.');
    }
    $file = CUploadedFile::getInstance($this, 'file');
    if ($file && in_array(mb_strtolower($file->extensionName), self::$deniedExtensions)) {
      $this->addError('file', 'Файл имеет запрещенное расширение.');
      return false;
    }
    $objectParameter = $this->getObjectParameter();
    //если есть ограничение по типу файлов, то нужно добавить в валидатор
    if ($addParam = $objectParameter->getAdditionalParameter()) {
      $types = FileExtension::getExtensionsByType($addParam);
      $validators = $this->getValidators('file');
      if (isset($validators[0]) && $validators[0] instanceof CFileValidator) {
        $validators[0]->types = $types;
      }
    }
    return parent::beforeValidate();
  }

  /**
   * @return DaActiveRecord
   */
  public function getInstanceModel() {
    $object = $this->getObject();
    if ($this->_instanceModel === null) {
      $this->_instanceModel = $object->getModel()->findByIdInstance($this->instanceId);
    }
    return  $this->_instanceModel;
  }
  /**
   * @return DaActiveRecord
   */
  public function getObject() {
    $object = DaObject::getById($this->objectId);
    return $object;
  }
  /**
   * @return DaActiveRecord
   */
  public function getObjectParameter() {
    $object = $this->getObject();
    return $object->getParameterObjectByIdParameter($this->parameterId);
  }
}