<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 */

if ($this->getCountData() <= $this->maxData) {
  echo $form->dropDownList($model, $attributeName, $this->data, $this->htmlOption);
  echo $form->error($model, $attributeName);
  return;
}

?>
<div class="ui-widget">
<?php
  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    //'name' => 'param_'.$this->getObjectParameter()->getIdParameter(),
    'model'=>$this->model,
    'attribute'=>$attributeName,
    'value' => $this->getValueString(),
    'source'=>'js:function(request, response) {
      '.CHtml::ajax(array(
      'url'=>Yii::app()->createUrl('backend/engine/autocomplete'),
      'data'=>array(
        'query'=>'js:request.term',
        'idObject'=>$this->getIdObject(),
      ),
      'type'=>'POST',
      'dataType'=>'json',
      'success'=>'js:response',
    )).'
    }',
    'options'=>array(
      'delay'=>300,
      'minLength'=>1,
//      'showAnim'=>'fold',
//      'multiple'=>true,
      /*'select'=>"js:function(event, ui) {
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         terms.push( ui.item.value );
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join(', ');
         return false;
       }",*/
    ),
    'htmlOptions'=>array(
      'size'=>'40'
    ),
  ));
  //echo CHtml::activeHiddenField($this->model, $attributeName);
?>
</div>
