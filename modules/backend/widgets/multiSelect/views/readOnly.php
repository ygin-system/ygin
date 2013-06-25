<?php

/**
 * @var $this MultiSelectWidget
 */
$data = $this->getSelectedData();
foreach($data AS $id => $caption) {
  echo $caption.'<br>';
}
