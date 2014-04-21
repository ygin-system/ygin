<?php

abstract class BillingComponent extends CApplicationComponent {

  /**
    Например, так могут быть заданы настройки компоненты в конфиг-файле. Также должны быть заданы платежные пароли в настройках сайта.
    'billing' => array(
      'class' => 'shop.components.Moneta',
      'isTest' => false,
    ),
   */
  public $sMerchantLogin;
	public $sMerchantPass1;
	public $sMerchantPass2;
	public $sCulture = 'ru';

	public $resultMethod = 'post';
	public $sIncCurrLabel;
	public $orderModel = 'Invoice';
	public $priceField = 'amount';
	public $isTest = false;

	public $params;

  public $invoiceIdParamName;

  public $paramNameLogin;
  public $paramNamePass1;
  public $paramNamePass2;

	protected $_order;

	public abstract function pay($nOutSum, $nInvId, $sInvDesc);
  public abstract function result();
	protected abstract function getPaySign($nOutSum, $nInvId);

	protected function isOrderExists($id) {
		$this->_order = BaseActiveRecord::model($this->orderModel)->findByPk((int)$id);
		if($this->_order)
			return true;
		return false;
	}

  protected function checkResultSignature($outSum, $invId, $signatureValue)
  {
    return $this->getPaySign($outSum, $invId) == $signatureValue;
  }

	public function onSuccess($event)
	{
		$this->raiseEvent('onSuccess', $event);
	}

	public function onFail($event)
	{
		$this->raiseEvent('onFail', $event);
	}
}
