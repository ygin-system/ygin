<?php
  if (count($plugins) == 0) return;
?>
<table class="table table-bordered b-instance-list b-site-module-list">
<?php
  foreach($plugins AS $plugin) :
    $image = $plugin->getImage();
    if ($image == null) {
      $image = 'http://dummyimage.com/64x64/bdbdbd/ffffff&text=ygin';
    } else {
      $image = CHtml::asset($image);
    }
?>
<tr>
  <td class="icon">
    <img src="<?php echo $image; ?>">
  </td>
  <td>
    <h3><?php echo $plugin->getName().($plugin->status == Plugin::STATUS_NEW ? ' (новый)' : ''); ?></h3>
    <div class="desc"><?php echo $plugin->getShortDescription(); ?></div>
<?php if ($plugin->getLink() != null): ?>
    <div class="link"><a href="<?php echo $plugin->getLink(); ?>">Подробное описание</a> »</div>
<?php endif; ?>
  </td>
  <td class="misc">
    <div id="plugin_buttons_<?php echo $plugin->id_plugin; ?>">
<?php $this->renderPartial('/_buttons', array('plugin' => $plugin)); ?>
    </div>
    <div class="version">версия: <?php echo $plugin->getVersion().' ('.$plugin->getVersionDate().')'; ?></div>
  </td>
</tr>
<?php endforeach; ?>
</table>