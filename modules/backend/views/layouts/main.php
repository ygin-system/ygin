<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <meta name="copyright" content="&copy; ygin">
  <link href='http://fonts.googleapis.com/css?family=Russo+One&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<?php
  Yii::app()->clientScript->registerMetaTag('CMS, модули, редактирование контента, голосование, администрирование', 'keywords');
  Yii::app()->clientScript->registerMetaTag('CMS ygin', 'description');

  $ass = Yii::getPathOfAlias('backend.assets.gfx');
  Yii::app()->clientScript->registerLinkTag('icon', "image/x-icon", Yii::app()->getAssetManager()->publish($ass).'/favicon.ico');
  
  // Подключаемые ява-скрипты и стили искать в файле /ygin/config/packages.php
  Yii::app()->clientScript->registerCoreScript('jquery');
  Yii::app()->clientScript->registerCoreScript('jquery.ui');
  Yii::app()->clientScript->registerCoreScript('bootstrap_ygin');
  Yii::app()->clientScript->registerCoreScript('bootstrap_ygin.datepicker');
  Yii::app()->clientScript->registerCoreScript('bootstrap_ygin.timepicker');
  Yii::app()->clientScript->registerCoreScript('cookie');
  Yii::app()->clientScript->registerCoreScript('daGallery');
  Yii::app()->clientScript->registerCoreScript('ygin');

  $this->registerCssFile('bootstrap-responsive.min.css', 'ygin.assets.bootstrap.css');
  $ass       = Yii::getPathOfAlias('ygin.assets.bootstrap.img').DIRECTORY_SEPARATOR;
  $yginAss   = Yii::getPathOfAlias('ygin.assets.gfx').DIRECTORY_SEPARATOR;
  $backendAss = Yii::getPathOfAlias('ygin.modules.backend.assets.gfx').DIRECTORY_SEPARATOR;
  Yii::app()->clientScript->addDependResource('bootstrap.min.css', array(
    $ass.'glyphicons-halflings.png' => '../img/',
    $ass.'glyphicons-halflings-white.png' => '../img/',
    $ass.'glyphicons-halflings-red.png' => '../img/',
    $ass.'glyphicons-halflings-green.png' => '../img/',
  ));
  Yii::app()->clientScript->addDependResource('ygin.css', array(
    $backendAss.'actions.png' => '../gfx/',
    $backendAss.'digitalAge.png' => '../gfx/',
    $backendAss.'fileIcons.png' => '../gfx/',
    $backendAss.'input-bg.gif' => '../gfx/',
    $backendAss.'misc.png' => '../gfx/',
    $backendAss.'ygin_icon.png' => '../gfx/',
    $backendAss.'textareabg.gif' => '../gfx/',
    Yii::getPathOfAlias('ygin.assets.gfx').'/loading_s.gif' => '../../../../assets/gfx/',
  ));
  Yii::app()->clientScript->addDependResource('yginTollBar.css', array(
    $yginAss.'siteToolBar.png' => '../../../../assets/gfx/',
  ));
  
  
  Yii::app()->clientScript->registerScript('admin.init', 'adminDrawInit(); $.daHintBind();', CClientScript::POS_READY);
?>
  <title><?php echo CHtml::encode($this->getPageTitle().' © ygin'); ?></title>
</head>
<body lang="ru">
<?php
  // Version
  $version = '';
  if (Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
    $version = Yii::app()->version.' от '.Yii::app()->versionDate;
    /*
    // $version = Yii::app()->params["version"]; // старое хранилище версии
    $lastMigration = DynamicActiveRecord::forTable('da_migration')->find(array('order'=>'apply_time DESC'));
    if (preg_match('~^.(\d{6}_\d{6}).*~', $lastMigration->version, $matches)) {
      $version = '20'.$matches[1];
    }
    */
  }
  
  // Header
?>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
<?php
  Yii::beginProfile('top menu', 'backend.layout.main');
  // Logo ygin
  if ($version){
    echo CHtml::link("ygin <span class=\"label label-important\">cms</span>", Yii::app()->homeUrl,
      array('class' => 'brand',
            'data-original-title' => 'v. '.$version,
            )
    );
  } else {
    echo CHtml::link("ygin", Yii::app()->homeUrl, array('class' => 'brand'));
  }
  
  // Кнопка перехода на сайт
  if (Yii::app()->backend->rightTopWidget != null) {
    $this->widget(Yii::app()->backend->rightTopWidget);
  }
  
  // Пользовательское меню (Профиль, Выход)
  if (Yii::app()->backend->userMenuWidget != null) {
    // TODO раскидать по расширениям
    $userMenuWidget = $this->createWidget(Yii::app()->backend->userMenuWidget, array('htmlOptions' => array('class' => 'dropdown-menu')) );
    $userMenuWidget->items[] = array(
      'label' => '<i class="icon-edit"></i> Профиль',
      'active' => false,
      'url' => '/admin/page/24/'.Yii::app()->user->id.'/view/6/',  // TODO верно формировать ссылку и проверять есть ли доступ к редактированию профиля
    );

    Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_USER_MENU, new CEvent($userMenuWidget));

    if (count($userMenuWidget->items) > 0) {
      $userMenuWidget->items[] = array(
        'label' => '',
        'active' => false,
        'itemOptions' => array('class' => 'divider'),
      );
    }

    $userMenuWidget->items[] = array(
      'label' => '<i class="icon-share"></i> Выйти',
      'active' => false,
      'url' => Yii::app()->createUrl(UserModule::ROUTE_ADMIN_LOGOUT),
    );

    if (Yii::app()->user->model == null) {
      $userName = Yii::app()->user->name;
    } else {
      $userName   = (Yii::app()->user->model->full_name == null) ? Yii::app()->user->model->name : Yii::app()->user->model->full_name;
    }
    echo '<div class="btn-group pull-right">
          <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> '.$userName.' <span class="caret"></span></button>';
    $userMenuWidget->run();
    echo '</div>';
  }
  
  // Верхнее меню админки
?>
        <div class="nav-collapse pull-right">
<?php
  $topMenuWidget = $this->createWidget(Yii::app()->backend->topMenuWidget, array('htmlOptions' => array('class' => 'nav')));
  Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_TOP_MENU, new CEvent($topMenuWidget));
  $topMenuWidget->run();

  Yii::endProfile('top menu', 'backend.layout.main');
?>
        </div>

    </div><!-- .navbar-inner -->
  </div><!-- .navbar -->

<?php // Menu ?>
  <div class="container-fluid">
    <div class="row-fluid">
      <div id="menu-side-main" class="b-menu-side-main span3 accordion">
<?php
  Yii::beginProfile('main menu', 'backend.layout.main');
  
  $mainMenuWidget = $this->createWidget(Yii::app()->backend->mainMenuWidget);
  Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_MAIN_MENU, new CEvent($mainMenuWidget));
  $mainMenuWidget->run();
  Yii::app()->clientScript->registerScript('admin.menu.init', '$("#menu-side-main").daAccordionMenu();', CClientScript::POS_READY);

  Yii::endProfile('main menu', 'backend.layout.main');
?>
      </div><!-- .b-menu-side-main -->

<?php // Content ?>
      <div class="b-content-container span9">
        <?php if ($this->caption != null) echo CHtml::tag('h1', array(), $this->caption); ?>
        <?php echo $content; ?>
      </div><!-- .b-content-container -->
    </div><!-- .row-fluid -->
  </div><!-- .container-fluid -->
<?php // Footer ?>
  <hr>
  <footer class="container-fluid">
    <p>© 2013, <a href="http://www.ygin.ru" class="ygin-copy">ygin</a></p>
  </footer>
</body>
</html>