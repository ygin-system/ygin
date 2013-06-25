<?php

Yii::import('ygin.ext.yii-debug-toolbar.YiiDebugToolbarRoute', true);

class YiiDebugToolbarRouteBackend extends YiiDebugToolbarRoute {

    public function init() {
        if ($this->enabled) $this->enabled = Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV);
        parent::init();
/*
        $this->enabled && $this->enabled = ($this->allowIp(Yii::app()->request->userHostAddress)
                && !Yii::app()->getRequest()->getIsAjaxRequest() && (Yii::app() instanceof CWebApplication));

        if ($this->enabled)
        {
            Yii::app()->attachEventHandler('onBeginRequest', array($this, 'onBeginRequest'));
            Yii::app()->attachEventHandler('onEndRequest', array($this, 'onEndRequest'));
            Yii::setPathOfAlias('yii-debug-toolbar', dirname(__FILE__));
            Yii::app()->setImport(array(
                'yii-debug-toolbar.*',
                'yii-debug-toolbar.components.*'
            ));
            $this->categories = '';
            $this->levels='';
        }*/
    }
}