<?php

Yii::import('backend.controllers.ViewController', true);
Yii::import('backend.controllers.DefaultController', true);

/**
 * Экземпляры классов, расширяющий данный классы, позволяют задать более гибкое поведение объеков в административной части системы
 */
class BackendEventHandler extends CComponent {
  public $idObject = null;

  public function __construct($owner, $idObject) {
    $this->idObject = $idObject;
    $events = array(
      ViewController::EVENT_ON_PARAMETER_AVAILABLE => 'onParameterAvailable',
      ViewController::EVENT_ON_INSTANCE_AVAILABLE => 'onInstanceAvailable',
      ViewController::EVENT_ON_CREATE_VISUAL_ELEMENT => 'onCreateVisualElement',
      ViewController::EVENT_ON_POST_FORM => 'onPostForm',

      DefaultController::EVENT_ON_PARAMETER_AVAILABLE_TO_SEARCH => 'onParameterAvailableToSearch',
      DefaultController::EVENT_ON_BEFORE_GRID => 'onBeforeGrid',
      DefaultController::EVENT_ON_PROCESS_PERMISSION_WHERE => 'onProcessPermissionWhere',
      DefaultController::EVENT_ON_CREATE_INSTANCE => 'onCreateInstance',
      DefaultController::EVENT_ON_CONFIGURE_DATA_PROVIDER => 'onConfigureDataProvider',
    );
    foreach($events AS $event => $handlerMethod) {
      $owner->attachEventHandler($event, array($this, $handlerMethod));
    }
  }

  /**
   * Позволяет задать статус отображения свойств объекта в административной части системы при редактировании/просмотра экземпляра объекта.
   * Измененный статус будет влиять на отображение параметра/экземпляра
   *
   * @param ParameterAvailableEvent $event
   */
  public function onParameterAvailable(ParameterAvailableEvent $event) {
    if (isset($event->params['mode']) && $event->params['mode'] == 'seqKey') { //  TODO позже, когда последовательность переедет в полноценную колонку представления это надо будет убрать
      $seqKey = $event->objectParameter;
      $sender = $event->sender;
      $grpParam = $sender->getGroupParameter();

      $typeSeq = intval($seqKey->getAdditionalParameter());
      if ($typeSeq == 0) {  // по умолчанию - если группироки нет, то сам объект, а если есть то во всех группировках
        // Если сейчас не группировки по объекту и если у данного объекта есть свойства с типом=объект и если по ним стоит группировка, то порядок не отображаем.
        if ($grpParam == null) { // по умолчанию, если у объекта есть группирующее свойство, то сортировку не делаем
          $listParam = Yii::app()->backend->object->parameters;
          foreach($listParam AS $p) {
            if ($p->getType() == DataType::OBJECT && $p->getTypeGroup()) {
              $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
              break;
            }
          }
        }
      } else if ($typeSeq == -1) {  // только из объекта
        if ($grpParam != null) $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      } else if ($grpParam == null || $typeSeq != $grpParam->getIdParameter()) {  // только из конкретного объекта группировки
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      }
    }
  }

  /**
   * Позволяет тонко сконфигурировать провайдера данных представления
   *
   * @param ConfigureDataProviderEvent $event
   */
  public function onConfigureDataProvider(ConfigureDataProviderEvent $event) {
  }

  /**
   * Позволяет тонко сконфигурировать грид перед самой отрисовкой
   *
   * @param BeforeGridEvent $event
   */
  public function onBeforeGrid(BeforeGridEvent $event) {
  }

  /**
   * Определяет статус экземпляра - доступен для изменения, только для чтения, не доступен.
   * @param InstanceAvailableEvent $event
   */
  public function onInstanceAvailable(InstanceAvailableEvent $event) {
  }

  /**
   * Позволяет уточнить where-условие для ограничения доступа пользователю.
   * Если событие onConfigureDataProvider ограничивает лишь отображение записи в таблице представления (grid), то данное событие ограничивает в целом доступ к экземпляру.
   *
   * @param PermissionWhereEvent $event - событие системы
   */
  public function onProcessPermissionWhere(PermissionWhereEvent $event) {
  }

  /**
   * Показывает системе, есть ли возможность создавать экземпляры. Позволяет, к примеру, ограничить число создаваемых экземпляров для определённой группы пользователей.
   * @param CreateInstanceEvent $event
   */
  public function onCreateInstance(CreateInstanceEvent $event) {
  }

  public function getTypesOfInstanceCreated() {
    return array();
  }

  /**
   * Проверяет на необходимость отображение свойства объекта в форме поиска.
   *
   * @param ParameterAvailableToSearchEvent $event
   */
  public function onParameterAvailableToSearch(ParameterAvailableToSearchEvent $event) {
  }
  /**
   * Позволяет переопределить визуальный элемент в административной части системы.
   *
   * @param CreateVisualElementEvent $event
   */
  public function onCreateVisualElement(CreateVisualElementEvent $event) {

  }

  /**
   * Вызывается при сохранении формы
   *
   * @param PostFormEvent $event
   */
  public function onPostForm(PostFormEvent $event) {

  }
  public function copyInstanceAccess() {
    return false;
  }
}
