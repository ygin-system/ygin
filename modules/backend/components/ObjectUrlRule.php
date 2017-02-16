<?php

class ObjectUrlRule extends CBaseUrlRule {

  const PARAM_GROUP_OBJECT = 'gObj';
  const PARAM_GROUP_INSTANCE = 'gInst';
  const PARAM_GROUP_PARAMETER = 'gParam';
  
  const PARAM_OBJECT = 'page';
  const PARAM_OBJECT_VIEW = 'view';
  const PARAM_OBJECT_INSTANCE = 'idInstance';
  const PARAM_OBJECT_PARENT = 'pkey';
  const PARAM_SYSTEM_MODULE = 'mod';
  const PARAM_PAGER_NUM = 'go';
  const PARAM_PAGER_NUM_BACK = 'goBack';

  const PARAM_ACTION_VIEW = 'vnum';
  
  private static $_currentUrlParams = array();

  public static function addCurrentUrlParams($param, $value) {
    self::$_currentUrlParams[$param] = $value;
  }
  public static function getCurrentParams() {
    return self::$_currentUrlParams;
  }
  public static function getCurrentParameter($name) {
    return (isset(self::$_currentUrlParams[$name]) ? self::$_currentUrlParams[$name] : null);
  }

  public function createUrl($manager, $route, $params, $ampersand) {
    $available = array(BackendModule::ROUTE_INSTANCE_LIST, BackendModule::ROUTE_INSTANCE_LIST_GROUP, BackendModule::ROUTE_INSTANCE_VIEW);
    if (in_array($route, $available) && isset($params[self::PARAM_OBJECT])) {
      $url = 'page/' . $params[self::PARAM_OBJECT] . '/';
      if (isset($params[self::PARAM_OBJECT_INSTANCE])) {
        $url .= $params[self::PARAM_OBJECT_INSTANCE] . '/';
      }
      foreach ($params AS $key => $value) {
        if ($key == self::PARAM_OBJECT_INSTANCE) {
          continue;
        } else if ($key == self::PARAM_OBJECT_VIEW) {
          $url .= 'view/' . $value . '/';
        } else if ($key == self::PARAM_OBJECT) {
          continue;
        } else if ($value != null) {
          $url .= $key.'/'.$value.'/';
        }
      }
      return $url;
    }
    return false;
  }
  
  public static function createUrlFromCurrent($route, array $params, array $exclude=array()) {
    $params = array_merge(self::$_currentUrlParams, $params);
    $exclude = array_flip($exclude);
    $params = array_diff_key($params, $exclude);
    return Yii::app()->createUrl($route, $params);
  }

  public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
    $pathInfo .= '/';
    if (preg_match('~^page/([\da-zA-Z\-\_]+)(.*)~', $pathInfo, $matches)) {
      $idObject = $matches[1];
      $remainUrl = $matches[2];
      self::$_currentUrlParams[self::PARAM_OBJECT] = $idObject;
      $idInstance = null;
      $idView = null;
      if (preg_match('~^page/[\da-zA-Z\-\_]+/([\d\-]+|[a-zA-Z\d\_]+\-[a-zA-Z\d\-\_]+)(/.*)~', $pathInfo, $matches)) {
        $idInstance = trim($matches[1]);
        $remainUrl = $matches[2];
        if ($idInstance == '') $idInstance = null;
      }

      if ($idInstance != null) {
        self::$_currentUrlParams[self::PARAM_OBJECT_INSTANCE] = $idInstance;
        $_GET[self::PARAM_OBJECT_INSTANCE] = $idInstance;
      }

      preg_match_all('~([a-zA-z\-\_0-9]+)/(.+?)(?:/|$)~', $remainUrl, $matches);
      if (is_array($matches) && is_array($matches[1]) && count($matches[1]) > 0) {
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {
          $param = $matches[1][$i];
          if ($param == self::PARAM_OBJECT) continue;
          $value = $matches[2][$i];
          self::$_currentUrlParams[$param] = $value;
          $_GET[$param] = $value;
        }
        $idView = HArray::val(self::$_currentUrlParams, self::PARAM_OBJECT_VIEW);
      }

      // пока тут определяем текущий объект и представление
      if ($idView != null) {
        $objectView = DaObjectView::model()->with('columns:onlyVisible')->findByPk($idView);
        if ($objectView == null) throw new CHttpException(404);
        Yii::app()->backend->objectView = $objectView;
        Yii::app()->backend->object = DaObject::getById($objectView->id_object);
      } else {
        $object = DaObject::getById($idObject);
        if ($object == null || $object->table_name == null) throw new CHttpException(404);

        Yii::app()->backend->object = $object;
        if ($object->object_type == DaObject::OBJECT_TYPE_CONTROLLER) {
          return $object->table_name;
        }

        $cr = new CDbCriteria();
        $cr->addColumnCondition(array('t.id_object' => $idObject));
        $cr->order = 't.order_no';
        $objectView = DaObjectView::model()->with('columns:onlyVisible')->find($cr);
        if ($objectView == null) return false;
        $objectView->object = $object;
        Yii::app()->backend->objectView = $objectView;
      }

      if ($idInstance != null || isset(self::$_currentUrlParams[self::PARAM_ACTION_VIEW])) {
        return BackendModule::ROUTE_INSTANCE_VIEW;
      }

      if (isset(self::$_currentUrlParams[self::PARAM_GROUP_OBJECT])) {
        return BackendModule::ROUTE_INSTANCE_LIST_GROUP;
      }
      
      return BackendModule::ROUTE_INSTANCE_LIST;

    }
    return false;  // не применяем данное правило
  }

}

