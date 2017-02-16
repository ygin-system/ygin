<?php

class EngineController extends DaBackendController {

  public function filters() {
    return array(
      'ajaxOnly',
    );
  }

  public function actionGetObjectParameters() {
    if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, ObjectParameter::ID_OBJECT)) {
      throw new Exception('Доступ ограничен.');
    }

    $idObject = HU::post('id_object');
    $value = HU::post('value');

    $elementIdObject = HU::post('element_object');
    $elementIdParameter = HU::post('element_parameter');

    $elementObject = DaObject::getById($elementIdObject);
    $elementParameter = ($elementObject == null ? null : $elementObject->getParameterObjectByIdParameter($elementIdParameter));
    $object = DaObject::getById($idObject);

    if ($object == null || $elementObject == null || $elementParameter == null) {
      return json_encode(array(
        'error' => 'Переданы неверные параметры',
      ));
    }

    $form = Yii::app()->getWidgetFactory()->createWidget($this, 'backend.widgets.BackendActiveForm', array(
      'id' => 'aMainForm',
      'enableClientValidation' => true,
      'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
      ),
    ));

    $elementParameter->sql_parameter = 't.id_object='.Yii::app()->db->quoteValue($object->id_object);
    $elementParameter->widget = null;

    $model = $elementObject->getModel();
    $model->{$elementParameter->getFieldName()} = $value;

    $visualElement = VisualElementFactory::getVisualElement($model, $elementParameter);
    $visualElement->form = $form;
    $visualElement->layout = false;
    ob_start();
    ob_implicit_flush(false);
    $visualElement->run();
    $data = ob_get_clean();
    echo json_encode(array(
      'html' => $data,
    ));
  }

  public function actionGetObjectParameterSetting() {
    if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, ObjectParameter::ID_OBJECT)) {
      throw new Exception('Доступ ограничен.');
    }
    $paramType = HU::post('newType');
    $parameter = HU::post('val');
    $fieldId = HU::post('field');
    $idInstance = intval(HU::post('id'));

    $object = DaObject::getById(ObjectParameter::ID_OBJECT);
    $objectParameter = $object->getParameterObjectByField($fieldId);

    $model = $object->getModel($idInstance === -1);
    if ($idInstance !== -1) {
      $model = $model->findByIdInstance($idInstance);
    }
    if ($model == null || $objectParameter == null) {
      echo json_encode(array(
        'error' => 'Переданы неверные параметры',
      ));
      return;
    }
    $form = Yii::app()->getWidgetFactory()->createWidget($this, 'backend.widgets.BackendActiveForm', array(
      'id' => 'aMainForm',
      'enableClientValidation' => true,
      'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
      ),
    ));

    $objectParameter->id_parameter_type = $paramType;
    if ($paramType == DataType::OBJECT) {
      $objectParameter->add_parameter = DaObject::ID_OBJECT;
      $objectParameter->not_null = 1;
    } else if ($paramType == DataType::REFERENCE) {
      $objectParameter->id_parameter_type = DataType::OBJECT;
      $objectParameter->add_parameter = Reference::ID_OBJECT;
      $objectParameter->not_null = 1;
    } else if ($paramType == DataType::FILE || $paramType == DataType::FILES) {
      $objectParameter->id_parameter_type = DataType::OBJECT;
      $objectParameter->add_parameter = FileType::ID_OBJECT;
      $objectParameter->not_null = 0;
    }
    $model->{$objectParameter->getFieldName()} = $parameter;
    $visualElement = VisualElementFactory::getVisualElement($model, $objectParameter);
    $visualElement->form = $form;
    $visualElement->layout = false;
    ob_start();
    ob_implicit_flush(false);
    $visualElement->run();
    $data = ob_get_clean();
    echo json_encode(array(
      'html' => $data,
    ));
  }

  public function actionAutocomplete() {
    $query = HU::post('query');
    $idObject = HU::post('idObject');

    $object = DaObject::getById($idObject);
    $idCaptionField = ($object == null ? null : $object->id_field_caption);
    if ($idCaptionField == null) return json_encode(array());

    $parameter = $object->getParameterObjectByIdParameter($idCaptionField);
    $captionField = $parameter->getFieldName();

    $where = $captionField.' LIKE :q';

    $data = $object->getModel()->findAll(array(
      'condition' => $where,
      'params' => array(':q' => $query.'%'),
      'limit' => 10,
    ));

    $result = array();
    foreach ($data as $instance) {
      /**
       * @var $instance DaActiveRecord
       */
      array_push($result, array(
        "label" => $instance->getInstanceCaption(),
        "value" => $instance->getIdInstance()
      ));
    }
    echo json_encode($result);
  }

  private function getMenu($menu=null, $tab = 0) {
    $array = array();
    $arrayLinks = array();

    $menuChild = $menu->getChild();
    foreach($menuChild AS $a) {
      $tabber = "";
      if ($tab % 4 == 0) {
        $tabber = '+&nbsp;';
      } else {
        $tabber = '-&nbsp;';
      }

      // имя
      if ($tab > 0) $tabber = str_repeat('&nbsp;', $tab-1).$tabber;
      $name = $a->getName();
      $name = htmlspecialchars($name);
      if (mb_strlen($name) > 80) {
        $name = mb_substr($name, 0, 80).'...';
      }
      $array[] = $tabber.$name;

      // ссылка
      Yii::app()->urlManager->frontendMode = true;
      $arrayLinks[] = $a->getUrl();
      Yii::app()->urlManager->frontendMode = false;
      // потомки
      if ($a->isChildExists()) {
        list($array1, $arrayLinks1) = $this->getMenu($a, $tab + 2);
        $array = array_merge($array, $array1);
        $arrayLinks = array_merge($arrayLinks, $arrayLinks1);
      }
    }
    return array($array, $arrayLinks);
  }

  public function actionAjaxLink() {
    /*global $locale;
    $locale->init();
    if ($locale->getDataLocale() != DA_LOCALE_MAIN) {
      UrlPage::setGlobalUrlPrefix($locale->getCode());
    }*/

    // Создаём и наполняем объект по работе с меню.
    $menu = Menu::getAll();
    list($array, $arrayLinks) = $this->getMenu($menu);
    $result = array('arr' => $array, 'links' => $arrayLinks);
    echo CJSON::encode($result);
  }



  public function hasEvent($name) {
    return true;
  }

  public function init() {
    parent::init();

    $this->module->setImport(array(
        'backend.controllers.*',
    ));
  }

}