<?php

class RelationsColumn extends CGridColumn {

  public $childData;
  public $object;

  private $prepareData = array();
  private $single = true;

  protected function renderHeaderCellContent() {
  }

  public function init() {
    parent::init();
    $arrayOfId = $this->grid->dataProvider->getKeys();
    if (count($arrayOfId) == 0) return;
    $availableObjects = array();
    $singleStatus = 0;
    foreach($this->childData AS $param) {
      if ($param->isRelation() == false) continue;
      $idObject = $param->getIdObjectParameter();
      // Смотрим, может ли пользователь работать с подчинённым объектом
      if (isset($availableObjects[$idObject]) && $availableObjects[$idObject] === null) continue;
      if (!Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, $idObject)) {
        $availableObjects[$idObject] = null;
        continue;
      } else {
        $singleStatus = ($singleStatus == 0 ? 1 : 2);
        $availableObjects[$idObject][$param->getIdParameter()]['field'] = $param->getFieldName();
      }
    }
    if ($singleStatus == 2) {
      $this->single = false;
      $this->htmlOptions = array('class'=>'col-ref action-sub-data');
    } else {
      $this->htmlOptions = array('class'=>'col-ref-one action-sub-data');
    }
    foreach($availableObjects AS $idObject => $params) {
      if ($params === null) {unset($availableObjects[$idObject]); continue;}
      $object = null;
      if (count($params) == 1) {
        $object = DaObject::getById($idObject, false);
        foreach ($params AS $idParameter => $caption) {
          $availableObjects[$idObject][$idParameter]['caption'] = $object->name;
        }
      } else {
        $object = DaObject::getById($idObject, true);
        foreach($params AS $idParameter => $caption) {
          $param = $object->getParameterObjectByIdParameter($idParameter);
          $availableObjects[$idObject][$idParameter]['caption'] = $object->name.' ('.$param->caption.')';
        }
      }
      $model = $object->getModel();
      foreach($params AS $idParameter => $config) {
        $cr = new CDbCriteria();
        $cr->addColumnCondition(array('t.id_object' => $idObject));
        $cr->order = 't.order_no';
        $objectView = DaObjectView::model()->find($cr);

        $dataProvider = Yii::app()->controller->buildDataProvider($objectView, $model);
        $where = $dataProvider->criteria->condition;
        $params = $dataProvider->criteria->params;

        $whereConfig = array('and');
        if ($where != null) $whereConfig[] = $where;
        $whereConfig[] = array('in', $config['field'], $arrayOfId);

        $data = Yii::app()->db->createCommand()
            ->select($config['field'].' AS id, count(*) AS cnt')
            ->from($model->tableName())
            ->where($whereConfig, $params)
            ->group($config['field'])
            ->queryAll();

        /*
        // многообъектая поддержка
        $iq = new InstanceQuery($where);
        $arrayOfIdObject = Object::getCommonObjectBySingle($idObjectTmp);
        if (count($arrayOfIdObject) > 1) {
          $iq->setUsedObjects(array($idObjectTmp));
        }*/

        $assocData = array();
        foreach ($data AS $row) {
          $assocData[$row['id']] = $row['cnt'];
        }
        $availableObjects[$idObject][$idParameter]['data'] = $assocData;

      }
    }
    $this->prepareData = $availableObjects;
    // TODO: Поменять скрипт, когда будет применяться PopOver
    if (!$this->single) {
      Yii::app()->clientScript->registerScript('admin.subData.init', '$(".action-sub-data").daSubData();
$(document).on("afterGridUpdate", function(e) {  $(".action-sub-data").daSubData(); });
', CClientScript::POS_READY);
      /*
        Yii::app()->clientScript->registerScript('admin.subData.init', '
        $("[rel=\'popover-sub-data\']").popover({
          placement: "left",
          trigger:   "hover",
          template:  "<div class=\'popover\'><div class=\'arrow\'></div><div class=\'popover-inner\'><div class=\'popover-content\'></div></div></div>"
        });', CClientScript::POS_READY);
        
       */
    }
  }

  protected function renderDataCellContent($row, $data) {
    $c = count($this->prepareData);
    if ($c == 0) return;
    $idInstance = $data->getIdInstance();
    if (!$this->single) {
      /* TODO: взять этот тег i, когда будет PopOver
       * <i data-content="данные" rel="popover-sub-data"></i> 
       */
      echo '<div class="popover-container">
              <i rel="popm'.$idInstance.'"  title="Зависимые данные"></i>
              <ul id="popm'.$idInstance.'">
';
    }
    foreach($this->prepareData AS $idObject => $params) {
      foreach($params AS $idParameter => $config) {
        $page = null;
        if ($this->grid->dataProvider->getPagination()) {
          $page = $this->grid->dataProvider->getPagination()->currentPage + 1;
        }
        $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
          ObjectUrlRule::PARAM_GROUP_INSTANCE=>$idInstance,
          ObjectUrlRule::PARAM_GROUP_OBJECT=>$this->object->id_object,
          ObjectUrlRule::PARAM_GROUP_PARAMETER=>$idParameter,
          ObjectUrlRule::PARAM_OBJECT=>$idObject,
          ObjectUrlRule::PARAM_PAGER_NUM_BACK=>$page,
        ));
        $caption = $config['caption'];
        $count = isset($config['data'][$idInstance]) ? $config['data'][$idInstance] : 0;
        if ($this->single) {
          echo '<table cellpadding="0"><tr><th><i title="Зависимые данные"></i></th>
  <td>
    <a href="'.$link.'">'.$caption.'</a>&nbsp;['.$count.']'.'
  </td>
 </tr></table>';
        } else {
          echo '    <li><a href="'.$link.'">'.$caption.'</a>&nbsp;['.$count.']</li>';
        }
      }
    }
    if (!$this->single) {
      echo '</ul></div>';
    }
  }

}
