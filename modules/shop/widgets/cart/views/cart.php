<?php
$this->registerCssFile("cart.css");
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('cookie');

$noPriceClass = '';
if (!$showPrice) {
  $noPriceClass = 'noPrice';
}

$currencyImage = CHtml::asset(Yii::app()->getModule('shop')->getBasePath().'/assets/rub18.png');

$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile(CHtml::asset(Yii::app()->getModule('shop')->getBasePath().'/assets/shop.js'));
$cs->registerScript(
  'cartWidget', '
  DaCart.init(); //инициализируем хранилище (в куках) выбранных товаров
  //виджет корзины
  $(".b-cart").Cart('.
  CJavaScript::encode(array(
    'offerLink' => Yii::app()->createUrl(ShopModule::ROUTE_OFFER),
    'noPrice' => $noPriceClass ? '.'.$noPriceClass : '',
    'onUpdateProduct' => 'js:function(event, data){
      //data - {item: $item, product: product},
      //где item - элемент с товаром (обычно li), который был добавлен в корзину;
      //product - экземпляр класса CartWidgetProduct, который был добавлен в корзину
      var product = new Product(data.product.id, data.product.count);
      DaCart.updateProduct(product);
    }',
    'onRemoveProduct' => 'js:function(event, data) {
      //data - {item: $item}, где item - элемент с товаром (обычно li), который был удален из корзины
      DaCart.removeProduct(data.item.attr("data-id"));
    }',
    'itemTemplate' => "<li data-price-result=\"\" data-kolvo=\"\" data-price=\"\" data-id=\"\" class=\"item\">
                        <a title=\"Удалить\" href=\"#\" class=\"close\">×</a>
                        <div class=\"name\"></div>
                        <div class=\"kolvo\">
                          <input maxlength=\"4\" value=\"0\"> шт.
                        </div>
                        <div class=\"price ".$noPriceClass."\">
                          <span class=\"val\">0</span> <img title=\"руб.\" alt=\"руб.\" src=\"".$currencyImage."\">
                        </div>
                      </li>",
    'visibleCount' => $this->visibleCount
  )).');',
  CClientScript::POS_READY
);

?>
    <div class="b-cart well">
      <h3 class="title">Корзина</h3>
      <div class="hdr">
<?php //        <h3 class="caption">Ваш заказ</h3> ?>
        <div class="alert alert-info"><i class="icon-info-sign icon-white"></i> Ваша корзина пуста</div>
      </div>
      <ul class="tovarList">
<?php foreach ($products AS $product): ?>
        <li data-kolvo="<?php echo $product->countInCart; ?>" data-id="<?php echo $product->id_product ?>" data-price="<?php echo $product->getPriceWithMarkup(); ?>" class="item">
          <a class="close" href="#" title="Удалить">&times;</a>
          <div class="name"><?php echo $product->name; ?></div>
          <div class="kolvo">
            <input value="<?php echo $product->countInCart; ?>" maxlength="4"> шт.
          </div>
          <div class="price <?php echo $noPriceClass; ?>">
            <span class="val">0</span> <img src="<?php echo $currencyImage; ?>" alt="руб." title="руб.">
          </div>
        </li>
<?php endforeach; ?>
      </ul>
      <div class="itogo alert <?php echo $noPriceClass; ?>"><table cellpadding="0" cellspacing="0" style="width:100%"><tr><th style="width:60%">Итог</th><td style="text-align:right"> <span>0</span> </td><td>&nbsp;руб.</td></tr></table></div>
      <div class="totalItems alert alert-info">Всего товаров <span></span></div>
      <div class="btns <?php echo $noPriceClass; ?>">
        <a class="btn btn-large btn-success offer" href="<?php echo Yii::app()->urlManager->createUrl(ShopModule::ROUTE_OFFER); ?>"><i class="icon-shopping-cart icon-white"></i> Оформить заказ</a>
        <button class="btn clear btn-link"><i class="icon-trash"></i> Очистить</button>
      </div>
       
    </div>