<?php
  if (!isset($parameter)) $parameter = '';
  if (!isset($hint)) $hint = '';
  
  /*<label class="control-label"><?php echo $label.$hint.$parameter; ?></label>*/
?>
<div class="form-group">
  <?php echo $label.$parameter; ?>
  <div class="controls col-lg-8">
    <?php echo $content; ?>
    <?php if ($hint){ ?>
    <p><span class="label label-default"><?php echo $hint ?></span></p>
    <?php } ?>
  </div>
</div>