<?php
$packages = require dirname(__FILE__).DIRECTORY_SEPARATOR.'../yii/web/js/packages.php';

// jQuery Core
$packages['jquery'] = array(
  //'basePath' => 'backend.assets.js',
  'basePath' => 'ygin.assets.js',
  'js' => array('jquery.js'),
);

// jQuery.Coockie
$packages['cookie'] = array(
  'basePath' => 'ygin.assets.js',
  'js'=>array('jquery.cookie.js'),
  'depends'=>array('jquery'),
);

// jQuery.daGallery
$packages['daGallery'] = array(
  'basePath' => 'ygin.assets.js',
  'js'=>array('daGallery-min.js'),
  'depends'=>array('jquery'),
);

// jQuery UI
$packages['jquery.ui'] = array(
  'basePath' => 'ygin.modules.backend.assets.js',
  'js'=>array('jquery-ui.custom.min.js'),
  'depends'=>array('jquery', 'jquery.ui.css'),
);
$packages['jquery.ui.css'] = array(
  'basePath' => 'ygin.modules.backend.assets.css.jquery-ui',
  'css'=>array('jquery-ui.custom.min.css'),
);

/*Mdi*/
$packages['mdi'] = array(
    'basePath' => 'ygin.assets.mdi.css',
    'css'=>array('materialdesignicons.min.css'),
);

// Bootstrap ygin
$packages['bootstrap_ygin'] = array(
  'basePath' => 'ygin.assets.bootstrap.js',
  'js'=>array('bootstrap.min.js'),
  'depends'=>array('jquery', 'bootstrap_ygin.css'),
);
$packages['bootstrap_ygin.css'] = array(
  'basePath' => 'ygin.assets.bootstrap.css',
  'css'=>array('bootstrap.min.css'),
);
$packages['bootstrap_ygin.datepicker'] = array(
  'basePath' => 'ygin.assets.bootstrap.js',
  'js'=>array('bootstrap-datepicker.js'),
  'depends'=>array('jquery', 'bootstrap_ygin', 'bootstrap_ygin.datepicker.css'),
);
$packages['bootstrap_ygin.datepicker.css'] = array(
  'basePath' => 'ygin.assets.bootstrap.css',
  'css'=>array('datepicker.css'),
);
$packages['bootstrap_ygin.timepicker'] = array(
  'basePath' => 'ygin.assets.bootstrap.js',
  'js'=>array('bootstrap-timepicker.js'),
  'depends'=>array('jquery', 'bootstrap_ygin', 'bootstrap_ygin.timepicker.css'),
);
$packages['bootstrap_ygin.timepicker.css'] = array(
  'basePath' => 'ygin.assets.bootstrap.css',
  'css'=>array('timepicker.css'),
);

/* Bootstrap project */
$packages['bootstrap'] = array(
  'basePath' => 'application.assets.bootstrap.js',
  'js'=>array('bootstrap.min.js'),
  'depends'=>array('jquery', 'bootstrap.css'),
);
$packages['bootstrap.css'] = array(
  'basePath' => 'application.assets.bootstrap.css',
  'css'=>array('bootstrap.min.css'),
);


// ygin
$packages['ygin'] = array(
  'basePath' => 'backend.assets.js',
  'js'=>array('ygin.js'),
  'depends'=>array('jquery', 'ygin.css'),
);
$packages['ygin.css'] = array(
  'basePath' => 'backend.assets.css',
  'css'=>array('ygin.css'),
);

return $packages;