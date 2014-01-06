<?php
/**
 * @var $model DaActiveRecord
 */
Yii::app()->controller->registerJsFile('ygin_visual_element.js', 'backend.assets.js');

$countList = count($visualElementArray);
if ($countList < 1) return false;

$addCaption = " (создание)";
if ($model->getIdInstance() != null) $addCaption = " (ИД=".$model->getIdInstance().")";
Yii::app()->controller->caption = Yii::app()->backend->objectView->getName().$addCaption;

$controller = Yii::app()->controller;
$form = $controller->beginWidget('backend.widgets.BackendActiveForm', array(
  'id' => 'aMainForm',
  'enableAjaxValidation' => false,
  'enableClientValidation' => true,
  'htmlOptions' => array(
    'class'   => 'b-instance-edit-form form-horizontal',
    'enctype' => 'multipart/form-data',
    'role'    => 'form',
  ),
  'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => true,
    'beforeValidate'   => 'js: function(form) {
          if (form.find("[name=\"submit_form\"]").val() == 1) return false;
          if (form.hasClass("lock")) return false;
          else {
            form.addClass("lock").find(":submit, .btn").addClass("disabled");
            return true;
          }
        }',
    'afterValidate'    => 'js: function(form, data, hasError) {
          if (hasError){
            $(".errorSummary").modal("show");
            form.removeClass("lock").find(":submit, .btn").removeClass("disabled");
          }
          return true;
        }',
  ),
  'method' => 'post',

));

Yii::app()->clientScript->registerScript('admin.da_gal.init', 'DaGallery.init();', CClientScript::POS_READY);
if ($model->hasErrors()) {
  Yii::app()->clientScript->registerScript('modal-error-summary', '$(".errorSummary").modal("show");', CClientScript::POS_READY);
}
echo $form->errorSummary($model,
  '<div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h3>Ошибка при заполнении формы</h3>
       </div>
       <div class="modal-body">',
  '</div>
       <div class="modal-footer">
         <a href="#" class="btn btn-default" data-dismiss="modal">Закрыть</a>
       </div>',
  array('class'=>'modal errorSummary', 'role'=>'dialog'));
?>

<fieldset class="daGallery">
<?php
  // Рисуем элементы.
  $isAdditionalParamExists = false;
  $isBaseParamExists = false;
  $readOnlyInstance = true;
  $layout = Yii::app()->controller->layout;
  Yii::app()->controller->layout = false;
  foreach($visualElementArray AS $visualElement) {
    if (!$visualElement->isReadOnly()) {
      $readOnlyInstance = false;
    }
    $visualElement->form = $form;
    // Обработка необязательных, дополнительных полей.
    if (!$visualElement->isAdditional()) {
      $isBaseParamExists = true;
      $visualElement->run();
    }
  }
  foreach($visualElementArray AS $visualElement) {
    if ($visualElement->isAdditional()) {
      if ($isAdditionalParamExists == false) {
        $isAdditionalParamExists = true;
        if ($isBaseParamExists) {
          echo '<div class="additional-property-container">
                    <a class="btn btn-default" onclick="$(this).next().slideToggle(); return false;"><i class="glyphicon glyphicon-chevron-down"></i> Дополнительные характеристики</a>
                    <div class="additional-property-list">'."\n";
        }
      }
      $visualElement->run();
    }
  }

  if ($isAdditionalParamExists && $isBaseParamExists) {
    echo "  </div><!-- .additional-property-list -->
          </div><!-- .additional-property-container -->\n";
  }
  Yii::app()->controller->layout = $layout;
?>
  <div class="form-actions">
    <div class="bar">
<?php
  $link = Yii::app()->request->url;
  $backLink = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(), array(ObjectUrlRule::PARAM_OBJECT_INSTANCE, ObjectUrlRule::PARAM_ACTION_VIEW, ObjectUrlRule::PARAM_SYSTEM_MODULE));
  if ($readOnlyInstance) {
    echo CHtml::link('Вернуться', $backLink, array('class' => 'btn btn-default'));
  } else {
        // Обработка кнопок
        Yii::app()->clientScript->registerScript('admin.form.init', '
    $(".b-instance-edit-form .form-actions")
      .daFixedActionBarBind();
    $(".b-instance-edit-form .form-actions")
      .find(".btn-save").on("click", function(){
        if ( !$("#aMainForm").hasClass("lock")){
          var link = "";
          var status = $(this).attr("data-action");
          if (status == 3 || status == 5) {
            link = "'.$link.'";
          } else if (status == 2 || status == 5) {
            link = "'.$link.'";
          }
          $("#aMainForm")
            .attr({action: link, target: "_self"})
            .find("[name=\"submit_form\"]").val(status)
            .end()
            .submit();
        }
        return false;
      }).end()
      .find(".btn-danger").on("click", function(){
        if ( !$("#aMainForm").hasClass("lock")){
          $("#aMainForm").addClass("lock").find(":submit, .btn").addClass("disabled");
        } else {
          return false;
        }
      });

  ', CClientScript::POS_READY);
?>
        <input type="hidden" name="submit_form" value="1" autocomplete="off">
        <div class="btn-group dropup">
          <a class="btn btn-success btn-save" id="saveAndCloseButton" title="Ctrl+Enter" data-action="2"><i class="glyphicon glyphicon-ok icon-white"></i> Сохранить и выйти <i class="glyphicon glyphicon-share-alt icon-white"></i></a>
          <a class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a id="saveAndNewButton" class="btn-save" title="Ctrl+Alt+Enter" data-action="5" href="#"><i class="glyphicon glyphicon-ok"></i> Сохранить и добавить еще <i class="glyphicon glyphicon-plus"></i></a></li>
<!--             <li><a id="saveAsNew" class="btn-save" data-action="6" href="#"><i class="glyphicon glyphicon-ok"></i> Сохранить как новое <i class="glyphicon glyphicon-file"></i></a></li>  -->
          </ul>
        </div>
        &nbsp;&nbsp;
        <a class="btn btn-success btn-save" id="acceptButton" title="Ctrl+Shift+Enter" data-action="3"><i class="glyphicon glyphicon-ok icon-white"></i> Применить</a>&nbsp;&nbsp;
        <?php if ($idFormInstance != null && $copyInstance) { ?><button class="btn btn-default" id="saveAsNewButton" data-action="4"><i class="glyphicon glyphicon-asterisk"></i> Сохранить как новый</button>&nbsp;&nbsp;<?php } ?>
        <a class="btn btn-danger" id="cancelButton" title="Ctrl+Esc" href="<?php echo $backLink ?>"><i class="glyphicon glyphicon-remove icon-white"></i> Отменить</a>
<?php } ?>
      <div>
  </div>
</fieldset>
<?php
$controller->endWidget();
