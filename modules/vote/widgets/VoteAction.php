<?php
class VoteAction extends CAction {
  
  public function run() {
    $voting = null;
    if (is_numeric(HU::post('id_voting'))) {
      $voting = Voting::model()->onlyActive()->with('answer')->findByPk(HU::post('id_voting'));
    }
    if ($voting == null) {
      //echo CHtml::encode($this->controller->widget('vote.widgets.VoteWidget', null, true));
      return;
    }
    
    if (Yii::app()->vote->check($voting->id_voting)) {
      $answers = $_POST['VotingAnswer']['name'];
      $cr = new CDbCriteria();
      $cr->addColumnCondition(array('id_voting' => $voting->id_voting));
      if(is_array($answers)) {
        $cr->addInCondition('id_voting_answer', $answers);
      } else if (is_numeric($answers)) {
        $cr->addColumnCondition(array('id_voting_answer' => $answers));
      }
      VotingAnswer::model()->updateCounters(array('count'=>1), $cr);
      
      VisitSite::saveCurrentVisit(Voting::ID_OBJECT, $voting->id_voting);
      Yii::app()->user->setState('vote_'.$voting->id_voting, time());
      
      // перегружаем голосовалку, чтоб обновились показатели счетчиков
      $voting = Voting::model()->onlyActive()->with('answer')->findByPk($voting->id_voting);
    }
    
    $voteCount = $voting->getSumVote();
    
    echo CHtml::encode($this->controller->renderPartial("vote.widgets.views.statistic",array(
      'voting'=>$voting,
      'voteCount'=>$voteCount,
    )), null, true);
  }
}