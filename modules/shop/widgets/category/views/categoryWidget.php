<?php
//рекурсивно рисует дерево
function renderCategoriesTree($tree) {
  if (empty($tree['items'])) return;
  ?><ul class="nav nav-list"><?php
  foreach ($tree['items'] as $item):
    $htmlOptions = $item['active'] ? array('class' => 'active') : array();
    echo CHtml::openTag("li", $htmlOptions);
    echo CHtml::link($item['name'] . '<span class="cnt">' .$item['productCount'] . '</span>', $item['url'], array('class' => 'category'));
    renderCategoriesTree($item);
    echo CHtml::closeTag("li");
  endforeach;
  ?></ul><?php
}

$this->registerCssFile("category_list.css");
?>
<div class="b-emarket-category-widget">
<?php renderCategoriesTree($tree); ?>
</div>