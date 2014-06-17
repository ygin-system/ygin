<?php

class ViewController extends DaObjectController {

  const EVENT_ON_PARAMETER_AVAILABLE = 'onParameterAvailable';
  const EVENT_ON_INSTANCE_AVAILABLE = 'onInstanceAvailable';
  const EVENT_ON_CREATE_VISUAL_ELEMENT = 'onCreateVisualElement';
  const EVENT_ON_POST_FORM = 'onPostForm';

  const ENTITY_STATUS_AVAILABLE = 1; // доступно для редактирования
  const ENTITY_STATUS_READ_ONLY = 2; // доступно только для чтения
  const ENTITY_STATUS_NOT_VISIBLE = 3; // не доступно

  const MODE_VIEW = 0;
  const MODE_ERROR = 1;
  const MODE_SAVE_AND_CLOSE = 2;
  const MODE_ACCEPT = 3;
  const MODE_SAVE_AS_NEW = 4;
  const MODE_SAVE_AND_CREATE_NEW = 5;

  public $layout = 'backend.views.layouts.main';

  public $form = null;
  public $model = null;
  
  public function actionIndex() {
    /**
     * @var DaActiveRecord $model
     * @var DaObject $object
     */
    $object = Yii::app()->backend->object;
    $idObject = $object->id_object;
    $model = null;

    $id_v = HU::get(ObjectUrlRule::PARAM_ACTION_VIEW);
    $id = HU::post('id_instance');
    if ($id == null) {
      $id = HU::get(ObjectUrlRule::PARAM_OBJECT_INSTANCE);
    }

    if ($id == null && $id_v == null) {
      throw new CHttpException(400, 'Bad Request');
    }

    $statusProcess = intval(HU::post('submit_form', ViewController::MODE_VIEW));
    if (!in_array($statusProcess, array(ViewController::MODE_VIEW, ViewController::MODE_SAVE_AND_CLOSE, ViewController::MODE_ACCEPT, ViewController::MODE_SAVE_AND_CREATE_NEW))) {
      throw new CHttpException(400, 'Bad Request');
    }
    $readOnlyInstance = false;

    if ($id != null) {
      if ($id == -1) {
        if (!Yii::app()->authManager->canCreateInstance($idObject, Yii::app()->user->id)) {
          throw new CHttpException(403, 'Нет прав на создание');
        }
        $id = null;
      } else {
        // Редактируют, проверяем доступность текущему пользователю
        if (!Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, $idObject, $id)) {
          throw new CHttpException(403, 'Нет прав на редактирование или объект не существует');
        }
      }
    } else if ($id_v != null) {
      if ($id_v == -1) {
        throw new CHttpException(403);
      } else {
        if (!Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_VIEW, Yii::app()->user->id, $idObject, $id_v)) {
          throw new CHttpException(403, "Нет прав на просмотр");
        }
        $id = $id_v;
        $readOnlyInstance = true;
      }
    }

    if ($id != null) {
      $model = $object->getModel()->findByIdInstance($id);
      if ($model == null) throw new CHttpException(404);
      $model->setScenario('backendUpdate');
    } else {
      $model = $object->getModel(true);
      $model->setIsNewRecord(true);
      $model->setScenario('backendInsert');
    }

    $visualElementArray = array();

    $event = new InstanceAvailableEvent($this, $model);
    $this->raiseEvent(ViewController::EVENT_ON_INSTANCE_AVAILABLE, $event);
    $available = $event->status;

    if ($available == ViewController::ENTITY_STATUS_NOT_VISIBLE) { //Если нет прав на просмотр, то уходим
      return; // TODO
    }
    if ($available == ViewController::ENTITY_STATUS_READ_ONLY) $readOnlyInstance = true;

    $parameters = $object->parameters;
    foreach($parameters AS $objectParameter) {
      /**
       * @var $objectParameter ObjectParameter
       */
      // Детальная обработка:

      // Если свойство является группирующем, то устанавливаем значение по умолчанию
      if ($model->isNewRecord && HU::get(ObjectUrlRule::PARAM_GROUP_PARAMETER) == $objectParameter->getIdParameter()) {
        $model->{$objectParameter->getFieldName()} = HU::get(ObjectUrlRule::PARAM_GROUP_INSTANCE);
      }

      // Установка значений свойств экземпляра по умолчанию
      if ($objectParameter->getType() == DataType::SEQUENCE) {
        if ($model->isNewRecord) {
          $model->{$objectParameter->getFieldName()} = 0;
        }
      } else if ($objectParameter->getType() == DataType::ID_PARENT) {
        if ($model->isNewRecord) {
          // TODO - сделать проверку, что пользователь может создавать раздел в переданном ИД паренте
          $model->{$objectParameter->getFieldName()} = HU::get(ObjectUrlRule::PARAM_OBJECT_PARENT);
        }
        if ($objectParameter->getAdditionalParameter() != 1) {
          continue;
        }
      }

      if (!$objectParameter->isVisible()) continue;
      $event = new ParameterAvailableEvent($this, $model, $objectParameter);
      $this->raiseEvent(ViewController::EVENT_ON_PARAMETER_AVAILABLE, $event);
      $availableStatus = $event->status;

      if ($availableStatus == ViewController::ENTITY_STATUS_NOT_VISIBLE) {  //Невидим
        continue;
      }

      $event = new CreateVisualElementEvent($this, $model, $objectParameter);
      $this->raiseEvent(ViewController::EVENT_ON_CREATE_VISUAL_ELEMENT, $event);
      $visualElement = $event->visualElement;

      // Если свойство является группирующем, то пропускаем его.
      /*if ($visualElement == null && HU::get(ObjectUrlRule::PARAM_GROUP_PARAMETER) == $objectParameter->getIdParameter()) {
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.hiddenField.HiddenFieldWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));

        $visualElementArray[] = $visualElement;
        $model->{$objectParameter->getFieldName()} = HU::get(ObjectUrlRule::PARAM_GROUP_INSTANCE);
        continue;
      }*/

      if ($visualElement == null) $visualElement = VisualElementFactory::getVisualElement($model, $objectParameter);

      if ($visualElement == null) continue;

      if (($availableStatus == ViewController::ENTITY_STATUS_READ_ONLY) ||
          ($readOnlyInstance)) {  //Только для чтения
        $visualElement->setReadOnly(true);
      }

      if ($objectParameter->getFieldName() != null && $model instanceof DaInstance && $visualElement instanceof VisualElementBaseWidget) {
        $model->addValidator(CValidator::createValidator('safe', $model, $objectParameter->getFieldName()));
      }
      $visualElementArray[] = $visualElement;

    }  // закончили обрабатывать свойства

    $modelClass = get_class($model);
    if (isset($_POST[$modelClass]) || isset($_POST['submit_form'])) {
      if (isset($_POST[$modelClass])) {
        $model->attributes=$_POST[$modelClass];
      }

      $event = new PostFormEvent($this, $model);
      $this->raiseEvent(ViewController::EVENT_ON_POST_FORM, $event);

      Yii::import('ygin.modules.search.components.SearchComponent', true);

      if ($model->isNewRecord) {  // insert
        if ($model->save()) {
          SearchComponent::replaceIndex($model);
          //$instance->updateObjectInstanceInfo(1);
          $newIdInstance = $model->getIdInstance(false);
          $seqKey = $object->getFieldByType(DataType::SEQUENCE);
          if ($seqKey != null) {
            $pk = $object->getFieldByType(DataType::PRIMARY_KEY);
            $max = Yii::app()->db->createCommand('SELECT MAX('.$seqKey.') FROM '.$object->table_name)->queryScalar();
            $sql = 'UPDATE '.$object->table_name.' SET '.$seqKey.' = :max WHERE '.$pk.'=:id';
            Yii::app()->db->createCommand($sql)->execute(array(':max'=>($max+1), ':id' => $newIdInstance));
          }
          Yii::log('Добавлен новый экземпляр ('.$object->getName().') id='.$newIdInstance, CLogger::LEVEL_INFO, 'backend.model.insert');
        } else {
          $statusProcess = ViewController::MODE_ERROR;
        }
      } else {
        if ($model->save()) {
          SearchComponent::replaceIndex($model);
          //$instance->updateObjectInstanceInfo(2);
          Yii::log('Изменение ('.$object->getName().') id='.$model->getIdInstance(), CLogger::LEVEL_INFO, 'backend.model.update');
        } else {
          $statusProcess = ViewController::MODE_ERROR;
        }
      }
    }

    if ($statusProcess == ViewController::MODE_ERROR || $statusProcess == ViewController::MODE_VIEW) {
      $this->render('/view', array(
        'model' => $model,
        'visualElementArray' => $visualElementArray,
      ));
    } else if ($statusProcess == ViewController::MODE_ACCEPT) {
      $url = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_VIEW, array(ObjectUrlRule::PARAM_OBJECT_INSTANCE => $model->getIdInstance()));
      $this->redirect($url);
    } else if ($statusProcess == ViewController::MODE_SAVE_AND_CLOSE) {
      $url = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(), array(ObjectUrlRule::PARAM_OBJECT_INSTANCE, ObjectUrlRule::PARAM_ACTION_VIEW));
      $this->redirect($url);
    } else if ($statusProcess == ViewController::MODE_SAVE_AND_CREATE_NEW) {
      $url = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_VIEW, array(ObjectUrlRule::PARAM_OBJECT_INSTANCE => -1));
      $this->redirect($url);
    }

  }

}