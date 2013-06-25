<?php
abstract class SchedulerJob extends CComponent {
  private $_command;
  private $_idJob;

  const RESULT_OK = 0;
  
  public function __construct(CConsoleCommand $command, $idJob) {
    $this->_command = $command;
    $this->_idJob = $idJob;
    $this->init();
  }
  /**
   * @return CConsoleCommand
   */
  public function getCommand() {
    return $this->_command;
  }
  public function getIdJob() {
    return $this->_idJob;
  }
  
  public function init() {}
  
  abstract public function run();
}