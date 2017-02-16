<?php

class VoteModule extends DaWebModuleAbstract implements IApplicationComponent {
  
  public $numVoteIp = 1; //кол-во голосов за указанный период
  public $expiredTimout = 24; // время в часах, в течение которого пользователю нельзя повторно голосовать
  public $checkByIp = true; // Блокировать повторные голосования по IP
  public $checkByCookie = true; // Блокировать повторные голосования по IP

  const ROUTE_VOTE = 'vote/voting/index';
  const ROUTE_VOTE_ACTION = 'vote/voting/vote';
  
  protected $_urlRules = array(
    'vote/<idVoting:\d+>' => self::ROUTE_VOTE,
    'vote' => self::ROUTE_VOTE,
    'vote/do' => self::ROUTE_VOTE_ACTION,
  );

  public function init() {
    $this->defaultController = 'voting';
    
    $this->setImport(array(
      'vote.models.*',
      'ygin.models.VisitSite',
      'vote.controllers.*',
      'vote.widgets.VoteWidget',
    ));
    
    Yii::app()->setComponent('vote', $this);
  }
  
  public function getIsInitialized() {
    return true;
  }
  
  public function check($idVote) {
    if ($this->checkByCookie){
      $t = Yii::app()->user->getState('vote_'.$idVote);
      if ($t != null && is_numeric($t) && ($t + ($this->expiredTimout*3600) > time())) {
        return false;
      }
    }
    if ($this->checkByIp){
      $ip = HU::getUserIp();
      return (VisitSite::check(Voting::ID_OBJECT, $idVote, 1, $ip, ($this->expiredTimout*3600), $this->numVoteIp));
    }
    return true;
  }

}
