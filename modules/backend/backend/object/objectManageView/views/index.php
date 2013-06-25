<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 * @var $model DaObject
 */

$idObject = $model->getIdInstance();

?>
<div>
    <input type="checkbox" name="create_rep" onchange="var elem = $('#view-description'); (this.checked) ? elem.slideDown() : elem.slideUp();" value="1" >
  </div>
  <div id="view-description" style="display:none">
    <div class="control-group">
      <label class="control-label">Название представления (если пусто, то колонки будут добавлены к текущему представлению)</label>
      <div class="controls"><input name="create_rep_name" value="<?php echo $model->getName(); ?>"></div>
    </div>
    <div class="control-group">
      <label class="control-label">Колонки представления</label>
      <div class="controls">
    <?php
      if (!is_null($idObject) && $model->table_name != "") {
        $params = $model->parameters;
        foreach($params AS $p) {
          /**
           * @var $p ObjectParameter
           */
          if (in_array($p->getType(), array(DataType::ABSTRACTIVE, DataType::PRIMARY_KEY, DataType::ID_PARENT, DataType::SEQUENCE, DataType::FILES))) continue;
          $n = 'column['.$p->getIdParameter().']';
          echo '<label class="checkbox">'.CHtml::checkBox($n, false, array('value'=>$p->getIdParameter())).CHtml::encode($p->getCaption()).'</label>';
          //<input type="checkbox" name="'.$n.'" value="'.$p->getIdParameter().'">
        }
      }
    ?>
      </div>
    </div>
  </div>
