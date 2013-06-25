<?php

class DefaultController extends Controller {
	public function actionIndex() {
	  $model = new ExportObject();
	  
	  if (isset($_POST['ExportObject'])) {
	    $model->attributes = $_POST['ExportObject'];
	    if ($model->validate()) {
	      echo $model->getDump();
	      Yii::app()->end();
	    }
	  }
	  
	  $objects = DaObject::model()->findAll('table_name IS NOT NULL');
		$this->render('index', array(
		  'model' => $model,
		  'objects' => $objects,
		));
	}
}