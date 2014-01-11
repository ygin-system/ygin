<?php
$this->registerCssFile('emarket_product.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$this->registerJsFile('shop.js');
Yii::app()->clientScript->registerCoreScript('cookie');
Yii::app()->clientScript->registerScript(
  'cartProduct',
  'initDaCartProducts(".b-emarket-product");',
  CClientScript::POS_READY
);


Yii::app()->clientScript->registerScript('product.textCollapse', 'EMarketProduct.textCollapse();', CClientScript::POS_READY);
Yii::app()->clientScript->registerScriptFile('/themes/business/js/jquery.jqzoom1.0.1.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('makeZoomOfic', "makeZoomOfic();", CClientScript::POS_READY);
Yii::app()->clientScript->registerCssFile('/themes/business/css/jqzoom.css');

  $preview = $product->getImagePreview('_one');

  $price = $product->getPriceWithMarkup();

  $this->caption = $product->name;
?>
<div class="b-emarket-product">
  <div class="details">
<?php if ($preview != null): ?>
    <a href="<?php echo $product->mainPhoto->getUrlPath(); ?>" class="to_zoom">
      <img class="image" src="<?php echo $preview->getUrlPath(); ?>" alt="<?php echo CHtml::encode($product->name); ?> title="IMAGE TITLE"">
    </a>
<?php endif; ?>
    <div class="info-bar">
<?php /* ?>
      <div class="item">
         <p class="title">Рейтинг</p>
         <p>8</p>
      </div>
      <div class="item">
         <p class="title">Разработчик</p>
         <p>ygin</p>
      </div>
      <div class="item">
         <p class="title">Дата добавления / изменения</p>
         <p>16.09.2011</p>
      </div>
<? */ ?>
      <div class="item">
         <p class="title">Поделиться:</p>
         <p><?php $this->widget('ygin.widgets.likeAndShare.LikeAndShareWidget', array("title" => $product->name)); ?></p>
      </div>
    </div>
  </div>
  <div class="description">
    <div class="price-bar">
      <div class="price">
        <span>Платный</span>
        <br><?php echo Product::price2str($price); ?> руб.
      </div>
      <div class="buttons">
        <button class="btn btn-success buy" data-price="<?php echo $price; ?>" data-id="<?php echo $product->id_product; ?>" data-name="<?php echo CHtml::encode($product->name); ?>"><i class="glyphicon glyphicon-shopping-cart icon-white"></i> Купить</button>
      </div>
      <div style="clear:both;"></div>
    </div>
    <div class="text">
<?php echo $product->description; ?>
    </div>
    <div class="slider">
      <button class="btn btn-mini" onfocus="this.blur();">Подробнее</button>
    </div>
<?php
  $tabs = array(
    array('caption' => 'Скриншоты', 'content' => trim($this->widget('PhotogalleryWidget', array("model" => $product), true))),
    array('caption' => 'Характеристики', 'header' => 'Техподдержка', 'content' => $product->properties),
    array('caption' => 'Монтаж', 'header' => 'Установка', 'content' => $product->additional_desc),
    array('caption' => 'Видео', 'content' => $product->video),
  );
  $tabs = array_filter($tabs, create_function('$tab', 'return !empty($tab["content"]);'));
?>

  <?php if (!empty($tabs)): ?>
  <div class="tabbable">
    <ul class="nav nav-tabs">
    <?php
    $index = 0;
    foreach($tabs as $tab) {
      $htmlOptions = array();
      if ($index == 0) {
        $htmlOptions = array('class' => 'active');
      }
      echo CHtml::tag('li', $htmlOptions, CHtml::link($tab['caption'], '#tab'.$index, array('data-toggle' => 'tab')), true);
      $index++;
    }
    ?>
    </ul>
    <div class="tab-content">
    <?php
    $index = 0;
    foreach($tabs as $tab) {
      $htmlOptions = array('class' => 'tab-pane', 'id' => 'tab'.$index);
      if ($index == 0) {
        $htmlOptions['class'] .= ' active';
      }
      echo CHtml::openTag('div', $htmlOptions);
      if (!empty($tab['header'])) {
        echo CHtml::tag('h3', array(), $tab['header']);
      }
      echo $tab['content'];
      echo CHtml::closeTag('div');
      $index++;
    }
    ?>
    </div>
  </div>
  <?php endif; ?>

  </div>
</div>