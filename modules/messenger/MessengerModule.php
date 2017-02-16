<?php
	class MessengerModule extends DaWebModuleAbstract {
  /**
   * Временной интервал в секундах.
   * Сообщения, которые не были отображены пользователю, старше данного интервала не будут выбираться из базы.
   * @var integer
   */
		
  public $expiredInterval = 43200;
  
  /**
   * Интервал, с которым будет выполнятся ajax-запрос на проверку новых сообщений
   * @var integer
   */
  
  public $ajaxRequestTimeout = 10;
  
  public $pluginOptions = array();
  
  public function init()
  {
    // this method is called when the module is being created
    // you may place code here to customize the module or the application
  
    // import the module-level models and components
    $this->setImport(array(
      $this->getId().'.models.*',
      $this->getId().'.components.*',
    ));
    
    if (Yii::app()->isBackend && !Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest) {
      $this->registerScripts();
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
    return 'Модуль уведомлений';
  }
  
  public function addMessage($message, $type = Message::TYPE_INFO, $senderId = null) {
    $model = new Message();
    $model->text = $message;
    $model->type = $type;
    $model->date = time();
    $model->sender = $senderId;
    $model->save(false);
  }
  
  public function registerScripts() {
    $cs = Yii::app()->clientScript;
    $assetsUrl = CHtml::asset($this->getBasePath().'/assets').'/';
    $cs->registerScriptFile($assetsUrl.'messenger.js');
    $options = array(
      'assetsUrl' => $assetsUrl,
      'newMessagesUrl' => Yii::app()->createUrl('messenger/default/getMessages'),
      'readMessageUrl' => Yii::app()->createUrl('messenger/default/readMessage'),
      'timeout' => $this->ajaxRequestTimeout * 1000,
    );
    $options = CMap::mergeArray($options, $this->pluginOptions);
    $cs->registerScript('messengerInit', '$.fn.messenger('.CJavaScript::encode($options).')', CClientScript::POS_READY);
  }
}