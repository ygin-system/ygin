<?php
    
$this->registerCssFile("emarket_list_table.css");

?>
<table class="b-emarket_list_table table table-striped">
<?php foreach ($products AS $product) {
  
$url = $product->getUrl();
$desc = HText::smartCrop($product->description, 470, '...', 100);
$price = $product->getPriceWithMarkup();
$preview = $product->getImagePreview('_list');
$previewUrl = $preview == null ? 'http://dummyimage.com/100x90/cccccc/000000&text=%D0%BD%D0%B5%D1%82+%D1%84%D0%BE%D1%82%D0%BE' : $preview->getUrlPath();
?>
  <tr>
    <td class="preview_picture"><a href="<?php echo $url; ?>"><img src="<?php echo $previewUrl; ?>" alt="<?php echo CHtml::encode($product->name); ?>" title="<?php echo CHtml::encode($product->name); ?>"></a></td>
    <td class="elem">
      <a href="<?php echo $url; ?>" class="name"><h4><?php echo $product->name; ?></h4></a>
      <div class="elem_descr">
        <div class="property"><?php echo $desc; ?></div>
      </div>
    </td>
    <td class="price_m"><span class="catalog-price"><?php echo Product::price2str($price); ?> руб.</span></td>
    <td  class="remain_status"><i class="glyphicon glyphicon-signal <?php echo $product->getRemainStatus()->icon; ?>" title="количество товара: <?php echo $product->getRemainStatus()->name; ?>"></i></td>
    <td class="buttons"><button data-name="<?php echo CHtml::encode($product->name); ?>" data-id="<?php echo $product->id_product; ?>" data-price="<?php echo $price; ?>" class="btn btn-success buy"><i class="glyphicon glyphicon-shopping-cart"></i> В корзину</button></td>
  </tr>
<?php } ?>
</table>
