<?php
Yii::import('gii.generators.model.ModelGenerator');
class YginModelGenerator extends ModelGenerator {
  public $codeModel='ygin.gii.yginModel.YginModelCode';
  
  public function actionGetDateAttributes($db, $tableName) {
    if(Yii::app()->getRequest()->getIsAjaxRequest() && $tableName)
    {
      $object = DaObject::model()->with('parameters')->findByAttributes(array('table_name' => $tableName));
      $result = array();
      foreach ($object->parameters as $parameter) {
        if ($parameter->id_parameter_type == DataType::TIMESTAMP) {
          $result[] = $parameter->field_name;
        }
      }
      echo json_encode($result);
    }
    else {
      throw new CHttpException(404,'The requested page does not exist.');
    }
  }
}