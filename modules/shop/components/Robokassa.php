<?php
class Robokassa extends BillingComponent {

	public $InvoiceIdParamName = 'InvId';

  public $paramNameLogin = 'robokassa_merchant_login';
  public $paramNamePass1 = 'robokassa_merchant_pass1';
  public $paramNamePass2 = 'robokassa_merchant_pass2';

  protected function getPaySign($nOutSum, $nInvId)
  {
    $keys = array(
      $this->sMerchantLogin,
      $nOutSum,
      $nInvId,
      $this->sMerchantPass1,
    );
    return md5(implode(':', $keys));
  }

	public function pay($nOutSum, $nInvId, $sInvDesc)
	{
		$sign = $this->getPaySign($nOutSum, $nInvId);

		$url  = $this->isTest
			? 'http://test.robokassa.ru/Index.aspx?'
			: 'https://merchant.roboxchange.com/Index.aspx?';

		$url .= "MrchLogin={$this->sMerchantLogin}&";
		$url .= "OutSum={$nOutSum}&";
		$url .= "InvId={$nInvId}&";
		$url .= "Desc={$sInvDesc}&";
		$url .= "SignatureValue={$sign}&";
		if (!empty($this->sIncCurrLabel)) {
		  $url .= "IncCurrLabel={$this->sIncCurrLabel}&";
		}
		$url .= "Culture={$this->sCulture}";

		Yii::app()->controller->redirect($url);
	}

	public function result()
	{
		$var = $_GET + $_POST;
		extract($var);
		$event = new CEvent($this);

		$valid = true;

		if($valid && !isset($OutSum, $InvId, $SignatureValue)){
			$this->params = array('reason'=>'Dont set need value');
			$valid = false;
		}

		if($valid && !$this->checkResultSignature($OutSum, $InvId, $SignatureValue))
		{
			$this->params = array('reason'=>'Signature fail');
			$valid = false;
		}

		if($valid && !$this->isOrderExists($InvId))
		{
			$this->params = array('reason'=>'Order not exists');
			$valid = false;
		}

		if($valid && $this->_order->{$this->priceField} > $OutSum)
		{
			$this->params = array('reason'=>'Order price error');
			$valid = false;
		}

		if($valid){
			if($this->hasEventHandler('onSuccess')){
				$this->params = array('order'=>$this->_order);
				$this->onSuccess($event);
			}
		}else{
			if($this->hasEventHandler('onFail')){
				$this->onFail($event);
        Yii::app()->end('FAIL');
			}
		}

		echo "OK{$InvId}\n";
	}

}
