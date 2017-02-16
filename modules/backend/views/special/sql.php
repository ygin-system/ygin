<style>
  .sqlTable {font:12px Arial; empty-cells:show}
  .sqlTable td {vertical-align:top; background-color:white}
</style>
<h3>Послать SQL запрос</h3>
<form name="form1" method="post" action="">
  <textarea name="sql" style="width:100%; height:150px; padding:3px; font-size:11px" id="sqlId"><?php echo HU::post('sql') ?></textarea>
  <p><input type="submit" value="Отправить"></p>
</form>
<script language="javascript">
  document.getElementById('sqlId').focus()
</script>

<?php

if (isset($_POST['sql']) && $_POST['sql'] != null) {
  if (preg_match('~^\s*(SELECT|SHOW)~i', $_POST['sql'])) {
    $dataReader = Yii::app()->db->createCommand(HU::post('sql'))->query();
    $table = '<table class="sqlTable" border="1" cellpadding="1" cellspacing="0">';
    $first = true;
    while(($row=$dataReader->read())!==false) {
      if ($first) {
        $first = false;
        $table .= '<thead><tr>';
        foreach ($row as $k => $v) {
          $table .= '<th>'.$k.'</th>';
        }
        $table .= '</tr></thead><tbody>';
      }
      $table .= '<tr>';
      foreach ($row as $k => $v) {
        $table .= '<td>'.$v.'</td>';
      }
      $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    echo $table;
  } else {
    $_POST['sql'] = str_replace("\r", '', HU::post('sql'));
    $delimiter = ';';
    if (preg_match('~\ndelimiter(.*)\n~iUs', $_POST['sql'], $reg)) {
      $delimiter = trim($reg[1]);
      $_POST['sql'] = preg_replace('~\ndelimiter(.*)\n~iUs', "\n", $_POST['sql']);
    }
    $_POST['sql'] = preg_replace('~--.*\n~iUs', "\n", $_POST['sql']);

    $sqlArray = explode("$delimiter\n", $_POST['sql']);
    $errors   = array();
    $affected = 0;
    foreach ($sqlArray as $k => $sqlQuery) {
      if (trim($sqlQuery) == null) {
        unset($sqlArray[$k]);
        continue;
      }
      $affected += Yii::app()->db->createCommand($sqlQuery)->execute();
    }
    $total   = count($sqlArray);
    $faults  = count($errors);
    $success = $total - $faults;

    ?>
  <p>Выполнено <?php echo $success ?> из <?php echo $total ?> запросов</p>
  <p>Затронуто рядов: <?php echo $affected ?></p>
  <?php if (count($errors) > 0) { ?>
    <h3>Ошибки:</h3>
    <ul><li><?php echo implode('</li><li>', $errors) ?></ul>
  <?php }
  }
}
