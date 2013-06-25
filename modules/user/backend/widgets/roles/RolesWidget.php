<?php
class RolesWidget extends VisualElementWidget {

  protected $roles = array();
  protected $currentRoles = array();

  public function init() {
    parent::init();
    $this->roles = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_ROLE);
    if (!$this->model->isNewRecord) {
      $currentRoles = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_ROLE, $this->model->id_user);
      foreach($currentRoles AS $role) {
        $this->currentRoles[] = $role->name;
      }
    }
  }

  public function onPostForm(PostFormEvent $event) {
    $this->model->attachEventHandler('onAfterSave', array($this, 'processModel'));
  }

  public function processModel(CEvent $event) {
    $roles = HU::post('roles', array());
    foreach($this->currentRoles AS $role) {
      if (!in_array($role, $roles)) {
        Yii::app()->authManager->revoke($role, $this->model->id_user);
      }
    }
    foreach($roles AS $role) {
      if (!in_array($role, $this->currentRoles)) {
        Yii::app()->authManager->assign($role, $this->model->id_user);
      }
    }
  }

}
