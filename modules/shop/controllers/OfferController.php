<?php
class OfferController extends Controller {
  
  protected $urlAlias = "catalog";
  
  protected  function getProducts() {
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
          $offer->addRelatedRecord('offerProducts', $offerProduct, true);
        }
        $offer->offer_text = $this->renderPartial('/offerText', array('products' => $products), true);
        $offer->onAfterSave = array($this, 'sendMessage');
        $offer->save();
        if ($transaction != null) {
          $transaction->commit();
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

}
