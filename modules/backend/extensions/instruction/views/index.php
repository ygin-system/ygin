<?php

  $this->caption = 'Инструкция по работе с системой администрирования';
  $items = array();
  foreach($list AS $item) {
    $items[] = array(
      'active' => false,
      'label' => $item->name,
      'url' => $item->getUrl(),
    );
  }

  echo CHtml::openTag('div', array('class' => 'instruction'));
  $this->widget('zii.widgets.CMenu', array('items' => $items));
  echo CHtml::closeTag('div');
  