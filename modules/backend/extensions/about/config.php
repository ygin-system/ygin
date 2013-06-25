<?php

return array(
  'category' => BackendModule::CATEGORY_BACKEND_WINDOW,
  'class' => 'backend.extensions.about.AboutController',
  'rules' => array('about' => 'about'),
  'application' => array(
    'controllerMap' => array('about' => 'backend.extensions.about.AboutController'),
  )
);

