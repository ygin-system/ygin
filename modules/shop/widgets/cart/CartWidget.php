<?php
class CartWidget extends DaWidget implements IParametersConfig {
  /**
   * Количество отображаемых элементов в корзине
   * @var int
   */
  public $visibleCount = 20;

  public static function getParametersConfig() {
    return array(
      'visibleCount' => array(
        'type' => DataType::INT,
        'default' => 20,
        'label' => 'Количество видимых позиций в корзине',
        'required' => true,
      ),
    );
  }
  
  public function run() {
    // если находимся в контроллере оформления заказа, то не отображаем корзину.
    if ($this->controller->id == 'offer') return;
    
    Yii::app()->user->setState("shop_cart", Yii::app()->request->url);
    $products = ShopModule::getProductsFromCookie();

    $this->render('cart', array(
      'showPrice' => Yii::app()->getModule('shop')->showPrice,
      'products' => $products,
    
    ));
  }
}
