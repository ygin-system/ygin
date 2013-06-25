<?php
$this->registerCssFile("brand_list.css");
?>
<div class ="b-emarket-brand-widget">
  <ul class="nav nav-list">
  <?php foreach ($brands AS $brand): ?>
    <li>
      <?= CHtml::link($brand->name . '<span class="cnt">' . $brand->productCount . '</span>', $brand->getUrl(), array('class' => 'category')); ?>
    </li>
  <?php endforeach; ?>
  </ul>
</div>