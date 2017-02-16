<?php

Yii::import('backend.extensions.instruction.Instruction');

class InstructionController extends DaBackendController implements IBackendExtension {

  public function actionIndex($id = null) {

    if ($id != null) {
      $instruction = $this->loadModelOr404('Instruction', $id);
      $relations = Instruction::model()->findAll('id_instruction IN (SELECT id_instruction_rel FROM da_instruction_rel WHERE id_instruction=:id)', array(':id'=>$instruction->id_instruction));
      
      $this->render('backend.extensions.instruction.views.view', array(
        'instruction' => $instruction,
        'rels' => $relations,
      ));      
      return;
    }
    
    $this->render('backend.extensions.instruction.views.index', array(
        'list' => Instruction::model()->findAll(),
    ));

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
      'label' => 'Инструкция',
      'url' => Yii::app()->createUrl('instruction'),
      //'url' => '/admin/page/62/', // TODO
      'active' => false,
    ));
  }
}
