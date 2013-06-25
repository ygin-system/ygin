<?php
  if (!isset($parameter)) $parameter = '';
  if (!isset($hint)) $hint = '';
  
  /*<label class="control-label"><?php echo $label.$hint.$parameter; ?></label>*/
?>
<div class="control-group">
  <?php echo $label.$parameter; ?>
  <div class="controls">
    <?php echo $content; ?>
    <?php if ($hint){ ?>
    <p><span class="label"><?php echo $hint ?></span></p>
    <?php } ?>
  </div>
</div>