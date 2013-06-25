<?php

class AnswerListWidget extends VisualElementWidget {

  public $countAnswers = 12;
  public $answers = array();

  public function init() {
    parent::init();
    if (!$this->model->isNewRecord)
      $this->answers = $this->model->answer;
  }

  public function onPostForm(PostFormEvent $event) {
    $this->model->onAfterSave = array($this, 'afterSave');
  }
  public function afterSave($event) {
    $className = get_class(VotingAnswer::model());
    $postAnswers = HU::post($className, array());
    foreach($this->answers AS $answer) {
      /**
       * @var $answer VotingAnswer
       */
      if (isset($postAnswers[$answer->id_voting_answer]['name']) && trim($postAnswers[$answer->id_voting_answer]['name']) != '') {
        $answer->name = trim($postAnswers[$answer->id_voting_answer]['name']);
        $answer->update(array('name'));
      } else {
        $answer->delete();
      }
    }
    foreach($postAnswers AS $i => $name) {
      if ($i > 0) continue;
      if (trim($name['name']) == '') continue;
      $answer = BaseActiveRecord::newModel($className, 'backendInsert');
      $answer->id_voting = $this->model->id_voting;
      $answer->name = trim($name['name']);
      $answer->save();
    }

  }

}
