<?php

class MainPageController extends DaBackendController implements IBackendExtension {

  const EVENT_ON_BEFORE_MAIN_RENDER = 'onBeforeMainRender';

  public function actionIndex() {
    $version = '';
    if (Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $version = Yii::app()->version.' от '.Yii::app()->versionDate;
      /*$lastMigration = DynamicActiveRecord::forTable('da_migration')->find(array('order'=>'apply_time DESC'));
      if (preg_match('~^.(\d{6}_\d{6}).*~', $lastMigration->version, $matches)) {
        $version = '20'.$matches[1];
      }*/
    }

    $showWelcome = true;
    $cookie = Yii::app()->request->cookies['daMainWelcome'];
    if ($cookie != null && $cookie->value == '1') $showWelcome = false;

    $devNotices = array();
    $noticeDevCookieName = null;
    if (Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
      $changeFile = Yii::getPathOfAlias('ygin').'/change_project.txt';
      $data = file_get_contents($changeFile);
      preg_match_all('~(\d{8})(.*?)(?=\d{8}|$)~s', $data, $matches);
      $lastDate = $matches[1][count($matches[1])-1];
      $noticeDevCookieName = 'yginDevNotice_'.$lastDate;

      $showDevNotice = true;
      $lastDateDb = Yii::app()->params['last_change_project_date'];
      if ($lastDateDb == null) {
        $showDevNotice = false;
        $parameter = new SystemParameter();
        $parameter->id_system_parameter = 'ygin-ext-main-lastChangeDate';
        $parameter->id_group_system_parameter = SystemParameter::GROUP_SYSTEM;
        $parameter->name = 'last_change_project_date';
        $parameter->value = $lastDate;
        $parameter->note = 'Последняя дата проектных обновлений';
        $parameter->id_parameter_type = SystemParameter::TYPE_VARCHAR;
        $parameter->save();
      } else {
        if ($lastDateDb == $lastDate) {
          $showDevNotice = false;
        } else {
          $cookie = Yii::app()->request->cookies[$noticeDevCookieName];
          if ($cookie != null && $cookie->value == '1') {
            $showDevNotice = false;
            $parameter = SystemParameter::model()->findByPk('ygin-ext-main-lastChangeDate');
            $parameter->value = $lastDate;
            $parameter->update(array('value'));
          }
        }
      }

      if ($showDevNotice) {
        $startShow = false;
        foreach($matches[1] AS $i => $date) {
          if ($startShow) {
            $devNotices[] = trim($matches[2][$i]);
          }
          if ($date == $lastDateDb) $startShow = true;
        }
      }
    }

    // важные сообщения о работе системы
    $alertError = array();
    if (YII_DEBUG) {
      $alertError[] = 'Включен debug-режим. При запуске сайта на production-сервере необходимо его выключить.';
    }
    if (Yii::app()->cache instanceof CDummyCache) {
      $alertError[] = 'Отключено кэширование. При запуске сайта на production-сервере необходимо настроить кэширование.';
    }
    /**
     * @var $logRouter CLogRouter
     * @var $emailRoute DaEmailLogRoute
     */
    $logRouter = Yii::app()->getComponent('log');
    $routes = $logRouter->getRoutes();
    $emailRoute = $routes['email_error'];
    if ($emailRoute->getHost() == null) {
      $alertError[] = 'Не настроена отправка уведомлений об ошибках на электронную почту.';
    }

    // черновая версия TODO
    $mainElements = array();
    if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, 528)) {
      $arrayItem = array(
        'name'=>'<i class="glyphicon glyphicon-wrench"></i> Плагины',
        'desc'=>'Дополнения к системе, позволяющие значительно расширить функционал сайта',
        'link-list'=>'/admin/page/528/',
      );
      $mainElements[] = $arrayItem;
    }

    if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, Menu::ID_OBJECT)) {
      $arrayItem = array(
        'name'=>'<i class="glyphicon glyphicon-list-alt"></i> Меню',
        'desc'=>'Пункты меню сайта являются основными страницами с постоянным содержимым.',
        'link-list'=>'/admin/page/'.Menu::ID_OBJECT.'/',
      );
      if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_CREATE, Yii::app()->user->id, Menu::ID_OBJECT)) {
        $arrayItem['link-add'] = '/admin/page/'.Menu::ID_OBJECT.'/-1/';
      }
      $mainElements[] = $arrayItem;
    }

    if (Yii::app()->hasModule('news') && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, News::ID_OBJECT)) {
      $arrayItem = array(
        'name'=>'<i class="glyphicon glyphicon-bullhorn"></i> Новости',
        'desc'=>'Модуль для написания периодической информации. Позволяет вести новостную ленту, размещая различные медиа-данные.',
        'link-list'=>'/admin/page/'.News::ID_OBJECT.'/',
      );
      if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_CREATE, Yii::app()->user->id, News::ID_OBJECT)) {
        $arrayItem['link-add'] = '/admin/page/'.News::ID_OBJECT.'/-1/';
      }
      $mainElements[] = $arrayItem;
    }
    if (Yii::app()->hasModule('photogallery') && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, Photogallery::ID_OBJECT)) {
      $arrayItem = array(
        'name'=>'<i class="glyphicon glyphicon-picture"></i> Фотогалереи',
        'desc'=>'Инструмент для массовой загрузки и удобного просмотра фотографий на сайте.',
        'link-list'=>'/admin/page/'.Photogallery::ID_OBJECT.'/',
      );
      if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_CREATE, Yii::app()->user->id, Photogallery::ID_OBJECT)) {
        $arrayItem['link-add'] = '/admin/page/'.Photogallery::ID_OBJECT.'/-1/';
      }
      $mainElements[] = $arrayItem;
    }
    if (Yii::app()->hasModule('faq') && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, Question::ID_OBJECT)) {
      $mainElements[] = array(
        'name'=>'<i class="glyphicon glyphicon-retweet"></i> Вопрос-ответ',
        'desc'=>'Раздел, создержащий форму для приёма вопросов от посетителей сайта с возможностью написания ответов.',
        'link-list'=>'/admin/page/'.Question::ID_OBJECT.'/',
      );
    }
    if (Yii::app()->hasModule('feedback') && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, Feedback::ID_OBJECT)) {
      $mainElements[] = array(
        'name'=>'<i class="glyphicon glyphicon-share-alt"></i> Обратная связь',
        'desc'=>'Механизм получения сообщений или заказов от посетителей сайта.',
        'link-list'=>'/admin/page/'.Feedback::ID_OBJECT.'/',
      );
    }

    $this->raiseEvent(self::EVENT_ON_BEFORE_MAIN_RENDER, new CEvent($this, array('elements' => &$mainElements)));

    $this->render('backend.extensions.main.view', array(
      'version' => $version,
      'showWelcome' => $showWelcome,

      'noticeDevCookieName' => $noticeDevCookieName,
      'devNotices' => $devNotices,
      'alertError' => $alertError,

      'mainElements' => $mainElements,
    ));

  }

  public function hasEvent($name) {
    return true;
  }

  // реализация события класса как компонента
  public function registerEvent($category, $obj) {
    if ($category == BackendModule::CATEGORY_BACKEND_WINDOW) {
      $obj->attachEventHandler(BackendModule::EVENT_ON_BEFORE_TOP_MENU, array($this, 'onBeforeTopMenu'));
    }
  }
  public function onBeforeTopMenu($event) {
    $sender = $event->sender;
    
    array_unshift($sender->items, array(
      'label' => 'Главная',
      'url' => Yii::app()->createUrl('mainPage'),
      'active' => false,
    ));
  }
}
