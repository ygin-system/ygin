<?php


class DefaultController extends CController {
  public $breadcrumbs = array();
  public $caption;
  public $layout = 'main';
  public $view404 = 'ygin.views.404';
  public $view403 = 'ygin.views.access_denied';
  public $viewError = 'ygin.views.error';

  public function filters() {
    return array(
        'check +importDump, createUser, migrate',
        'postOnly + importDump, createUser, migrate',
        'checkDir +index'
    );
  }

  public function filtercheckDir($filterChain) {
    Yii::import('ygin.ext.TransferData');
    if (!TransferData::isResourceValid($_SERVER['HTTP_HOST'].$this->createUrl('step2'))) {
      $this->pageTitle = 'Error';
      throw new CHttpException(504, 'Система не смогла выполнить внутренние запросы.<br> Такое может произойти если система установлена в подпапку сайта (domain.ru/install_files/), либо при некорректной работе .htaccess файла');
    }
    $filterChain->run();
  }
  
  public function actionIndex() {
    $requirements = array(
      array(
        'require' => 'PHP >= 5.2.',
        'current' => 'PHP ' . PHP_VERSION,
        'pass' => version_compare(PHP_VERSION, '5.2', '>='),
      ),
      array(
        'require' => 'mbstring',
        'current' => extension_loaded('mbstring') ? 'Да' : 'Нет',
        'pass' => extension_loaded('mbstring'),
      )
    ,
      array(
        'require' => 'pdo_mysql',
        'current' => extension_loaded('pdo_mysql') ? 'Да' : 'Нет',
        'pass' => extension_loaded('pdo_mysql'),
      )
    );
    $dbSettings = $this->getDbSettingsModel();
    $userSettings = $this->getUserSettingsModel();
    $this->render('index', array(
      'requirements' => $requirements,
      'dbSettings' => $dbSettings,
      'userSettings' => $userSettings,
    ));
  }

  /**
   * @return DbSettings
   */
  public function getDbSettingsModel() {
    return Yii::app()->session->get('dbSettings', new DbSettings());
  }

  public function setDbSettingsModel($dbSettings) {
    Yii::app()->session['dbSettings'] = $dbSettings;
  }

  /**
   * @return UserSettings
   */
  public function getUserSettingsModel() {
    return Yii::app()->session->get('userSettings', new UserSettings());
  }

  public function setUserSettingsModel($userSettings) {
    Yii::app()->session['userSettings'] = $userSettings;
  }

  public function getLocalConfigFile() {
    return Yii::getPathOfAlias('application.config') . '/local.php';
  }

  public function getDumpFiles() {
    return glob(Yii::getPathOfAlias('install') . '/data/dump*.sql');
  }

  public function actionStep2() {
    $dbSettings = $this->getDbSettingsModel();
    if (isset($_POST['ajax']) && $_POST['ajax'] == 'db-settings-form') {
      echo CActiveForm::validate($dbSettings);
      if (!$dbSettings->hasErrors()) {
        $this->setDbSettingsModel($dbSettings);
      } else {
        $this->setDbSettingsModel(null);
      }
      Yii::app()->end();
    }
  }

  public function actionStep3() {
    $userSettings = $this->getUserSettingsModel();
    if (isset($_POST['ajax']) && $_POST['ajax'] == 'user-settings-form') {
      echo CActiveForm::validate($userSettings);
      if (!$userSettings->hasErrors()) {
        $this->setUserSettingsModel($userSettings);
      } else {
        $this->setUserSettingsModel(null);
      }
      Yii::app()->end();
    }
  }

  public function actionGetSettingsDetail() {
    $this->renderPartial('detail', array(
      'dbSettings' => $this->getDbSettingsModel(),
      'userSettings' => $this->getUserSettingsModel(),
    ));
  }

  public function validate() {
    $error = '';
    if (empty($this->dumpFiles)) {
      $error = 'Файлы дампов базы отсутствует. Установка невозможна.';
    } else {
      $dbSettings = $this->getDbSettingsModel();
      $userSettings = $this->getUserSettingsModel();
      if (!$dbSettings->validate()) {
        $errors = $dbSettings->getErrors();
        $error = print_r($errors, true);
      } elseif (!$userSettings->validate()) {
        $errors = $userSettings->getErrors();
        $error =  print_r($$errors, true);
      }
    }
    return $error;
  }
  
  public function filterCheck($filterChain) {
    if ($error = $this->validate()) {
      throw new CHttpException(500, $error);
    }
    $filterChain->run();
  }
  
  public function actionImportDump() {
    if (!($dumpFile = (int)Yii::app()->request->getPost('dumpFile'))) {
      throw new CHttpException(400, 'Не указан файл дампа.');
    }
    $dumps = $this->getDumpFiles();
    if ($dumpFile < 1 || $dumpFile > count($dumps)) {
      throw new CHttpException(400, 'Неверный файл дампа.');
    }
    $dbSettings = $this->getDbSettingsModel();
    $dbConnection = $dbSettings->getDbConnection();
    if ($dumpFile == 1 && $dbSettings->createDb) {
      Yii::log('Создание базы данных "'.$dbSettings->dbname.'"', CLogger::LEVEL_INFO, 'ygin.install');
      $dbSettings->createDb();
      $dbSettings->createDb = false;
      $this->setDbSettingsModel($dbSettings);
    }
    Yii::log('Импорт дампа "'.$dumps[$dumpFile - 1].'"', CLogger::LEVEL_INFO, 'ygin.install');
    $dbConnection->createCommand(file_get_contents($dumps[$dumpFile - 1]))->execute();
    echo CJSON::encode(array('success' => true));
  }
  
  public function actionMigrate() {
    $commandRunner = new CConsoleCommandRunner();
    $commandRunner->commands = array(
      'migrate'=>array(
          'class'=>'ygin.cli.commands.DaMigrateCommand',
          'migrationPath'=>'ygin.migrations',
          'migrationTable'=>'da_migration',
          'interactive' => false,
      ),
    );
    $commandRunner->addCommands(YII_PATH.'/cli/commands');
    $dbSettings = $this->getDbSettingsModel();
    $dbConnection = $dbSettings->getDbConnection();
    Yii::app()->setComponent('db', $dbConnection);
    ob_start();
    $resultCode = $commandRunner->run(array('yiic', 'migrate', 'up'));
    $message = ob_get_clean();
    if ($resultCode == 0) {
      echo CJSON::encode(array('success' => $message));
    }
  }
  
  public function actionCreateUser() {
    $dbSettings = $this->getDbSettingsModel();
    $dbConnection = $dbSettings->getDbConnection();
    Yii::app()->setComponent('db', $dbConnection);
    $userSettings = $this->getUserSettingsModel();
    $trans = $dbConnection->beginTransaction();
    $userModel = new User();
    $userModel->name = $userSettings->name;
    $userModel->mail = $userSettings->email;
    $userModel->user_password = $userSettings->password;
    $userModel->full_name = $userSettings->fullName;
    if (!$userModel->save()) {
      $errors = $userModel->getErrors();
      $trans->rollback();
      throw new CHttpException(500, "Не удалось добавить пользователя:\n".print_r($errors, true));
    } else {
      Yii::app()->authManager->assign(DaWebUser::ROLE_DEV, $userModel->id_user);
      $this->saveConfigFile($dbSettings);
      $this->setDbSettingsModel(null);
      $this->setUserSettingsModel(null);
      $trans->commit();
      echo CJSON::encode(array('success' => true));
    }
  }
  
  private function saveConfigFile($dbSettings) {
    file_put_contents($this->getLocalConfigFile(), $this->renderPartial('_local_config', array(
      'dbSettings' => $dbSettings,
    ), true));
    @chmod($this->getLocalConfigFile(), 0777);
  }
  public function actionSuccess() {
    $this->render('success');
  }
  public function actionError() {
    $view = $this->view403;
    if ($error = Yii::app()->errorHandler->error) {
      if ($error['code'] == 404) { // Устанавливаем свой макет для отображения 404 ошибки
        $this->layout = 'ygin.views.layouts.404';
        $view = $this->view404;
      } else if ($error['code'] == 403) { // доступ запрещен
        $view = $this->view403;
        if (empty($error['message'])) $error['message'] = 'Доступ к странице запрещен.';
      }
      if (Yii::app()->request->isAjaxRequest) {
        echo $error['message'];
        return;
      }
    } else {
      $this->layout = 'ygin.views.layouts.404';
    }
    $this->render($view, $error);
  }
}