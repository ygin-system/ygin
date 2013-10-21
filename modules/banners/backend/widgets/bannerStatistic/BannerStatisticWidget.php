<?php

class BannerStatisticWidget extends VisualElementWidget {

  public $viewStat = array();

  public function run() {
    if ($this->model->isNewRecord) return;
    $idBanner = $this->model->getIdInstance();

    $sql = 'SELECT view_type AS type, view_count AS stat FROM da_stat_view WHERE id_object=:obj AND id_instance=:inst';
    $rows = Yii::app()->db->createCommand($sql)->queryAll(true, array(':obj' => Banner::ID_OBJECT, ':inst' => $idBanner));
    $view = array();
    foreach($rows AS $row) {
      $view[$row['type']] = $row['stat'];
    }
    $this->viewStat = $view;

    parent::run();
  }

}
