<?php
$this->widget('zii.widgets.CDetailView', array(
  'data'=>$model,
  'attributes'=>array(
    'name',
    'mail',             // title attribute (in plain text)
    'full_name',        // an attribute of the related object "owner"
  ),
));