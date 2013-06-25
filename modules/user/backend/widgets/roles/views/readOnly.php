<?php

foreach($this->roles AS $role) {
  if (in_array($role->name, $this->currentRoles)) {
    echo $role->description.'<br>';
  }
}
