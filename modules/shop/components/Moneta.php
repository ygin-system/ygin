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
    if (!isset($MNT_OPERATION_ID)) $MNT_OPERATION_ID = '';

    $event = new CEvent($this);

    $valid = true;
        $_GET['InvId'] = $invId = $MNT_TRANSACTION_ID;
        $_GET['SignatureValue'] = $signatureValue = $MNT_SIGNATURE;
        $_GET['OutSum'] = $outSum = floatval($MNT_AMOUNT);

    if($valid && !isset($outSum, $invId, $signatureValue)){
      $this->params = array('reason'=>'Dont set need value');
      $valid = false;
    }

    // change checking
    if($valid && (trim($signatureValue) != trim(md5($MNT_ID.$invId.$MNT_OPERATION_ID.$MNT_AMOUNT.$MNT_CURRENCY_CODE.$MNT_TEST_MODE.$this->sMerchantPass1)) ))
    {
      $this->params = array('reason'=>'Signature fail');
      $valid = false;
    }

    if($valid && !$this->isOrderExists($invId))
    {
      $this->params = array('reason'=>'Order not exists');
      $valid = false;
    }

    if($valid && $this->_order->{$this->priceField} > $outSum)
    {
      $this->params = array('reason'=>'Order price error');
      $valid = false;
    }

    $code = 200;
    if($valid){
      if($this->hasEventHandler('onSuccess')){
        $this->params = array('order'=>$this->_order);
        $this->onSuccess($event);
      }
    }else{
      $code = 100;
      if($this->hasEventHandler('onFail')){
        $this->onFail($event);
      }
    }

    echo strtr('<?xml version="1.0" encoding="UTF-8"?>
<MNT_RESPONSE>
<MNT_ID>{MNT_ID}</MNT_ID>
<MNT_TRANSACTION_ID>{MNT_TRANSACTION_ID}</MNT_TRANSACTION_ID>
<MNT_RESULT_CODE>{MNT_RESULT_CODE}</MNT_RESULT_CODE>
<MNT_SIGNATURE>{MNT_SIGNATURE}</MNT_SIGNATURE>
</MNT_RESPONSE>',
        array(
        '{MNT_ID}' => $this->sMerchantLogin,
        '{MNT_TRANSACTION_ID}' => $invId,
        '{MNT_RESULT_CODE}' => $code,
        '{MNT_SIGNATURE}' => md5($code.$this->sMerchantLogin.$invId.$this->sMerchantPass1),
    ));
  }

}
