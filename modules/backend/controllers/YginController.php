<?php

class YginController extends DaBackendController {
 
  public function filters() {
    return array(
      'ajaxOnly + updateMenu, sort, deleteRecord, booleanColumn',
    );
  }
  public function hasEvent($name) {
    return true;
  }
  public function actionUpdateMenu($idObject, $idObjectView) {
    $mainMenuWidget = $this->createWidget(Yii::app()->backend->mainMenuWidget, array(
        'idObjectCurrent' => $idObject,
        'idObjectViewCurrent' => $idObjectView,
    ));
    Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_MAIN_MENU, new CEvent($mainMenuWidget));
    ob_start();
    ob_implicit_flush(false);
    $mainMenuWidget->run();
    $html = ob_get_clean();
    echo CJSON::encode(array('html' => $html));
  }

  public function actionSort() {
    $idObject = HU::post('idObject', null);
    $data = HU::post('data', array());
    try {
      if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, $idObject)) {
        throw new Exception('Доступ ограничен на изменение порядка.');
      }
      $object = DaObject::getById($idObject);
      if ($object == null) throw new Exception('Некорректные параметры запроса.');
      $seqKey = $object->getParameterObjectByField($object->getFieldByType(DataType::SEQUENCE));
      if ($seqKey == null) throw new Exception('Не найдено поле для сортировки.');
      if (!is_array($data)) throw new Exception('Некорректные данные.');

      $model = $object->getModel();
      $field = $seqKey->getFieldName();
      foreach ($data as $s => $v) {
        $idInst = str_replace('ygin_inst_', '', $s);
        $instance = $model->findByIdInstance($idInst);
        if ($instance != null && $instance->$field != (intval($v) + 1)) {
          $instance->$field = (intval($v) + 1);
          $instance->update(array($field));
        }
      }
      echo CJSON::encode(array('message' => 'Порядок сортировки изменён'));
    } catch(Exception $e) {
      echo CJSON::encode(array('error' => $e->getMessage()));
    }
  }

  public function actionDeleteRecord() {
    $idObject = HU::post('idObject', null);
    $idInstance = HU::post('idInstance', null);

    try {
      if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_DELETE, Yii::app()->user->id, $idObject, $params=array('idInstance'=>$idInstance))) {
        throw new Exception('Доступ на удаление ограничен.');
      }
      $object = DaObject::getById($idObject);
      if ($object == null) throw new Exception('Некорректные параметры запроса (не найден объект='.$idObject.').');
      $model = $object->getModel()->findByIdInstance($idInstance);
      if ($model == null) throw new Exception('Некорректные параметры запроса (не найден экземпляр='.$idInstance.').');

      if ($model->delete()) {
        HU::log_da("Удален (".$object->getName().") id=".$idInstance);
        echo CJSON::encode(array('message' => 'Данные успешно удалены.', 'idInstance' => $idInstance));
      } else {
        $c = $model->getCountChild();
        if ($c > 0) {
          throw new Exception("Информация не удалена, т.к. присутствуют дочерние экземпляры (".$c.")");
        } else {
          $dependentData = $model->getDependentData(true);
          if (count($dependentData) > 0) {
            // экземпляр не был удален. Выводим информацию о зависимых данных
            $msg = "Информация не удалена, т.к. раздел участвует в других объектах:";
            foreach($dependentData AS $idObj => $count) {
              $obj = DaObject::getById($idObj);
              $msg .= "\\n".$obj->getName()." (количество экземпляров: ".$count.")";
            }
            throw new Exception($msg);
          }
          echo CJSON::encode(array('message' => 'Обработано', 'idInstance' => $idInstance));
        }
      }
    } catch(Exception $e) {
      echo CJSON::encode(array('error' => $e->getMessage(), 'idInstance' => $idInstance));
    }
  }

  public function actionBooleanColumn() {
    $idObject = HU::post('idObject', null);
    $idInstance = HU::post('idInstance', null);
    $idObjectParameter = HU::post('idObjectParameter', null);
    $value = HU::post('value', -1);
    try {
      $object = DaObject::getById($idObject);
      $object->registerYiiEventHandler();

      if ($object == null) throw new Exception('Некорректные параметры запроса (объект).');
      $model = $object->getModel()->findByIdInstance($idInstance);
      if ($model == null) throw new Exception('Некорректные параметры запроса (экземпляр).');
      $objectParam = $object->getParameterObjectByIdParameter($idObjectParameter);
      if ($objectParam == null) throw new Exception('Некорректные параметры запроса (параметр).');
      if (!Yii::app()->authManager->checkObjectParameter(Yii::app()->user->id, $idObject, $idInstance, $idObjectParameter)) {
        throw new Exception('Доступ на изменение ограничен.');
      }
      $field = $objectParam->getFieldName();
      $value = intval($model->$field);
      $model->$field = ($value === 1 ? 0 : 1);
      $model->update(array($field));
      $value = $model->$field;
      echo CJSON::encode(array('message' => 'Данные успешно обновлены', 'value' => $value, 'idInstance' => $idInstance, 'idObjectParameter' => $idObjectParameter));
    } catch (Exception $e) {
      echo CJSON::encode(array('error' => $e->getMessage(), 'value' => $value, 'idInstance' => $idInstance, 'idObjectParameter' => $idObjectParameter));
    }
  }
}