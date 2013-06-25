<?php
class UserPasswordWidget extends VisualElementWidget {

  public $readOnlyView = false;

  public function init() {
    parent::init();
    $this->model->addValidator(CValidator::createValidator('required', $this->model, array($this->attributeName), array('on'=>'backendInsert')));
  }

  public function getCaption() {
    /**
     * @var DaActiveRecord $model
     */
    $model = $this->model;
    if (!$model->isNewRecord) {
      return 'Изменить пароль';
    }
    return parent::getCaption();
  }

  /*public function onPostForm(PostFormEvent $event) {
    $value = HU::postModelAttr($this->model, $this->attributeName);
    if ($value == null) HU::unsetPostModelAttr($this->model, $this->attributeName);  // чтобы при обработке общего контроллера не затерся старый пароль
  }*/

}
