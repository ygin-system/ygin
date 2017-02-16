<?php
class VoteWidget extends DaWidget {
	
	public $inModule = true;
	public $idVoting = null;
	
  public function run() {	
  	$voting = null;
  	if ($this->inModule) {
  		if ($this->controller->id == 'voting') return; // находясь в разделе не показываем виджет
  		$voting = Voting::model()->inModule()->onlyActive()->with('answer')->find();
  	} else {
  		if ($this->idVoting == null) return;
  		$voting = Voting::model()->onlyActive()->with('answer')->findByPk($this->idVoting);
  	}
		if ($voting == null) return;

  	if (Yii::app()->vote->check($voting->id_voting)) {
			$this->render('index', array(
			  'view' => 'view',
        'voting' => $voting,
			  'voteCount' => 0,
      ));
		} else {
			$this->render('index', array(
			  'view' => 'statistic',
        'voteCount' => $voting->getSumVote(),
        'voting' => $voting,
      ));
		}
		
  }
}
