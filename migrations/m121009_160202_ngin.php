<?php

class m121009_160202_ngin extends CDbMigration {
  public function up() {

    $data = Yii::app()->db->createCommand('SELECT a.id_php_script , a.param_value , b.parameter_name
FROM da_php_script_parameter a
JOIN da_php_script_type_parameter b ON a.id_php_script_parameter = b.id_php_script_parameter')->queryAll();

    $idPhpScript = null;
    $params = array();
    foreach ($data as $row) {
      if ($idPhpScript == null) {
        $idPhpScript = $row['id_php_script'];
      }
      if ($idPhpScript == $row['id_php_script']) {
        $params[$row['parameter_name']] = $row['param_value'];
      } else {
        $this->execute('UPDATE da_php_script SET params_value='.Yii::app()->db->quoteValue(serialize($params)).' WHERE id_php_script='.$idPhpScript);
        $idPhpScript = $row['id_php_script'];
        $params = array();
        $params[$row['parameter_name']] = $row['param_value'];
      }
    }
    if ($idPhpScript != null) {
      $this->execute('UPDATE da_php_script SET params_value='.Yii::app()->db->quoteValue(serialize($params)).' WHERE id_php_script='.$idPhpScript);
    }

  }
  
  public function down() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  /*
  public function safeUp() {
  }
  public function safeDown() {
  }
  */
}
