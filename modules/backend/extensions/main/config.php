<?php

return array(
  'category' => BackendModule::CATEGORY_BACKEND_WINDOW,
  'class' => 'backend.extensions.main.MainPageController',
  'rules' => array('' => 'mainPage'),
  'application' => array(
    'controllerMap' => array('mainPage' => 'backend.extensions.main.MainPageController'),
    //'defaultController' => 'mainPage',
  )
);

?>
