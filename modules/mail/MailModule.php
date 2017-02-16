<?php
class MailModule extends DaWebModuleAbstract
{
	public $notifierConfig = array(
	  'class' => 'Notifier',
	);
	
	public $mailerConfig = array(
	  'class' => 'YiiMail',
	  'transportType' => 'smtp',
	  'transportOptions' => array(),
	);
  
  public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			$this->getId().'.models.*',
			$this->getId().'.components.*',
			'ygin.ext.yii-mail.*',
		));
		
		if (!Yii::app()->hasComponent('notifier')) {
		  Yii::app()->setComponent('notifier', Yii::createComponent($this->notifierConfig));
		}
		
		if (!Yii::app()->hasComponent('mailer')) {
		  Yii::app()->setComponent('mailer', Yii::createComponent($this->mailerConfig));
		}
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function getVersion() {
	  return '0.0.1';
	}
	
	public function getDescription() {
	  return 'Модуль почтовой рассылки';
	}
}
