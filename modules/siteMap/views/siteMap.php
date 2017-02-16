<?php
$this->widget('MenuWidget', array(
  'rootItem' => $tree,
  'maxChildLevel' => -1,
  'htmlOptions' => array('class' => 'b-site-map'),
));