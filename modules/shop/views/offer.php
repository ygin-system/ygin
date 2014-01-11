<?php if (count($products) == 0) { ?>

В корзине нет товаров, оформить заказ пока нет возможности.

<?php
  return;
}

$this->registerCssFile('offer.css');
$this->registerJsFile("shop.js");

Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCoreScript('cookie');
Yii::app()->clientScript->registerScript(
  'offerForm', '
  DaCart.init();
  $("#offerForm .tovar-list").Cart('.
  CJavaScript::encode(array(
    'productList' => 'tbody',
    'onUpdateProduct' => 'js:function(event, data){
      var product = new Product(data.product.id, data.product.count);
      DaCart.updateProduct(product);
    }',
  )).');',
  CClientScript::POS_READY
);

$form = $this->beginWidget('CActiveForm', array(
  'id' => 'offerForm',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'focus' => array($offer, 'fio'),
  'htmlOptions' => array(
    'class' => 'well form-horizontal b-offer-form',
  ),
  'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => false,
  ),
  'errorMessageCssClass' => 'label label-important',
  'action' => '',
));

$count = count($products);
$totalSumma = 0;
$backLink = Yii::app()->user->getState("shop_cart");
if ($backLink == "") $backLink = Yii::app()->createUrl(ShopModule::ROUTE_MAIN);

$currencyImage = CHtml::asset(Yii::app()->getModule('shop')->getBasePath().'/assets/rub.png');
$currencyImage18 = CHtml::asset(Yii::app()->getModule('shop')->getBasePath().'/assets/rub18.png');

?>

  <?php echo Yii::app()->user->getFlash("offer-message"); ?>
  <fieldset>
    <legend>Контактная информация для получения заказа</legend>
    <div class="control-group">
      <label class="control-label" for="fio">Представьтесь *</label>
      <div class="controls">
        <?php echo $form->textField($offer, 'fio', array('class' => 'input-xlarge')); ?>
        <?php echo $form->error($offer, 'fio'); ?>
        <?php
        // тут и далее - yii генерит свои ид для элементов. Поэтому если нужны в верстке, надо поменять
        // <input id="fio" type="text" name="fio" value="" class="input-xlarge">
        ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="phone">Контактный телефон</label>
      <div class="controls">
        <?php echo $form->textField($offer, 'phone', array('class' => 'input-xlarge', 'placeholder' => '+7 999-999-9999')); ?>
        <?php echo $form->error($offer, 'phone'); ?>
      </div>
    </div>
    <!-- +not-encode-mail -->
    <div class="control-group">
      <label for="email" class="control-label">Электропочта *</label>
      <div class="controls">
        <?php echo $form->textField($offer, 'mail', array('class' => 'input-xlarge', 'placeholder' => 'email@email.ru')); ?>
        <?php echo $form->error($offer, 'mail'); ?>
      </div>
    </div>
    <!-- -not-encode-mail -->
    <div class="control-group">
      <label class="control-label" for="add_info">Пожелания и прочая контактная информация</label>
      <div class="controls">
        <?php echo $form->textArea($offer, 'comment', array('class' => 'span6', 'style' => 'height:100px; width: 385px;')); ?>
        <?php echo $form->error($offer, 'comment'); ?>
      </div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Ваш заказ</legend>
    <table cellspacing="0" cellpadding="0" class="table table-bordered tovar-list">
        <thead>
            <tr>
                <th>Код</th>
                <th>&nbsp;</th>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Стоимость</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i = 0; $i < $count; $i++): $product = $products[$i]; ?>
            <?php   $sum = $product->getPriceWithMarkup()*$product->countInCart; $totalSumma += $sum; ?>
            <tr id="product<?php echo $product->id_product; ?>" class="item" data-id="<?php echo $product->id_product; ?>" data-price="<?php echo $product->getPriceWithMarkup(); ?>" data-kolvo="<?php echo $product->countInCart; ?>">
                <td>
                  <?php echo $form->hiddenField($product, '['.$i.']id_product'); ?>
                  <?php echo $product->code; ?>
                </td>
                <td class="img">
                  <?php if ($product->getImagePreview('_offer') != null): ?>
                  <?php echo CHtml::link(CHtml::image($product->getImagePreview('_offer')->getUrlPath(), $product->name), $product->getUrl(), array('title' => $product->name, 'rel' => 'product')); ?>
                  <?php endif; ?>
                </td>
                <td class="name"><?php echo $product->name; ?></td>
                <td class="cena"><?php echo Product::price2str($product->getPriceWithMarkup()); ?></td>
                <td class="kolvo">
                  <?php echo $form->textField($product, '['.$i.']countInCart', array('maxlength' => '4', 'class' => 'input-mini')); ?>
                  <?php echo $form->error($product, '['.$i.']countInCart'); ?>
                </td>

                <td class="price">
                    <div class="val" title="<?php echo $sum; ?>">&nbsp;<?php echo $sum; ?></div>
                    <img title="руб." alt="руб." src="<?php echo $currencyImage; ?>">
                </td>
            </tr>
            <?php endfor; ?>
            <tr class="itogo">
                <th colspan="3">
                  <button type="submit" class="btn btn-large btn-success"><i class="glyphicon glyphicon-ok icon-white"></i> Отправить заявку на покупку</button>
                  <a href="<?php echo $backLink; ?>" class="btn btn-mini btn-danger"><i class="glyphicon glyphicon-share-alt icon-white"></i> Вернуться в каталог</a>
                </th>
                <td colspan="2">Итого:</td>
                <td class="sum">
                    <span title="<?php echo $totalSumma; ?>"><?php echo $totalSumma; ?></span>
                    <img title="руб." alt="руб." src="<?php echo $currencyImage18; ?>">
                </td>
            </tr>
        </tbody>
    </table>
  </fieldset>
<?php $this->endWidget(); ?>