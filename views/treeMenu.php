<?php
/**
 * @var $menu Menu
 */
if ($menu->getVisibleChildCount() > 0) {
  echo CHtml::tag('div', array('class' => 'b-menu-content-list'),
      $this->widget('MenuWidget', array(
              'rootItem' => $menu,
              'htmlOptions' => array('class' => 'nav nav-list'),
            //'labelTemplate' => '{label}',
              'activeCssClass' => 'active',
              'itemCssClass' => 'item',
              'encodeLabel' => false,
              'submenuHtmlOptions' => array('class' => 'nav nav-list sub-item-list'),
            //'linkOptions' => array('class' => 'category'),
              'maxChildLevel' => 2,
          ),
          true)
  );
}
