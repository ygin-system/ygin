<h4>Подключение к базе данных</h4>
<?php
$this->widget('zii.widgets.CDetailView', array(
  'data' => $dbSettings,
  'htmlOptions' => array(
    'class' => 'table table-striped',
  ),
  'attributes' => array(
    'host', 'port', 'dbname', 'user',
  ),
));
?>

<h4>Пользователь администратор</h4>
<?php
$this->widget('zii.widgets.CDetailView', array(
  'data' => $userSettings,
  'htmlOptions' => array(
    'class' => 'table table-striped',
  ),
  'attributes' => array(
    'fullName', 'name', 'email',
  ),
));