<?php

class MultiSelectWidget extends VisualElementWidget {

  public $indexView = 'backend.widgets.multiSelect.views.index';
  public $readOnlyView = 'backend.widgets.multiSelect.views.readOnly';

  public $limit = 150;
  public $parentField = null;

  public $many2manyTable = null;
  public $relationField = null;
  public $secondaryField = null;
  public $columnsCount = 1;
  public $minCountItemsInColumn = 10;
  public $htmlOptions = array();
  public $columnHtmlOptions = array();
  private $_selectedData = null;
  private $_counter = 0;
  
  public function init() {
    parent::init();
    $this->htmlOptions = CMap::mergeArray(array(
      'class' => 'b-instance-list-select-multi',
    ), $this->htmlOptions);
    $this->columnHtmlOptions = CMap::mergeArray(array(
      'class' => $this->htmlOptions['class'],
      'offset' => 'col-md-offset-1',
    ), $this->columnHtmlOptions);
  }
  
  public function onPostForm(PostFormEvent $event) {
    $this->model->attachEventHandler('onAfterSave', array($this, 'processModel'));
  }

  public function processModel(CEvent $event) {
    $postData = HU::post($this->getElementName(), array());
    $selectedData = $this->getSelectedData();
    foreach($selectedData AS $id => $name) {
      if (!in_array($id, $postData)) {
        Yii::app()->db->createCommand()->delete($this->many2manyTable, $this->relationField.'=:relField AND '.$this->secondaryField.'=:secField', array(
            ':relField'=>$this->model->getIdInstance(),
            ':secField'=>$id,
          )
        );
      }
    }
    foreach($postData AS $key => $id) {
      if (!isset($selectedData[$id])) {
        Yii::app()->db->createCommand()->insert($this->many2manyTable, array(
          $this->relationField => $this->model->getIdInstance(),
          $this->secondaryField => $id,
        ));
      }
    }
  }

  protected function _getMultiSelectHtml() {
    /**
     * @var $criteria CDbCriteria
     */
    $html = "";
    $items = $this->getItems();
    $c = count($items);
    //Если есть родительский ключ, то выводим иерархическое дерево
    if ($this->parentField != null) {
      $html = $this->renderList($items, $this->htmlOptions);
    } else {
      $htmlOptions = array();
      //количество элементов в одной колонке
      $portionLength = max(ceil($c / $this->columnsCount), $this->minCountItemsInColumn);
      $columnsCount = ceil($c / $portionLength);
      $columnHtmlOptions = $this->columnHtmlOptions;
      $offset = 0;
      $portion = 1;
      while ($portionItems = array_slice($items, $offset, $portionLength)) {
        $htmlOptions['class'] = $columnHtmlOptions['class'].' pull-left';
        if ($portion > 1) {
          $htmlOptions['class'] .= ' '.$columnHtmlOptions['offset'];
        }
        $html .= $this->renderList($portionItems, $htmlOptions);
        $offset += $portionLength;
        $portion ++;
      }
    }
    
    return $html;
  }
  
  protected function getItems($idParent = null) {
    /**
     * @var $criteria CDbCriteria
     */
    $items = array();
    $criteria = $this->getCriteria();
    $idObject = $this->getIdObjectSelectInstance();
    if ($this->parentField != null) {
      if ($idParent == null) {
        $criteria->addCondition($this->parentField.' IS NULL');
      } else {
        $criteria->addCondition($this->parentField.'='.$idParent);
      }
    }
    $data = DaObject::getById($idObject)->getModel()->findAll($criteria);
    $c = count($data);
    $selectedInstances = $this->getSelectedData();
    $cSel = count($selectedInstances);
    for ($i = 0; $i < $c; $i++) {
      /**
       * @var $inst DaActiveRecord
       */
      $inst = $data[$i];
      $children = $this->parentField != null ? $this->getItems($inst->getIdInstance()) : array();
      $items[] = array(
        'checkable' => count($children) > 0 && !$this->isAvailableCheckOnParentInstance() ? false : true,
        'checked' => isset($selectedInstances[$inst->getIdInstance()]),
        'name' => $this->getElementName().'[]',
        'label' => CHtml::encode(trim($inst->getInstanceCaption())),
        'value' => $inst->getIdInstance(),
        'items' => $children,
      );
    }
    return $items;
  }
  
  protected function renderList(array $items, $htmlOptions = array()) {
    if (count($items) == 0) return;
    $html = CHtml::openTag('ul', $htmlOptions);
    foreach ($items as $item) {
      if ($item['checkable']) {
        $id = isset($item['id']) ? isset($item['id']) : CHtml::getIdByName($item['name']).'_'.(++$this->_counter);
        $html .=
        '<li>'.
          CHtml::tag('label', array('for' => $id, 'class' => 'checkbox'),
            CHtml::checkBox($item['name'], $item['checked'], array('id' => $id, 'value' => $item['value'])).$item['label']
          )
        .$this->renderList($item['items'], $htmlOptions).'</li>';
      } else {
        $html .= '<li>'.$item['label'].$this->renderList($item['items'], $htmlOptions).'</li>';
      }
    }
    $html .= CHtml::closeTag('ul');
    return $html;
  }

  protected function getSelectedInstances() {
    /**
     * @var $model DaActiveRecord
     */
    $model = $this->model;
    if ($model->isNewRecord) return array();
    $secondaryModel = DaObject::getById($this->getIdObjectSelectInstance())->getModel();
    $cr = new CDbCriteria();
    $cr->join = 'JOIN '.$this->many2manyTable.' m2m ON t.'.$secondaryModel->getInstanceKeyName().' = m2m.'.$this->secondaryField;
    $cr->condition = 'm2m.'.$this->relationField.'=:d';
    $cr->params = array(':d'=>$model->getIdInstance());
    $cr->mergeWith($this->getCriteria());
    $data = $secondaryModel->findAll($cr);
    return $data;
  }
  public function getSelectedData() {
    if ($this->_selectedData !== null) return $this->_selectedData;
    $instances = $this->getSelectedInstances();
    $this->_selectedData = array();
    foreach($instances AS $instance) {
      $this->_selectedData[$instance->getIdInstance()] = $instance->getInstanceCaption();
    }
    return $this->_selectedData;
  }
  public function getCriteria() {
    return new CDbCriteria();
  }
  public function getIdObjectSelectInstance() {
    throw new ErrorException('Не задан ид объекта');
  }
  public function getIdObjectView() {
    throw new ErrorException('Не задано ид представление объекта отображения экземпляров');
  }
  public function isAvailableCheckOnParentInstance() {
    return false;
  }

  public function beforeRender() {
    $criteria = $this->getCriteria();
    $idObject = $this->getIdObjectSelectInstance();
    // Выясняем кол-во записей, которые доступны на выбор.
    // Если таких мало, то рисуем чекБоксы.
    $c = DaObject::getById($idObject)->getModel()->count($criteria);
    if ($c > $this->limit) {
      $this->indexView = 'backend.widgets.multiSelect.views.indexModal';
    }
  }

}
