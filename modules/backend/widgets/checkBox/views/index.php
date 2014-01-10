<?php

/**
 * @var $form CActiveForm
 */

echo '<div class="checkbox">';
if ($this->label === null) {
  echo $form->checkBox($model, $attributeName);
} else {
  echo '
  <label>
    '.$form->checkBox($model, $attributeName).' '.$this->label.'
  </label>
';
}
echo '</div>';
