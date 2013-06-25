<?php

class VotingController extends Controller {

  protected $urlAlias = "vote";
  
  public function filters() {
    return array(
      'ajaxOnly + vote',
    );
  }
  public function actions() {
    return array(
      'vote' => array(
        'class' => "vote.widgets.VoteAction",
      ),
    );
  }
  
  public function actionIndex($idVoting=null) {
    $voting = Voting::model()->onlyActive($order='name')->findAll();
    $this->render('/index',array(
      'voting' => $voting,
      'idVotingCurrent' => $idVoting,
    ));
  }

}
