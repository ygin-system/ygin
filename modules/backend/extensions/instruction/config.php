<?php

return array(
  'category' => BackendModule::CATEGORY_BACKEND_WINDOW,
  'class' => 'backend.extensions.instruction.InstructionController',
  'rules' => array('instruction/*' => 'instruction'),
  'application' => array(
    'controllerMap' => array('instruction' => 'backend.extensions.instruction.InstructionController'),
  )
);

?>
