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
  Yii::app()->clientScript->registerMetaTag('CMF, модули, редактирование контента, голосование, администрирование', 'keywords');
  Yii::app()->clientScript->registerMetaTag('CMF ygin', 'description');

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

  $bootstrapFont = Yii::getPathOfAlias('ygin.assets.bootstrap.fonts').DIRECTORY_SEPARATOR;
  $yginAss       = Yii::getPathOfAlias('ygin.assets.gfx').DIRECTORY_SEPARATOR;
  $backendAss    = Yii::getPathOfAlias('ygin.modules.backend.assets.gfx').DIRECTORY_SEPARATOR;
  Yii::app()->clientScript->addDependResource('bootstrap.min.css', array(
    $bootstrapFont.'glyphicons-halflings-regular.eot' =>  '../fonts/',
    $bootstrapFont.'glyphicons-halflings-regular.svg' =>  '../fonts/',
    $bootstrapFont.'glyphicons-halflings-regular.ttf' =>  '../fonts/',
    $bootstrapFont.'glyphicons-halflings-regular.woff' => '../fonts/',
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
  Yii::app()->clientScript->registerScript('admin.init', 'adminDrawInit(); $.daHintBind();', CClientScript::POS_READY);
?>
  <title><?php echo CHtml::encode($this->getPageTitle().' © ygin'); ?></title>
</head>
<body lang="ru">
<?php
  // Header
?>
  <div class="navbar navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-navbar-collapse"><span class="sr-only">Меню</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
<?php
  Yii::beginProfile('top menu', 'backend.layout.main');
  
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

  // Logo ygin
  if ($version){
    echo CHtml::link("ygin <span class=\"label label-danger\">CMF</span>", Yii::app()->homeUrl,
      array('class' => 'navbar-brand',
            'data-toggle' => "tooltip",
            'title'       => 'v. '.$version,
            )
    );
  } else {
    echo CHtml::link("ygin", Yii::app()->homeUrl, array('class' => 'navbar-brand'));
  }
?>
      </div><!-- .navbar-header -->
      <div class="collapse navbar-collapse" id="b-navbar-collapse">
<?php
  // Верхнее меню админки
  $topMenuWidget = $this->createWidget(Yii::app()->backend->topMenuWidget, array('htmlOptions' => array('class' => 'nav navbar-nav')));
  Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_TOP_MENU, new CEvent($topMenuWidget));
  $topMenuWidget->run();

  Yii::endProfile('top menu', 'backend.layout.main');
?>


<?php
  
  // Пользовательское меню (Профиль, Выход)
  if (Yii::app()->backend->userMenuWidget != null) {
    // TODO раскидать по расширениям
    $userMenuWidget = $this->createWidget(Yii::app()->backend->userMenuWidget, array('htmlOptions' => array('class' => 'dropdown-menu')) );
    if (Yii::app()->user->model != null && Yii::app()->authManager->checkObjectInstance(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, User::ID_OBJECT, Yii::app()->user->id, false)) {
      $userMenuWidget->items[] = array(
        'label' => '<i class="glyphicon glyphicon-edit"></i> Профиль',
        'active' => false,
        'url' => '/admin/page/24/'.Yii::app()->user->id.'/view/6/',  // TODO верно формировать ссылку
      );
    }

    Yii::app()->backend->raiseEvent(BackendModule::EVENT_ON_BEFORE_USER_MENU, new CEvent($userMenuWidget));

    if (count($userMenuWidget->items) > 0) {
      $userMenuWidget->items[] = array(
        'label' => '',
        'active' => false,
        'itemOptions' => array('class' => 'divider'),
      );
    }

    $userMenuWidget->items[] = array(
      'label' => '<i class="glyphicon glyphicon-share"></i> Выйти',
      'active' => false,
      'url' => Yii::app()->createUrl(UserModule::ROUTE_ADMIN_LOGOUT),
    );

    if (Yii::app()->user->model == null) {
      $userName = Yii::app()->user->name;
    } else {
      $userName   = (Yii::app()->user->model->full_name == null) ? Yii::app()->user->model->name : Yii::app()->user->model->full_name;
    }
?>
          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
              <button class="btn btn-default navbar-btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user icon-white"></i> <?php echo $userName; ?> <b class="caret"></b></button>
              <?php $userMenuWidget->run(); ?>
            </li>
<?php
    // Кнопка перехода на сайт
    if (Yii::app()->backend->rightTopWidget != null) {
      $this->widget(Yii::app()->backend->rightTopWidget);
    }
?>
          </ul>
<?php
  }
?>

      </div><!-- .navbar-collapse -->
    </div><!-- .container -->
  </div><!-- .navbar -->

<?php // Menu ?>
  <div class="container">
    <div class="row">
      <div id="menu-side-main" class="b-menu-side-main col-md-3 panel-group">
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
      <div class="b-content-container col-md-9">
        <?php if ($this->caption != null) echo CHtml::tag('h1', array(), $this->caption); ?>
        <?php echo $content; ?>
      </div><!-- .b-content-container -->
    </div><!-- .row -->
  </div><!-- .container -->
<?php // Footer ?>
  <hr>
  <footer class="container">
    <p>© 2014, <a href="http://www.ygin.ru" class="ygin-copy">ygin.ru</a></p>
  </footer>
</body>
</html>