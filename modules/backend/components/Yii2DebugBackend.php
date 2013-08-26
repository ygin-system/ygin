<?php

Yii::import('ygin.ext.yii2-debug.Yii2Debug', true);

class Yii2DebugBackend extends Yii2Debug {

    public function init() {
        if ($this->enabled) $this->enabled = Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV);
        parent::init();
    }
}