<?php

class ManageModuleWidget extends VisualElementWidget {
  public function onPostForm(PostFormEvent $event) {
    $this->model->attachEventHandler('onAfterSave', array($this, 'processModel'));
  }

  public function processModel(CEvent $event) {
    $model = $this->model;
    $idInstance = $model->getIdInstance();

    // Удаляем все модули для данного шаблона
    SiteModulePlace::model()->resetScope()->deleteAllByAttributes(array('id_module_template' => $idInstance));

    // Получаем все модули
    $modules = SiteModule::model()->resetScope()->findAll();
    foreach($modules AS $m) {
      $idModule = $m->getIdInstance();
      $placePos    = HU::post("mod_".$idModule."_plc");
      $seq      = HU::post("mod_".$idModule."_seq");

      if (!$placePos || $placePos == "onVisible") continue;
      if (!is_numeric($seq)) $seq = 0;

      $place = new SiteModulePlace();
      $place->id_module = $idModule;
      $place->id_module_template = $idInstance;
      $place->place = $placePos;
      $place->sequence = $seq;
      $place->save();
    }
  }
}
