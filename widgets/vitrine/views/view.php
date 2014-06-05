<div class="tabbable tabs-below">
  <div class="tab-content">
<?php
$html = '';
foreach ($models AS $model) {
  $id    = $model->id_vitrine;
  $class = ($html == '') ? 'tab-pane hero-unit active' : 'tab-pane hero-unit';
  $link  = $model->link;
  $activeClass = ($html == '') ? ' class="active"' : '';
  $html .= '<li'.$activeClass.'><a href="#id-'.$id.'" data-toggle="tab">'.$model->title.'</a></li>';
?>
    <div id="<? echo 'id-'.$id ?>" class="<? echo $class ?>">
      <div><?php echo $model->text; ?></div>
      <p><a href="<?php echo $link; ?>" class="btn btn-info btn-large">Узнать больше »</a></p>
    </div>
<?php
  }
?>
  </div>
  <ul class="nav nav-pills"><?php echo $html; ?></ul>
</div>
