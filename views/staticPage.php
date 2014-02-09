<?php
/**
 * @var $menu Menu
 * @var $this StaticController
 */
if ($menu->go_to_type == Menu::SHOW_INCLUDED_ITEMS_BEFORE_CONTENT) {
  $this->renderPartial('/treeMenu', array('menu' => $menu));
  echo '<br>';
}
echo $menu->content;
if ($menu->go_to_type == Menu::SHOW_INCLUDED_ITEMS_AFTER_CONTENT) {
  echo '<br>';
  $this->renderPartial('/treeMenu', array('menu' => $menu));
}