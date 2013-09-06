<div class="b-welcome">
<?php

$badge = CHtml::asset(dirname(__FILE__).'/assets/backend_badge.png');
$this->caption = 'Начало работы';

if ($showWelcome) :
?>
  <div class="introduction">
    <div class="backend-badge" style="background:url(<?php echo $badge; ?>) no-repeat 0 0">
      <?php echo ($version != '' ? 'Версия '.$version : ''); ?>
    </div>
    <h3>Добро пожаловать в ваш сайт на ygin!</h3>
    <p class="about-description">
      Если вам потребуется помощь, посмотрите нашу документацию на странице «<a href="<?php echo Yii::app()->createUrl('instruction'); ?>">Первые шаги с ygin</a>». Если вы хотите сразу начать работать, здесь собраны действия, которые большинство пользователей выполняют ежедневно при работе с сайтом.
    </p>
    <p style="text-align:right;">Уже всё знаете? <button class="btn btn-mini" onclick="$.cookie('daMainWelcome', 1, {expires:10000, path:'/'}); $(this).parents('.introduction').slideUp()">Закройте это сообщение ×</button></p>
  </div>
<?php endif; ?>
<?php
  if (count($devNotices) > 0) {
?>
    <div class="alert alert-info">
      <button type="button" onclick="$.cookie('<?php echo $noticeDevCookieName; ?>', 1, {expires:10000, path:'/'});" class="close" data-dismiss="alert">&times;</button>
      <p>Обратите внимание на последние изменения, которые необходимо внести в проектные файлы:</p>
      <?php foreach($devNotices AS $notice) {
        echo CHtml::tag('p', array(), CHtml::tag('b', array(), nl2br($notice)));
      }?>
    </div>
<?php
  }
?>
  <div class="plugin-list">
<?php
$html = '';
$block = '';
$i = -1;
foreach($mainElements AS $element) {
  $i++;
  $addButton = (isset($element['link-add']) ? '<a class="btn btn-success" href="'.$element['link-add'].'"><i class="icon-plus icon-white"></i> Добавить</a>' : '');
  $block .= '<div class="span4">
        <div class="caption">
          <h4>'.$element['name'].'</h4>
          <p>'.$element['desc'].'</p>
          <p>'.$addButton.'
              <a class="btn" href="'.$element['link-list'].'"><i class="icon-list"></i> Просмотр</a>
            </p>
        </div>
      </div>';
  if (($i+1) % 3 == 0) {
    $html .= CHtml::tag('div', array('class'=>'row-fluid'), $block);
    $block = '';
  }
}
if ($block != '') $html .= CHtml::tag('div', array('class'=>'row-fluid'), $block);

echo $html.'
  </div><!-- .plugin-list -->
</div>';
