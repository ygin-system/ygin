<?php

class DaFileLogRoute extends CFileLogRoute {

  protected function formatLogMessage($message,$level,$category,$time) {
    $user = Yii::app()->user;
    $userName = ($user == null ? 'guest' : $user->name);
    return parent::formatLogMessage('['.HU::getUserIp().'] '.$userName.' '.$message, $level, $category, $time);
  }

}
