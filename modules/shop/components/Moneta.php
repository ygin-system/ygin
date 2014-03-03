<?php
class Moneta extends BillingComponent {

  public $paramNameLogin = 'moneta_merchant_login';
  public $paramNamePass1 = 'moneta_merchant_pass1';
  public $paramNamePass2 = 'moneta_merchant_pass2';

  public $invoiceIdParamName = 'MNT_TRANSACTION_ID';

  public $sIncCurrLabel = 'RUB';

  protected function getPaySign($nOutSum, $nInvId) {
    $keys = array(
      $this->sMerchantLogin,
      $nInvId,
      number_format($nOutSum, 2, '.', ''),
      $this->sIncCurrLabel,
      "",
      $this->isTest ? "1" : "0",
      $this->sMerchantPass1
    );
    return md5(implode('', $keys));
  }

  public function pay($nOutSum, $nInvId, $sInvDesc)
  {
    $url  = 'https://www.payanyway.ru/assistant.htm?';
    $url .= "MNT_ID={$this->sMerchantLogin}&";
    $url .= "MNT_AMOUNT={$nOutSum}&";
    $url .= "MNT_TRANSACTION_ID={$nInvId}&";
    $url .= "MNT_DESCRIPTION ={$sInvDesc}&";
    $url .= "MNT_CURRENCY_CODE={$this->sIncCurrLabel}&";
    $url .= "MNT_SIGNATURE={$this->getPaySign($nOutSum,$nInvId)}&";
    $url .= "MNT_TEST_MODE=". ( $this->isTest ? 1 : 0 );

    Yii::app()->controller->redirect($url);
  }

  public function result()
  {
    $var = $_GET + $_POST;
    extract($var);
    $event = new CEvent($this);

    $valid = true;
        $_GET['InvId'] = $InvId = $MNT_TRANSACTION_ID;
        $_GET['SignatureValue'] = $SignatureValue = $MNT_SIGNATURE;
        $_GET['OutSum'] = $OutSum = (int)$MNT_AMOUNT;

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
        return $this->onFail($event);
      }
    }

    echo "OK{$InvId}\n";
  }

}
