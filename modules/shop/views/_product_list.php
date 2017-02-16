<?php

$this->registerCssFile("emarket_list.css");

// TODO: Вынести этот параметр в настройки
$productWidth = '4'; // можно ещё span3, span4

// + Интернет-магазин - Список
?>
<div class="row b-emarket_list b-emarket_list__picaside b-emarket_list__picaside__<? echo $productWidth; ?>">
<?php foreach ($products AS $product) {
  
$url = $product->getUrl();
$desc = HText::smartCrop($product->description, 270, '...', 100);
$price = $product->getPriceWithMarkup();

$preview = $product->getImagePreview('_list');

?>
<div class="element_item col-lg-<? echo $productWidth; ?>">
  <div class="line name">
    <a class="name" href="<?php echo $url; ?>"><h4><?php echo $product->name; ?></h4></a>
  </div>
<?php if ($preview != null): ?>
  <div class="preview_picture">
    <a href="<?php echo $url; ?>"><img title="<?php echo CHtml::encode($product->name); ?>" alt="<?php echo CHtml::encode($product->name); ?>" src="<?php echo $preview->getUrlPath(); ?>"></a>
  </div>
<?php endif; ?>
  <div class="elem">
    <div class="elem_descr">
      <div class="property"><?php echo $desc; ?></div>
    </div>
    <div class="remain_status"><span class="glyphicon glyphicon-signal <?php echo $product->getRemainStatus()->icon; ?>" title="количество товара: <?php echo $product->getRemainStatus()->name; ?>"></span></div>
    <div class="price_m" style="height: 26px;"><span class="catalog-price"><?php echo Product::price2str($price); ?> руб.</span></div>
    <div class="line buttons">
      <button class="btn btn-success buy" data-price="<?php echo $price; ?>" data-id="<?php echo $product->id_product; ?>" data-name="<?php echo CHtml::encode($product->name); ?>"><span class="glyphicon glyphicon-shopping-cart"></span></button>
    </div>
  </div>
</div>
<?php } ?>

</div>