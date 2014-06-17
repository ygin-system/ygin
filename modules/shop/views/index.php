<?php
  if (count($allCategory) == 0) return;
  $this->registerCssFile('emarket_category_list.css');
  Yii::app()->clientScript->registerCoreScript('jquery.ui');
  $this->registerJsFile('shop.js');
  Yii::app()->clientScript->registerScript('eMarketCategoryList.init', 'EMarketProductCategoryList.init();', CClientScript::POS_READY);
?>
<div class="b-emarket-category-list row">
<?php foreach ($allCategory AS $category): ?>
  <div class="item col-lg-3">
    <?php if ($this->module->imageCategoryOnMain && $category->photo != null): ?>
    <?php $preview=$category->getImagePreview('_sm'); if ($preview != null): ?>
    <a class="photo" href="<?php echo $category->getUrl(); ?>"><?php echo CHtml::image($preview->getUrlPath(), $category->name); ?></a>
    <?php endif; ?>
    <?php endif; ?>
    <h3><a href="<?php echo $category->getUrl(); ?>"><?php echo $category->name; ?></a></h3>
    <?php if ($this->module->subCategoryOnMain && $category->getChildCount() > 0): ?>
    <ul class="sub-item-list">
      <?php $childs = $category->getChild(); foreach ($childs AS $child): ?>
      <li class="sub-item"><?php echo CHtml::link($child->name, $child->getUrl()); ?><span class="cnt"><?php echo $child->productCount; ?></span></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>