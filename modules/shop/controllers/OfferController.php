<?php
class OfferController extends Controller {
  
  protected $urlAlias = "catalog";

  public function filters() {
    return array(
      //'postOnly +processPayment',
    );
  }

  public function init() {
    parent::init();
    if (!Yii::app()->daShop->useOnlinePayment) return;
    $billing = Yii::app()->billing;
    /**
     * @var $billing BillingComponent
     */
    $billing->sMerchantLogin = Yii::app()->params[$billing->paramNameLogin];
    $billing->sMerchantPass1 = Yii::app()->params[$billing->paramNamePass1];
    $billing->sMerchantPass2 = Yii::app()->params[$billing->paramNamePass2];
  }
  
  protected function getProducts() {
    $modelClass = get_class(BaseActiveRecord::model('Product'));
    $productItems = Yii::app()->request->getPost($modelClass, array());
    $ids = HArray::column($productItems, 'id_product');
    if (empty($ids)) {
      return array();
    }
    $result = array();
    $products = BaseActiveRecord::model('Product')->with('category')->findAllByPk($ids);
    foreach ($productItems as $item) {
      foreach ($products as $product) {
        if ($product->getPrimaryKey() == (int)HArray::val($item, 'id_product')) {
          //чтобы появилась возможность заполнять кастомные поля (поля, определенные прикладным программистом)
          //делаем массовое присваивание
          unset($item['id_product']);
          $product->scenario = 'offer';
          $product->attributes = $item;
          if (floatval($product->countInCart) > 0) {
            $result[] = $product;
          }
          break;
        }
      }
    }
    return $result;
  }
  
  public function actionIndex() {
    $offer = BaseActiveRecord::newModel('Offer');
    $offerModelClass = get_class($offer);
    $products = array();
    $transaction = null;
    // собираем данные, пришедшие от клиента
    if (isset($_POST[$offerModelClass])) {
      $offer->attributes = $_POST[$offerModelClass];
      //если данные пришли не аяксом, то стартуем транзакцию
      if (!isset($_POST['ajax'])) {
        Yii::app()->db->setAutoCommit(false);
        $transaction = Yii::app()->db->beginTransaction();
      }
      $products = $this->getProducts();
    }
   
    // валидация формы ajax
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'offerForm') {
      $validateResult = CActiveForm::validate($offer, null, false);
      //Если валидация формы заказа прошла успешно, то валидируем выбранные товары
      if ($validateResult == '[]') {
        echo CActiveForm::validateTabular($products, null, false);
      } else {
        echo $validateResult;
      }
      Yii::app()->end();
    }
    
    // сохраняем
    if (isset($_POST[$offerModelClass])) {
      $valid = true;
      foreach ($products AS $product) {
        $valid = $product->validate() && $valid;
        if (!$valid) break;
      }
      if (count($products) == 0) {
        $valid = false;
        $offer->addError('offer_text', 'Для оформления заявки необходимо выбрать хотя бы один товар.');
      }
      if ($valid && $offer->validate()) {
        // Формируем текст заявки:
        foreach ($products AS $product) {
          $offerProduct = BaseActiveRecord::newModel('OfferProduct'); //Модель-связь многие-ко-многим м/у заказом и товарами
          $offerProduct->id_product = $product->id_product;
          $offerProduct->amount = $product->countInCart;
          $offer->amount += $product->countInCart * $product->retail_price;
          $offer->addRelatedRecord('offerProducts', $offerProduct, true);
        }
        $offer->offer_text = $this->renderPartial('/offerText', array('products' => $products), true);
        $offer->onAfterSave = array($this, 'sendMessage');
        $offer->save();
        if ($transaction != null) {
          $transaction->commit();
        }
        if (Yii::app()->daShop->useOnlinePayment) {
          $this->pay($offer);
        }
        Yii::app()->user->setFlash('offer-success', 'Спасибо, Ваш заказ успешно отправлен.');
        ShopModule::clearProductsFromCookie();
        $this->redirect(Yii::app()->createUrl(ShopModule::ROUTE_MAIN));
      } else {
        // вообще сюда попадать в штатных ситуациях не должны
        // только если кул хацкер резвится
        Yii::app()->user->setFlash('offer-message', CHtml::errorSummary($offer, '<p>Не удалось отправить заявку</p>'));
      }
    } else {
      $products = ShopModule::getProductsFromCookie();
    }
    $this->render('/offer', array(
      'products' => $products,
      'offer' => $offer,
      'showPrice' => Yii::app()->getModule('shop')->showPrice,
    ));
  }
  
  public function sendMessage(CEvent $event) {
    Yii::app()->notifier->addNewEvent(
      $this->module->idEventTypeNewOffer,
      $this->renderPartial('/offerMessage', array('model' => $event->sender), true)
    );
  }
  /**
   * Отмена завки
   */
  /*
  public function actionCancel($id) {
    Yii::app()->db->setAutocommit(false);
    $transaction = Yii::app()->db->beginTransaction();
    $offer = Offer::model()->findByPk($id);
    $offer->status = Offer::STATUS_CANCELED;
    $offer->save();
    $transaction->commit();
  }
  */

  protected function pay($offer) {
    $invoice = BaseActiveRecord::newModel('Invoice');
    $invoice->amount = $offer->amount;
    $invoice->id_offer = $offer->primaryKey;
    $invoice->create_date = time();
    if ($invoice->save()) {
      $billing = Yii::app()->billing;
      $sInvDesc = "Оплата заказа [ID = ".$offer->primaryKey."]";
      $billing->pay($invoice->amount, $invoice->primaryKey, $sInvDesc);
    } else {
      throw new ErrorException('Не удалось сохранить счет errors: '.print_r($invoice->getErrors(), true));
    }
  }

  public function actionProcessPayment() {
    if (!Yii::app()->daShop->useOnlinePayment) return;
    $billing = Yii::app()->billing;
    $billing->onSuccess = array($this, 'onPaymentSuccess');
    $billing->onFail = array($this, 'onPaymentFail');
    $billing->result();
  }

  /** Обработчик успешной оплаты
   * @param CEvent $event
   */
  public function onPaymentSuccess(CEvent $event) {
    $transaction =  Yii::app()->db->beginTransaction();

    $invoiceId = (int)Yii::app()->request->getParam(Yii::app()->billing->invoiceIdParamName);
    $invoice = BaseActiveRecord::model('Invoice')->findByPk($invoiceId);
    $offer = $invoice->offer;
    $invoice->pay_date = time();
    //Устанавливаем заказу id счета, по которому он оплачен
    $offer->id_invoice = $invoiceId;
    $invoice->save();
    $offer->create_date = time();
    $offer->status = Offer::STATUS_PAYD;
    if (!$offer->save()) {
      Yii::log('Ошибки при сохранении модели Offer: '.print_r($offer->getErrors(), true), CLogger::LEVEL_ERROR, 'billing');
    } else {
      //Yii::app()->getModule('messenger')->addMessage('Поступил новый заказ № '.$offer->id_offer.'.', Message::TYPE_ERROR, Offer::model()->getIdObject());
    }
    $transaction->commit();
  }

  /**
   * Обработчик НЕ успешной оплаты
   * @param CEvent $event
   */
  public function onPaymentFail(CEvent $event) {
    $invoiceId = (int)Yii::app()->request->getParam(Yii::app()->billing->invoiceIdParamName);
    $errorsTxt = "Оплата счета ID = $invoiceId, не удалась.\n";
    $errorsTxt .= "Переданные параметры запроса: \n".print_r($_REQUEST, true)."\n";
    $errorsTxt .= "Ошибка при валидации в компоненте RC: \n".$event->sender->params['reason']."\n";

    Yii::log($errorsTxt, CLogger::LEVEL_ERROR, 'billing');
  }

  private function loadOwnOfferByIdInvoice($id, $criteria = null) {
    $offer = null;
    if ($invoice = BaseActiveRecord::model('Invoice')->findByPk($id, $criteria)) {
      $offer = $invoice->offer;
    }
    return $offer;
  }

  public function actionSuccess() {
    if (!Yii::app()->daShop->useOnlinePayment) return;
    $invoiceId = (int)Yii::app()->request->getParam( Yii::app()->billing->invoiceIdParamName );
    $offer = $this->loadOwnOfferByIdInvoice($invoiceId, array('scopes' => 'done'));
    $this->render('/success', array('offer' => $offer));
  }

  public function actionFail() {
    if (!Yii::app()->daShop->useOnlinePayment) return;
    $invoiceId = (int)Yii::app()->request->getParam( Yii::app()->billing->invoiceIdParamName );
    $offer = $this->loadOwnOfferByIdInvoice($invoiceId);
    $this->render('/fail', array('offer' => $offer));
  }

}
