<?php

class ObjectManageViewWidget extends VisualElementWidget {

  public function init() {
    if ($this->model->object_type != DaObject::OBJECT_TYPE_TABLE || $this->model->isNewRecord) $this->render = false;
  }

  public function onPostForm(PostFormEvent $event) {
    $this->model->attachEventHandler('onAfterSave', array($this, 'processModel'));
  }

  public function processModel(CEvent $event) {
    /**
     * @var $model DaObject
     */
    $model = $this->model;
    $idObject = $model->getIdInstance();
    $idView = null;
    if (HU::post("create_rep") == 1) {
      //Создать представление с введённым именем
      $name = trim(HU::post("create_rep_name"));
      $view = null;
      if ($name != "") {
        $view = new DaObjectView();
        $id = $idObject.'-view-main';
        while (DaObjectView::model()->exists('id_object_view=:id', array(':id'=>$id))) {
          $id = $idObject.'-view-view'.rand(1, 100);
        }
        $view->id_object_view = $id;
        $view->name = $name;
        $view->id_object = $idObject;
        $parent = $model->getFieldByType(DataType::ID_PARENT);
        if ($parent != null) {
          $view->id_parent = $parent;
        }
        //Сортировка
        $view->sql_order_by = $model->getOrderBy();
        $view->save();
        $idView = $view->getIdInstance();
      }
    }

    $columnsForm = HU::post('column');
    if (count($columnsForm)) {
      if (is_null($idView)) {
        //Свойства стоят, представления нет, приписываем имеющемуся
        //Если у объекта есть единственное представление, приписываем отмеченные галочки ему
        $view = DaObjectView::model()->findAll('id_object=:id', array(':id'=>$idObject));
        if (count($view) != 1) {
          return;
        }
        $idView = $view[0]->getIdInstance();
      }

      //Уже приписанные представлению колонки
      $already = array();

      $columns = DaObjectViewColumn::model()->findAll('id_object_view=:id', array(':id'=>$idView));
      foreach($columns AS $c) {
        $already[] = $c->id_object_parameter;
      }

      foreach ($columnsForm as $col) {
        if (in_array($col, $already)) continue;

        $p = $model->getParameterObjectByIdParameter($col);
        if ($p == null) continue;
        $column = new DaObjectViewColumn();
        $column->id_object_view_column = $idView.'-'.str_replace('_', '-', $p->getFieldName());
        $column->id_object_view = $idView;
        $column->id_object = $idObject;
        $column->id_object_parameter = $p->getIdParameter();
        $column->caption = $p->getCaption();
        $column->id_data_type = $p->getType();
        $column->field_name = $p->getFieldName();
        $column->save();
      }


    }

  }
}
