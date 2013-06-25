<?php
/**
 * @var VisualElementWidget $this
 */

$caption = $this->getCaption();
$hint = $this->getHint();
$parameter = $this->getParameter();

$requireClass = ($this->isAttributeRequired() ? ' required' : '');

?>
<div class="control-group b-object-property<?php echo $requireClass; ?>">
  <label class="control-label">
    <?php echo CHtml::encode($caption); ?>
<?php if (!empty($hint)): ?>
    <button data-original-title="<?php echo nl2br(CHtml::encode($hint)); ?>" class="btn btn-mini" rel="tooltip" tabindex="99"><i class="icon-question-sign"></i></button>
<?php endif; ?>
<?php if (!empty($parameter)): ?>
    <a href="<?php echo $parameter; ?>" title="Настроить свойство" class="btn btn-mini" target="_blank" tabindex="99"><i class="icon-wrench"></i></a>
<?php endif; ?>
  </label>
  <div class="controls">
    <?php echo $content; ?>
  </div>
</div>
