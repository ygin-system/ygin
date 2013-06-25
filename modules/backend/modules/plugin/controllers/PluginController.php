<?php

class PluginController extends DaObjectController {

  protected $idObject = 528;
  
  public function actionIndex() {
    // список всех плагинов
    $plugins = Yii::app()->getPlugins();
    // все плагины регистрируем в бд
    // TODO если в базе нашлись плагины, которых уже нет, то помечаем их как удаленные
    // список плагинов, зарегистрированных в системе
    $pluginsDb = Plugin::model()->findAll();
    $finded = array();
    foreach($plugins AS $code => $config) {
      if (is_int($code)) {
        $code = $config;
        $config = array();
      }
      if (!isset($config['class'])) $config['class'] = $code;

      foreach($pluginsDb AS $plugin) {
        if ($plugin->code == $code) {
          if ($plugin->class_name != $config['class']) {
            $plugin->class_name = $config['class'];
            $plugin->save();
          }
          $finded[] = $code;
          continue(2);
        }
      }
      // плагина ещё нет в базе
      $newPlugin = new Plugin();
      $newPlugin->code = $code;
      $newPlugin->status = Plugin::STATUS_NEW;
      $newPlugin->class_name = $config['class'];
      
      //-------------------
      $newPlugin->name = $newPlugin->getName(); // нигде не используется, исключительно для легкого чтения таблицы
      //-------------------
      $finded[] = $code;
      $newPlugin->save();
    }
    foreach($pluginsDb AS $plugin) {
      if (!in_array($plugin->code, $finded)) {
        // пропавшие плагины просто удаляем из базы
        try {
          $plugin->deactivate($plugin);
        } catch(Exception $e) {
        }
        $plugin->delete();
        Yii::app()->compilePluginsConfig();
      }
    }
    
    $plugins = Plugin::model()->notDeleted()->findAll(array('order'=>'name'));

    $this->render('/index', array(
      'plugins' => $plugins,
    ));

  }
  
  public function actionView($code) {
    $plugin = $this->throw404IfNull(Plugin::loadByCode($code));
    if ($plugin->status != Plugin::STATUS_ENABLE) {
      throw new CHttpException(404);
    }
    $params = $plugin->getSettingsOfParameters();
    $model = new PluginParameters();
    $model->setParameters($params);
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pluginForm') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
    
    if (isset($_POST['PluginParameters'])) {
      $model->attributes=$_POST['PluginParameters'];
      if ($model->validate()) {
        $paramsValue = $model->getParamsValue();
        $config = $plugin->getConfigByParamsValue($paramsValue, $plugin->getData());
        $plugin->setConfig($config);
        $plugin->onChangeConfig($plugin);
        $plugin->save();
        Yii::app()->compilePluginsConfig();
      }
    } else {
      $model->attributes = $plugin->getParamsValue();
    }
    
    $this->render('/view', array(
        'plugin' => $plugin,
        'model' => $model,
        'parameters' => $params,
    ));
  }
  
  public function filters() {
    return array(
      'ajaxOnly + turnOff, turnOn, delete',
    );
  }
  
  public function actionTurnOff($code) {
    $plugin = Plugin::loadByCode($code);
    if ($plugin == null) {
      echo CJSON::encode(array('error' => 'Запрашиваемый плагин не доступен.'));
      return;
    }
    if ($plugin->status == Plugin::STATUS_ENABLE) {
      // проверяем зависимости
      $allPlugin = Plugin::model()->enabled()->findAll();
      $depends = '';
      foreach ($allPlugin AS $current) {
        if (in_array($plugin->code, $current->getDepends())) {
          if ($depends != '') $depends .= ', ';
          $depends .= $current->name;
        }
      }
      if ($depends != '') {
        echo CJSON::encode(array('error' => 'Нет возможности отключить данный плагин, т.к. он используется другими: '.$depends.'.'));
        return;
      }
      
      // запускаем процедуру деактивации
      try {
        $plugin->deactivate($plugin);
      } catch(Exception $e) {
        echo CJSON::encode(array('error' => $e->getMessage()));
        return;
      }
      $plugin->status = Plugin::STATUS_DISABLE;
      $plugin->save();
      Yii::app()->compilePluginsConfig();
    }
    $html = $this->renderPartial('/_buttons', array('plugin' => $plugin), true);
    $result = array('html' => $html);
    if ($plugin->isMenuChange()) {
      $result['updateMenu'] = true;
    }
    echo CJSON::encode($result);
  }
  public function actionTurnOn($code) {
    $plugin = Plugin::loadByCode($code);
    if ($plugin == null) {
      echo CJSON::encode(array('error' => 'Запрашиваемый плагин не доступен.'));
      return;
    }
    if ($plugin->status == Plugin::STATUS_ENABLE) {
      echo CJSON::encode(array('error' => 'Плагин уже установлен и работает.'));
      return;
    }

    // проверяем зависимости
    $depends = $plugin->getDepends();
    $cr = new CDbCriteria();
    $cr->addInCondition('code', $depends);
    $allPlugin = Plugin::model()->enabled()->findAll($cr);
    $not = array();
    foreach ($depends AS $d) {
      foreach ($allPlugin AS $current) {
        if ($current->code == $d) {
          continue(2);
        }
      }
      $not[] = $d;
    }
    if (count($not) > 0) {
      echo CJSON::encode(array('error' => 'Нет возможности включить данный плагин, т.к. не подключены другие: ' . implode(', ', $not) . '.'));
      return;
    }

    if ($plugin->status == Plugin::STATUS_NEW) {
      // запускаем процедуру установки
      try {
        $plugin->install($plugin);
      } catch(Exception $e) {
        echo CJSON::encode(array('error' => $e->getMessage()));
        return;
      }
      $plugin->status = Plugin::STATUS_DISABLE;
      
      $model = new PluginParameters();
      $model->setParameters($plugin->getSettingsOfParameters());
      $plugin->setConfig( $plugin->getConfigByParamsValue($model->getParamsValue(), $plugin->getData()) );
    }
    if ($plugin->status == Plugin::STATUS_DISABLE) {
      // запускаем процедуру активации
      try {
        $plugin->activate($plugin);
      } catch(Exception $e) {
        echo CJSON::encode(array('error' => $e->getMessage()));
        return;
      }
      $plugin->status = Plugin::STATUS_ENABLE;
      $model = new PluginParameters();
      $model->setParameters($plugin->getSettingsOfParameters());
      $plugin->setConfig( $plugin->getConfigByParamsValue($model->getParamsValue(), $plugin->getData()) );
      $plugin->save();
      Yii::app()->compilePluginsConfig();
    }
    $html = $this->renderPartial('/_buttons', array('plugin' => $plugin), true);
    $result = array('html' => $html);
    if ($plugin->isMenuChange()) {
      $result['updateMenu'] = true;
    }
    echo CJSON::encode($result);
  }
  public function actionDelete($code) {
    echo 'alert("Удаление модуля временно не доступно.");';
  }


}