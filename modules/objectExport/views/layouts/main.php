<!DOCTYPE html>
<html>
<head>
<!--[if lt IE 7]>
  <meta http-equiv="Refresh" content="0;URL=/ie6/index_ru.html">
<![endif]-->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="pragma" content="no-cache">
  <meta name="msapplication-window" content="width=1024;height=768">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=9" />
  
  <meta http-equiv="content-language" content="ru" > <?php // TODO - в будущем генетить автоматом ?>

<?php
  //Регистрируем файлы скриптов в <head>
  Yii::app()->clientScript->registerCoreScript('jquery');
  Yii::app()->clientScript->registerCssFile('/themes/business/bootstrap/css/bootstrap.min.css');
  Yii::app()->clientScript->registerScriptFile('/themes/business/bootstrap/js/bootstrap.min.js', CClientScript::POS_HEAD);
  $ass = Yii::getPathOfAlias('webroot.themes.business.bootstrap.fonts') . DIRECTORY_SEPARATOR;
  Yii::app()->clientScript->addDependResource('bootstrap.min.css', array($ass . 'glyphicons-halflings-regular.ttf' => '../fonts/', $ass . 'glyphicons-halflings-regular.svg' => '../fonts/', $ass . 'glyphicons-halflings-regular.eot' => '../fonts/', $ass . 'glyphicons-halflings-regular.woff' => '../fonts/',));
  //Yii::app()->clientScript->registerScriptFile('/themes/business/js/js.js', CClientScript::POS_HEAD);
  Yii::app()->clientScript->registerCssFile('/themes/business/css/content.css');
  Yii::app()->clientScript->registerCssFile('/themes/business/css/page.css');
?>
  <title><?php echo CHtml::encode($this->getPageTitle()); ?></title>
</head>
<body>
  <div id="wrap" class="container">
    <div class="b-menu-top">
    </div>


<?php // + Главный блок ?>
    <div id="main">

      <div id="container" class="row">
          <div class="cContent">
            <?php echo $content; ?>
          </div>
        </div>

    </div>
<?php // - Главный блок ?>
    
  </div>

</body>
</html>