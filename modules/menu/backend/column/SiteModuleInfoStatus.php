<?php

class SiteModuleInfoStatus extends BaseColumn {

  public $htmlOptions = array('class'=>'col-ref');

  protected function renderDataCellContent($row, $data) {
    // value - id handler of module;
    if ($data->getIdPhpScriptInstance() != null) {
      $phpScriptInstance = $data->phpScriptInstance(array('with'=>'phpScript'));
      $phpScript = $phpScriptInstance->phpScript;
      if ($phpScript == null) {echo '-'; return;}
      $name = $phpScript->description;
      $path = $phpScript->file_path;
      $title = '';
      if (Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
        $title .= 'обработчик: '.CHtml::encode($name).' '.$path;
      }     
      echo '<i rel="tooltip" class="icon-magnet" data-original-title="'.$title.'"></i>';
    }
  }
  
}
