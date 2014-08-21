<?php $form = $this->beginWidget('CActiveForm', array());?>
<?php foreach($objectParameters as $i => $objectParameter) : ?>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="checkbox">
                  <label>
                    <?= $form->checkBox($model, "[$i]checkAttributes", array('checked' => true)); ?>
                    <?= $objectParameter->caption . "(" . $objectParameter->field_name . ")"; ?>
                  </label>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              <?= $form->textField($model, "[$i]newObjectParameters",array('value' => $objectParameter->field_name, 'class' => 'form-control')); ?>
              <?= $form->hiddenField($model, "[$i]objectParameters",array('value' => $objectParameter->id_parameter, 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php $this->endWidget(); ?>
