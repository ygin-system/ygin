<?php

/**
 * @var $this PhpScriptWidget
 */

if ($this->error != null) {
  echo $this->error;
  return;
}

// Параметры скрипта
$phpScriptInstance = $this->phpScript;
$phpScript = $phpScriptInstance->phpScript;
$paramsConfig = $phpScript->getParametersConfig();
$idPhpScriptType = $phpScript->getIdPhpScriptType();

$elName = $this->getElementName();
$phpParamsHtmlTmp = "";
foreach($paramsConfig AS $name => $config) {
  $val = $phpScriptInstance->getParameterValue($name, true);
  $name = $elName.'_'.$name;

  $phpParamsHtmlTmp .= '
          <div class="control-group">
            <label class="control-label">'.$config['label'].':</label>
            <div class="controls">'.CHtml::textField($name, $val, array('class' => 'span')).'</div>
          </div>
';
}
if ($phpParamsHtmlTmp != '') {
  echo '<div id="'.$elName.$idPhpScriptType.'" class="field-php-script phpScriptParam-'.$elName.'">'.$phpParamsHtmlTmp."</div>\n";
}
