<?php
  $this->registerCssFile("emarket_toolbar.css");
  Yii::app()->clientScript->registerCoreScript('cookie');
  
  $sign = $orderType{0};
  $order = substr($orderType, 1);
  $newSign = ($sign == '+') ? '-' : '+';
  
  $signCost = '+';
  $signName = '+';
  $signDate = '+';
  if ($order == 'byCost') $signCost = $newSign;
  if ($order == 'byName') $signName = $newSign;
  if ($order == 'byDate') $signDate = $newSign;
  $arrowHtml = ' &uarr;';
  if ($sign == '+') $arrowHtml = ' &darr;';
?>
<?php // Панелька с инструментами сортировки и отображения товаров ?>
<div class="breadcrumb">
<table class="b-emarket-toolbar" cellspacing="0" cellpadding="0">
<tr>
  <td class="lbl">Сортировать по</td>
  <td>
    <div class="btn-group">
      <a onclick="$.cookie('shop_product_list_order', '<?php echo $signCost; ?>byCost', {path:'/'});" href="" class="btn<?php echo ($order == 'byCost' ? ' active' : ''); ?>"><i class="icon-tag"></i> цене<?php echo ($order == 'byCost' ? $arrowHtml : ''); ?></a>
      <a onclick="$.cookie('shop_product_list_order', '<?php echo $signName; ?>byName', {path:'/'});" href="" class="btn<?php echo ($order == 'byName' ? ' active' : ''); ?>"><i class="icon-font"></i> алфавиту<?php echo ($order == 'byName' ? $arrowHtml : ''); ?></a>
      <a onclick="$.cookie('shop_product_list_order', '<?php echo $signDate; ?>byDate', {path:'/'});" href="" class="btn<?php echo ($order == 'byDate' ? ' active' : ''); ?>"><i class="icon-calendar"></i> дате добавления<?php echo ($order == 'byDate' ? $arrowHtml : ''); ?></a>
    </div>
  </td>
  <td class="div">|</td>
  <td class="lbl">Отображение</td>
  <td>
    <div class="btn-group">
      <a onclick="$.cookie('shop_product_list_display', 'byTable', {path:'/'});" href="" class="btn<?php echo ($view == '_product_list_table' ? ' active' : ''); ?>"><i class="icon-th-list"></i> списком</a>
      <a onclick="$.cookie('shop_product_list_display', 'byBlock', {path:'/'});" href="" class="btn<?php echo ($view == '_product_list' ? ' active' : ''); ?>"><i class="icon-th-large"></i> блоками</a>
    </div>
  <td>
</td>
</table>
</div>
<?php // -- Панелька с инструментами сортировки и отображения товаров ?>