<?php

$data = array();
foreach($this->roles AS $role) {
  $data[$role->name] = $role->description;
}
$selected = array();
foreach($this->currentRoles AS $role) {
  $selected[] = $role;
}

echo CHtml::checkBoxList('roles', $selected, $data);