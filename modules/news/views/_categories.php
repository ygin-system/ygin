<?php 

if ($activeCategory !== null) {
  $this->caption = $activeCategory->name;
}

?>
<div class="b-news-category btn-group">
  <?php echo CHtml::button(
    'Все категории',
    array(
      'class' => 'btn'.($activeCategory === null ? ' active' : ''),
      'onclick' => "window.location='".News::model()->getUrl()."'",
    )
  ); ?>
  <?php foreach ($categories as $curCategory): ?>
  <?php echo CHtml::button(
    $curCategory->name, 
    array(
      'class' => 'btn'.($activeCategory !== null && $activeCategory->equals($curCategory) ? ' active' : ''),
      'onclick' => "window.location='".$curCategory->getUrl()."'",
    )
  );?>
  <?php endforeach; ?>
</div>