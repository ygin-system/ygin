<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 * @var $model DaActiveRecord
 */

$idObject = $model->getIdInstance();

$permissions = array(
  DaDbAuthManager::OPERATION_VIEW => 'Видимость',
  DaDbAuthManager::OPERATION_EDIT    => 'Изменение',
  DaDbAuthManager::OPERATION_DELETE  => 'Удаление',
  DaDbAuthManager::OPERATION_CREATE  => 'Создание'
);
$roles = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_ROLE);
echo '<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-condensed">
            <thead><tr>
              <th>Роли пользователя</th>';
foreach ($permissions as $perm) {
  echo '<th>'.$perm.'</th>';
}
echo '</tr></thead>
            <tbody>';
foreach ($roles as $roleName => $role) {
  /**
   * @var CAuthItem $role
   */
  echo '<tr><td>'.$role->getDescription().'</td>';
  foreach ($permissions as $permId => $perm) {
    $chbxId    = $roleName."-".$permId;
    $checked   = null;

    $op = Yii::app()->authManager->getAuthItemObject($permId, $idObject);
    if ($op != null && Yii::app()->authManager->hasItemChild($roleName, $op->getName()) ) {
      $checked = ' checked="checked"';
    }
    echo '<td style="text-align:center" onclick="if (typeof(disableCheckedSwitch) != \'undefined\' && disableCheckedSwitch == 1) {disableCheckedSwitch = 2; } else { $(this).children().attr(\'checked\', $(this).children().attr(\'checked\') == true ? \'\' : \'checked\')}"><input type="checkbox" name="setPermission[]" value="'.$chbxId.'" '.$checked.' onclick="disableCheckedSwitch=1"></td>';
  }
  echo '</tr>';
}
echo '  </tbody>
            </table>';

return;
/*
// Доступность объекта в разрезе Доменов
echo '<div><span class="label label-default">Доступность объекта в доменах:</span></div>';
if (!is_null($idObject)) {
  // Редактируется существующий экземпляр
  $sql = "SELECT a.id_domain AS id, a.name, b.id_object
                FROM da_domain a LEFT JOIN da_domain_object b ON a.id_domain=b.id_domain AND b.id_object=$idObject";
} else {
  // Создаётся новый экземпляр
  $sql = "SELECT id_domain AS id, name, NULL AS id_object
                FROM da_domain";
}
$q = new QuerySQL();
$q->setQuery($sql);
$q->exec();
echo '<div>';
while ($row = $q->next()) {
  $checked = (!is_null($row->id_object)) ? " checked" : "";
  echo '  <label class="checkbox"><input type="checkbox" name="domain['.$row->id.']"'.$checked.'> '.$row->name."</label>";
}
echo '</div>';
$q->free();
*/