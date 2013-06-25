<?php

/**
 * @var $form CActiveForm
 * @var $this SelectObjectParameterWidget
 * @var $model DaActiveRecord
 */

echo $form->dropDownList($model, $attributeName, array(), $this->htmlOption);
echo $form->error($model, $attributeName);

$elementOfObject = VisualElementFactory::getVisualElement($model, $this->parameterOfObject);
$this->parameterOfObjectParameter->widget = null;
$elementOfParameter = VisualElementFactory::getVisualElement($model, $this->parameterOfObjectParameter);
$ajax = CHtml::ajax(array(
  'url'=>Yii::app()->createUrl('backend/engine/getObjectParameters'),
  'data'=>array(
    'id_object' => 'js:$(this).val()',
    'value' => $model->$attributeName,
    'element_object' => $model->getIdObject(),
    'element_parameter' => $this->getObjectParameter()->getIdParameter(),
  ),
  'type'=>'POST',
  'dataType'=>'json',
  'success'=>'js:function(data){if (data.error !== undefined) {alert(data.error); return;} element.parent().html(data.html);}',
));
Yii::app()->clientScript->registerScript('admin.ve.abstract.PermPropVisualElement', '$("select[name=\''.$elementOfObject->getElementName().'\']").change(function(){
var element = $("[name=\''.$elementOfParameter->getElementName().'\']");
'.$ajax.'
}
).change();');

/*
return;

$currentParameter = $model->{$this->parameterOfObjectParameter->getFieldName()};
if ($currentParameter == null) $currentParameter = -1;
?>
<script type="text/javascript">
  function selectProperties() {
    var idObject = $("select[name='<?php echo $elementOfObject->getElementName(); ?>'] option:selected").val();
    var active = <?php echo $currentParameter; ?>;
    da_selectProperties(idObject, 'p<?php echo $parameter->getIdParam(); ?>', active, <?php echo intval($visualElement->notNull()); ?>, '<?php echo Utils::processCode4Ajax($parameter->sql); ?>');
  }
</script>
*/