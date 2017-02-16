<?php

Yii::import('backend.widgets.multiSelect.MultiSelectWidget');

class VisualElementFactory {

  /**
   * @static
   * @param ObjectParameter $objectParameter
   * @param DaActiveRecord $model
   * @return VisualElementBaseWidget|null
   */
  public static function getVisualElement(DaActiveRecord $model, ObjectParameter $objectParameter) {
    if (mb_strpos($objectParameter->widget, '.') !== false) {
      $className = Yii::import($objectParameter->widget, true);
      $visualElement = Yii::app()->controller->createWidget($className, array(
        'model' => $model,
        'objectParameter' => $objectParameter,
        'attributeName' => $objectParameter->getFieldName(),
      ));
      return $visualElement;
    }

    $type = $objectParameter->getType();
    $visualElement = null;
    switch ($type) {
      case DataType::HIDDEN:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.hiddenField.HiddenFieldWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::VARCHAR:
      case DataType::INT:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.textField.TextFieldWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::PRIMARY_KEY:
        if ($objectParameter->getAdditionalParameter() == 1 && Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV)) {
          $objectParameter->setIsRequired(false);
          if ($model->isNewRecord) {
            //$objectParameter->caption .= " (НЕ заполнять - автозаполнение)";
            if ($objectParameter->hint == null)
              $objectParameter->hint = "Поле следует заполнять вручную в редких случаях, когда идет работа с первичным ключом строкой и нет автоинкремента";
          } else {
            //$objectParameter->caption .= " (НЕ изменять - зависимости)";
            if ($objectParameter->hint == null)
              $objectParameter->hint = "Поле следует менять крайне осторожно, т.к. не контролируются зависимости данных";
          }
          $visualElement = Yii::app()->controller->createWidget('backend.widgets.textField.TextFieldWidget', array(
            'model' => $model,
            'attributeName' => $objectParameter->getFieldName(),
            'objectParameter' => $objectParameter,
          ));
        }
        break;
      case DataType::BOOLEAN:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.checkBox.CheckBoxWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::ABSTRACTIVE:
        $className = Yii::import($objectParameter->widget, true);
        $visualElement = Yii::app()->controller->createWidget($className, array(
          'model' => $model,
          'objectParameter' => $objectParameter,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::TEXTAREA:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.textarea.TextareaWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::EDITOR:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.tinymce.TinymceWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::ID_PARENT:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.dropDownList.DropDownParentWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::OBJECT:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.dropDownList.DropDownObjectWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
          'objectParameter' => $objectParameter,
        ));
        break;
      case DataType::REFERENCE:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.dropDownList.DropDownReferenceWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::TIMESTAMP:
        $visualElement = Yii::app()->controller->createWidget('backend.widgets.dateTime.DateTimeWidget', array(
          'model' => $model,
          'attributeName' => $objectParameter->getFieldName(),
        ));
        break;
      case DataType::FILE:
        $visualElement = Yii::app()->controller->createWidget(
          'backend.widgets.upload.singleFileUpload.SingleFileUploadWidget',
          array(
            'model' => $model,
            'attributeName' => $objectParameter->getFieldName(),
          )
        );
        break;
      case DataType::FILES:
        $visualElement = Yii::app()->controller->createWidget(
          'backend.widgets.upload.listFileUpload.ListFileUploadWidget',
          array(
           'model' => $model,
           'objectParameter' => $objectParameter,
          )
        );
        break;
    }
    return $visualElement;
  }
}
