<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="pragma" content="no-cache">
  <meta name="copyright" content="&copy; ygin">
<?php
  Yii::app()->clientScript->registerMetaTag('CMS, модули, редактирование контента, голосование, администрирование', 'keywords');
  Yii::app()->clientScript->registerMetaTag('CMS ygin', 'description');
  Yii::app()->clientScript->registerLinkTag('icon', "image/x-icon", '/favicon.ico');

  // Подключаемые ява-скрипты и стили искать в файле /ygin/config/packages.php
  Yii::app()->clientScript->registerCoreScript('jquery');
  Yii::app()->clientScript->registerCoreScript('jquery.ui');
  Yii::app()->clientScript->registerCoreScript('bootstrap_ygin');
  Yii::app()->clientScript->registerCoreScript('ygin');
  
  $this->registerCssFile('auth.css', 'backend.assets.css');
  $this->registerCssFile('bootstrap-responsive.min.css', 'ygin.assets.bootstrap.css');
  $ass       = Yii::getPathOfAlias('ygin.assets.bootstrap.img').DIRECTORY_SEPARATOR;
  $backendAss = Yii::getPathOfAlias('ygin.modules.backend.assets.gfx').DIRECTORY_SEPARATOR;
  Yii::app()->clientScript->addDependResource('bootstrap.min.css', array(
    $ass.'glyphicons-halflings.png' => '../img/',
    $ass.'glyphicons-halflings-white.png' => '../img/',
    $ass.'glyphicons-halflings-red.png' => '../img/',
    $ass.'glyphicons-halflings-green.png' => '../img/',
  ));
  
  Yii::app()->clientScript->addDependResource('auth.css', array(
    $backendAss.'body.png' => '../gfx/',
    $backendAss.'grad.png' => '../gfx/',
    $backendAss.'input-bg.gif' => '../gfx/',
  ));
?>
  <title><?php echo CHtml::encode($this->getPageTitle().' © ygin'); ?></title>
</head>
<body>
<table class="b-main-table"><tr><td>
<?php echo $content; ?>
</td></tr></table>

</body>
</html>
