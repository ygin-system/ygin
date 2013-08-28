<?php

class DefaultController extends DaObjectController {

  const EVENT_ON_PARAMETER_AVAILABLE_TO_SEARCH = 'onParameterAvailableToSearch';
  const EVENT_ON_BEFORE_GRID = 'onBeforeGrid';
  const EVENT_ON_PROCESS_PERMISSION_WHERE = 'onProcessPermissionWhere';
  const EVENT_ON_CONFIGURE_DATA_PROVIDER = 'onConfigureDataProvider';
  const EVENT_ON_CREATE_INSTANCE = 'onCreateInstance';

  public $layout = 'backend.views.layouts.object_view';
  
  public $buttons = array();
  public $searchModel = null;

  private $_groupInstance = null;
  private $_groupParameter = null;

  /**
   * @return DaActiveRecord
   */
  public function getGroupInstance() {
    return $this->_groupInstance;
  }
  /**
   * @return ObjectParameter
   */
  public function getGroupParameter() {
    return $this->_groupParameter;
  }

  private function main() {
    /**
     * @var $model DaActiveRecord
     * @var $object DaObject
     */
    $object = Yii::app()->backend->object;
    $view = Yii::app()->backend->objectView;
    $model = $object->getModel();
    $idObject = $object->id_object;
    $idView = $view->id_object_view;

    if ($this->_groupInstance != null) {
      $linkObject = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
        ObjectUrlRule::PARAM_OBJECT_PARENT=>$this->_groupInstance->getIdParent(),
        ObjectUrlRule::PARAM_OBJECT=>$this->_groupInstance->getIdObject(),
        ObjectUrlRule::PARAM_PAGER_NUM=>ObjectUrlRule::getCurrentParameter(ObjectUrlRule::PARAM_PAGER_NUM_BACK),
      ));
      //$tmpPage->setProperty(DA_URL_GO, $urlPage->GET(DA_URL_BACK_PAGE));  // TODO !!!!!
      $linkInstance = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
        ObjectUrlRule::PARAM_OBJECT_PARENT=>$this->_groupInstance->getIdParent(),
        ObjectUrlRule::PARAM_OBJECT=>$this->_groupInstance->getIdObject(),
        ObjectUrlRule::PARAM_OBJECT_INSTANCE=>$this->_groupInstance->getIdInstance(),
      ));
      $caption = '"'.strip_tags($this->_groupInstance->getInstanceCaption()).'"';
      $this->caption .= ' '.$caption;

      $this->breadcrumbs[$this->_groupParameter->caption] = $linkObject;
      $this->breadcrumbs[$caption] = $linkInstance;
      $this->breadcrumbs[$object->name] = '/';
    }

    $idParent = null;
    $parentModel = null;
    $idParentField = $view->id_parent;
    if ($idParentField != null) {
      $idParent = HU::get(ObjectUrlRule::PARAM_OBJECT_PARENT);
      if ($idParent != null) {
        if (($parentModel=$model->findByPk($idParent)) == null) {
          $idParent = null;
        } else {
          $this->caption = $parentModel->getInstanceCaption();

          $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
            ObjectUrlRule::PARAM_OBJECT_PARENT=>$parentModel->$idParentField,
            ObjectUrlRule::PARAM_OBJECT_VIEW=>$idView,
            ObjectUrlRule::PARAM_OBJECT=>$idObject,
          ));

          $this->buttons[] = array(
            'url' => $link,
            'caption' => '<i class="icon-arrow-up icon-white"></i> Вверх',
            'class' => 'btn-warning'
          );

          $this->breadcrumbs = array();
          $tmp = $parentModel;
          while ($tmp != null) {
            $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
              ObjectUrlRule::PARAM_OBJECT_PARENT=>$tmp->$idParentField,
              ObjectUrlRule::PARAM_OBJECT_VIEW=>$idView,
              ObjectUrlRule::PARAM_OBJECT=>$idObject,
            ));
            $this->breadcrumbs[$tmp->getInstanceCaption()] = $link;
            if ($tmp->$idParentField != null) {
              $tmp = $model->findByPk($tmp->$idParentField);
            } else {
              $tmp = null;
            }
          }
          $this->breadcrumbs[$object->name] = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
            ObjectUrlRule::PARAM_OBJECT_VIEW=>$idView,
            ObjectUrlRule::PARAM_OBJECT=>$idObject,
          ));
          $this->breadcrumbs = array_reverse($this->breadcrumbs);

        }
      }
    }

    // вновь восстанавливаем чистую модель, т.к. конструкции типа $model->findByPk затирают resetScope
    $model = $object->getModel();

    // кнопка создать
    if (Yii::app()->authManager->canCreateInstance($idObject, Yii::app()->user->id)) {
      $link = ObjectUrlRule::createUrlFromCurrent(BackendModule::ROUTE_INSTANCE_LIST, array(ObjectUrlRule::PARAM_OBJECT_INSTANCE => -1));
      array_unshift($this->buttons, array(
          'url' => $link,
          'caption' => '<i class="icon-plus icon-white"></i> Создать',
          'class' => 'btn-success',
          'code' => 'create',
      ));
    }



    $dataProvider = $this->buildDataProvider($view, $model);
    $criteria = $dataProvider->getCriteria();

    $searchModel = new ParameterSearchForm($object); // поиск TODO отвязаться от параметров и перейти на отдельное понятие Фильтры
    foreach($searchModel->getSearchParameters() AS $searchParam) {
      $event = new ParameterAvailableToSearchEvent($this, $searchParam->parameter);
      $this->raiseEvent(DefaultController::EVENT_ON_PARAMETER_AVAILABLE_TO_SEARCH, $event);
      $searchParam->visible = $event->visible;
    }
    if (isset($_GET['ParameterSearchForm'])) {
      $searchModel->attributes=$_GET['ParameterSearchForm'];
    } else if (isset($_GET['ParameterSearchForm[parameter]']) && isset($_GET['ParameterSearchForm[value]'])) {
      $searchModel->parameter = $_GET['ParameterSearchForm[parameter]'];
      $searchModel->value = $_GET['ParameterSearchForm[value]'];
    }
    if ($searchModel->getHasVisibleSearchParameters()) {
      $this->searchModel = $searchModel;
      // Условия поиска по параметрам:
      if ($this->searchModel->validate() && $this->searchModel->value != null) {
        $searchCriteria = $this->searchModel->getSearchCriteria();
        $criteria->mergeWith($searchCriteria);
      }
    }

    // условие по родителю
    if ($this->getGroupInstance() == null && ($pk=$object->getParameterObjectByField($object->getFieldByType(DataType::ID_PARENT))) != null) {
      if ($idParent == null) {
        $criteria->addCondition($pk->getFieldName()." IS NULL");
      } else {
        $criteria->addCondition($pk->getFieldName()." = :id_parent");
        $criteria->params[':id_parent'] = $idParent;
      }
    } else if ($this->getGroupInstance() != null) { // Добавляем ограничения по подчинённым сущностям.
      $criteria->addCondition("t.".$this->getGroupParameter()->getFieldName()." = :group_instance");
      $criteria->params[':group_instance'] = $this->getGroupInstance()->getIdInstance();
    }

    $seqKey = $object->getParameterObjectByField($object->getFieldByType(DataType::SEQUENCE));
    if ($seqKey != null) { // определяем доступа ли сортировка
      $event = new ParameterAvailableEvent($this, $model, $seqKey);
      $event->params = array('mode'=>'seqKey');
      $this->raiseEvent(ViewController::EVENT_ON_PARAMETER_AVAILABLE, $event);
      if ($event->status != ViewController::ENTITY_STATUS_AVAILABLE) $seqKey = null;
    }
    $withSwitchPages = ($seqKey == null);  // если есть сортировка на странице, то не выводим переключатель страниц

    $oby = $view->getOrderBy();
    if ($oby == null && $object->id_field_order != null) {
      //Если есть порядок сортировки, то добавляем сортировку
      //Загружаем информацию по св-ву сортировки:
      $op = $object->getParameterObjectByIdParameter($object->id_field_order);
      $name = "t.".$op->getFieldName();
      $direction = $object->order_type;
      if ($direction == 1) $direction = "ASC"; else if ($direction == 2) $direction = "DESC";
      $oby = $name." ".$direction;
    }
    $sort = new BackendSort();
    $sort->attributes = $model->attributeNames();
    $sort->model = $model;
    $sort->params = array_merge(ObjectUrlRule::getCurrentParams(), HU::arrayToQueryArray('ParameterSearchForm', HU::get('ParameterSearchForm', array())) );

    $sort->defaultOrder = $oby;
    $dataProvider->sort = $sort;
    // $instanceQuery->setFrom($objectRazdel->getFrom()); // TODO ???

    $paginatorConfig = ($withSwitchPages ? array(
      'pageSize'=>$view->getCountData(), // количество записей на страницу
      'pageVar'=>'go',
      'params'=>array_merge(ObjectUrlRule::getCurrentParams(), HU::arrayToQueryArray('ParameterSearchForm', HU::get('ParameterSearchForm', array())) ),
    ) : false);
    $dataProvider->pagination = $paginatorConfig;

    Yii::import('backend.components.column.*');

    $gridColumns = array();
    $pk = $model->getInstanceKeyName();
    // колонка с ид объекта
    $gridColumns[] = array(
      'name'=>$pk,
      'header'=>'id',
      'htmlOptions'=>array('class'=>'col-id')
    );
    // колонка сортировки
    if ($seqKey != null) {
      $isSortAjax = ($sort->defaultOrder == $sort->getOrderBy());
      if ($isSortAjax) {
        $gridColumns[] = array(
          'sortable'=>false,
          'header'=>'&nbsp;',
          'type'=>'raw',
          'value'=>'\'<i class="icon-resize-vertical"></i>\'',
          'htmlOptions' => array('class'=>'col-num sorter', 'title'=>'Перетащите элемент для изменения последовательности'),
        );
        Yii::app()->clientScript->registerScript('admin.sequence-order.init_client', '$(".b-instance-list").daInstanceSequence('.CJavaScript::encode(array('idObject'=>$idObject, 'isAjax'=>$isSortAjax)).');', CClientScript::POS_READY);
        $js = 'function da_sortInstances(idObject, m_seq) {
  '.CHtml::ajax(array(
          'type' => 'POST',
          'dataType' => 'json',
          'url' => Yii::app()->createUrl('backend/ygin/sort'),
          'data' => 'js:{idObject:idObject, data:m_seq}',
          'success' => 'function(data){if (data.error !== undefined) {$.daSticker({text:data.error, type:"error"}); return;} $.daSticker({text:data.message, type:"success"}); }',
        )).'
}';
        Yii::app()->clientScript->registerScript('admin.sequence-order.init_server', $js, CClientScript::POS_HEAD);
      }
      //$gridColumns[] = array('class'=>'backend.components.column.SortColumn');
      /*        $daPage->addIdAjax(DA_AJAX_SORT_INSTANCES);
              if (!$isSortAjax) {
                $this->buttons[] = array(
                  'html' => '<button class="btn" onclick="$(\".b-instance-list\").daUpdateSequence({\"idObject\":'.$idObject.', \"isNotify\":true});"><i class="icon-indent-right"></i> Упорядочить</button>',
                );
              }
      */
    }

    // пустая колонка (верстка)
    $gridColumns[] = array(
      'sortable'=>false,
      'header'=>'&nbsp;',
      'type'=>'raw',
      'value'=>'\'&nbsp;\'',
      'headerHtmlOptions'=>array('class'=>'col-void'),
    );

    // колонки представлений
    $columns = $view->columns;
    $selectFields = array();
    foreach($columns AS $column) {
      if ($column->getIdObjectParameter() != null) {
        $objParam = $view->object->getParameterObjectByIdParameter($column->getIdObjectParameter());
        if ($objParam != null) {
          $selectFields[] = $objParam->getFieldName();
        }
      }

      // Если у отображаемого объекта есть группирующее свойство, то колонку для него пропускаем.
      if ($this->getGroupParameter() != null && $this->getGroupParameter()->getIdParameter() == $column->getIdObjectParameter()) continue;

      $header = $column->getCaption();
      $columnConfig = array(
        'sortable'=>($header == null ? false : true),
        'class'=>'BaseColumn',
        'header'=>($header === null ? '' : $header),
        'name'=>$column->getField(),
        'object'=>$object,
        'objectParameter'=>($column->getIdObjectParameter()==null ? null : $object->getParameterObjectByIdParameter($column->getIdObjectParameter())),
      );

      $phpScript = $column->getIdPhpScript() == null ? null : $phpScript = $column->columnClass;
      if ($phpScript == null) {
        $type = $column->getType();
        switch ($type) {
          case DataType::BOOLEAN:
            $columnConfig['class'] = 'BooleanColumn';
            break;
          case DataType::FILE:
            $columnConfig['class'] = 'FileColumn';
            break;
          case DataType::OBJECT:
            $columnConfig['class'] = 'ObjectColumn';
            break;
          case DataType::REFERENCE:
            $columnConfig['class'] = 'ReferenceColumn';
            break;
          case DataType::TIMESTAMP:
            $columnConfig['htmlOptions'] = array('class'=>'col-num');
            $columnConfig['type'] = 'datetime';
            if ($column->getIdObjectParameter() != null) {
              $objParam = $view->object->getParameterObjectByIdParameter($column->getIdObjectParameter());
              if ($objParam != null && intval($objParam->getAdditionalParameter()) === 1) {
                $columnConfig['type'] = 'date';
              }
            }
            break;
          case DataType::TEXTAREA:
            $columnConfig['type'] = 'Ntext';
            break;
          case DataType::INT:
          case DataType::VARCHAR:
          case DataType::EDITOR:
            $columnConfig['type'] = 'text';
            break;
          default: throw new Exception("Для колонки (id=".$column->getIdColumn().") c типом=".$type." не определен класс-обработчик");
        }
      } else {
        $columnConfig['class'] = $phpScript->file_path;
      }
      $gridColumns[] = $columnConfig;
    }
    $select = $pk.', '.implode(',', $selectFields);
    if ($view->getSelect() != null) $select .= ', '.$view->getSelect();
    if ($view->id_parent != null) $select .= ','.$view->id_parent;
    $criteria->select = $select;

    // колонка со связями
    // Подчинённые объекты
    $relationParams = $object->relationParameters;
    // Узнаём о том, может ли пользователь работать хотя бы с одним дочерним объектом:
    $isChildDataAvailable = false;
    $tmpIdObject = null;
    foreach($relationParams AS $parameter) {
      if ($parameter->isRelation() == false) continue;
      $idObjectTmp = $parameter->getIdObjectParameter();
      if ($idObjectTmp == $tmpIdObject) continue;

      if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, $idObjectTmp)) {
        $isChildDataAvailable = true;
        break;
      }
      $tmpIdObject = $idObjectTmp;
    }
    if (count($relationParams) > 0 && $isChildDataAvailable) {
      $gridColumns[] = array(
        'class'=>'RelationsColumn',
        'childData'=>$relationParams,
        'object'=>$object,
      );
    }

    // Зайти в папку
    if ($view->id_parent != null && $this->getGroupInstance() == null) {
      $gridColumns[] = array(
        'class'=>'FolderColumn',
        'parentField'=>$view->id_parent,
      );
    }

    $gridColumns[] = array(
      'class'=>'ActionViewColumn',
      'object'=>$object,
    );
    $gridColumns[] = array(
      'class'=>'ActionUpdateColumn',
      'object'=>$object,
    );
    $gridColumns[] = array(
      'class'=>'ActionDeleteColumn',
      'object'=>$object,
    );

    Yii::import('zii.widgets.grid.CGridView', true);

    $grid = Yii::app()->getWidgetFactory()->createWidget($this, 'CGridView', array(
      'dataProvider'=>$dataProvider,
      'columns'=>$gridColumns,

      'pager'=>'LinkPagerWidget',
      'enablePagination'=>$withSwitchPages,

      'summaryCssClass'=>'b-instance-list-count',
      'pagerCssClass'=>'pgination-container',
      'cssFile'=>false,
      'itemsCssClass'=>'table table-bordered b-instance-list daGallery',
      'rowCssClass'=>array('base','alt'),
      'template'=>"{summary}{pager}\n{items}\n{summary}{pager}",
      'beforeAjaxUpdate'=>'function(){$(document).trigger("beforeGridUpdate") }',//, {"grid" => $(this)}
      'afterAjaxUpdate'=>'function(){$(document).trigger("afterGridUpdate") }',//, {"grid" => $(this)}
      //'blankDisplay'=>'',

      'rowHtmlOptionsExpression' => 'array("id" => "ygin_inst_".$data->getIdInstance());',

    ));

    Yii::app()->clientScript->registerScript('admin.paginator.init', '
$(document).on("afterGridUpdate", function(e) {  $(".pagination .b-ajax-process").removeClass("b-ajax-process-active"); });
$(document).on("beforeGridUpdate", function(e) {  $(".pagination .b-ajax-process").addClass("b-ajax-process-active"); });
', CClientScript::POS_READY);

    $event = new BeforeGridEvent($this, $idView, $grid);
    $this->raiseEvent(DefaultController::EVENT_ON_BEFORE_GRID, $event);

    $this->render('/index', array(
      'grid' => $grid,
    ));
  }

  public function actionIndex() {
    $this->main();
  }
  public function actionIndexGroup() {
    $grpObject = HU::get(ObjectUrlRule::PARAM_GROUP_OBJECT);
    $grpInst = HU::get(ObjectUrlRule::PARAM_GROUP_INSTANCE);
    $object = DaObject::getById($grpObject);
    $this->_groupInstance = ($object == null ? null : $object->getModel()->findByIdInstance($grpInst));
    if ($this->_groupInstance != null) {
      $this->_groupInstance->setObjectInstance($object);
      $this->_groupParameter = ObjectParameter::model()->findByIdInstance(HU::get(ObjectUrlRule::PARAM_GROUP_PARAMETER));
    }
    $this->main();
  }

  /**
   * @param DaObjectView $view
   * @param DaActiveRecord $model
   * @return CActiveDataProvider
   */
  public function buildDataProvider(DaObjectView $view, DaActiveRecord $model) {
    $pk = $model->getInstanceKeyName();

    $criteria = new CDbCriteria();
    $criteria->condition = $view->getWhere();

    $dataProvider = new CActiveDataProvider($model, array(
      'criteria'=>$criteria,
      'keyAttribute'=>$pk,
    ));

    $event = new ConfigureDataProviderEvent(Yii::app()->controller, $view->id_object, $dataProvider);
    Yii::app()->controller->raiseEvent(DefaultController::EVENT_ON_CONFIGURE_DATA_PROVIDER, $event);
    $dataProvider = $event->dataProvider;

    /***Ограничение по условию, сформированным программистом в классе***/
    $event = new PermissionWhereEvent(Yii::app()->controller, $view->id_object, '');
    $event->criteria = $criteria;
    Yii::app()->controller->raiseEvent(DefaultController::EVENT_ON_PROCESS_PERMISSION_WHERE, $event);
    $where = $event->where;
    if ($where != '') {
      $criteria->addCondition($where);
    }
    $criteria->params = array_merge($criteria->params, $event->params);

    return $dataProvider;
  }

}