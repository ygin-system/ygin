<?php

class SiteModuleEventHandler extends BackendEventHandler {

  public function onParameterAvailable(ParameterAvailableEvent $event) {
    parent::onParameterAvailable($event);
    if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) return;

    $param = $event->objectParameter;
    $name = $param->getFieldName();

    if ($name == 'id_php_script') {
      /**
       * @var $instance SiteModule
       */
      $instance = $event->model;

      // Определяем тип создаваемого/редактируемого раздела
      $static = true;
      if (!$instance->isNewRecord) {
        if ($instance->id_php_script != null) {
          $static = false;
        }
      } else {
        if (HU::get(ObjectUrlRule::PARAM_SYSTEM_MODULE) != null) {
          $static = false;
        }
      }

      if ($static) {
        $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
      }
    }

  }


  /**
   * Позволяет тонко сконфигурировать грид перед самой отрисовкой
   *
   * @param BeforeGridEvent $event
   */
  public function onBeforeGrid(BeforeGridEvent $event) {
    if (isset(Yii::app()->controller->buttons)) {
      foreach(Yii::app()->controller->buttons AS $key => $buttonConfig) {
        if (isset($buttonConfig['code']) && $buttonConfig['code'] == 'create') {

          // Модули - типы создаваемого экземпляра
          $addButtonData = null;
          $phpScripts = PhpScript::model()->findAllByAttributes(array('id_php_script_interface' => PhpScript::ID_PHP_SCRIPT_INTERFACE_MODULE));
          if (count($phpScripts) > 0) {
            $addButtonData = '<button class="btn navbar-btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
            $addButtonData .= '<ul class="dropdown-menu">'."\n";
            foreach($phpScripts AS $phpScript) {
              /**
               * @var $phpScript PhpScript
               */
              $linkModule = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(
                ObjectUrlRule::PARAM_OBJECT_INSTANCE => -1,
                ObjectUrlRule::PARAM_SYSTEM_MODULE => $phpScript->id_php_script_type,
              ));
              $addButtonData .= "<li><a href='".$linkModule."'>".$phpScript->description."</a></li>";
            }
            $addButtonData .= '</ul>'."\n";
          }
          $buttonConfig['addButtonData'] = $addButtonData;

          Yii::app()->controller->buttons[$key] = $buttonConfig;
          break;

        }
      }
    }
  }

}
