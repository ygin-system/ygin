<?php
Yii::import('zii.widgets.CMenu');

class MenuWidget extends CMenu implements IParametersConfig {

  public static function getParametersConfig() {
    return array(
      'rootItem' => array(
        'type' => DataType::INT,
        'default' => null,
        'label' => 'ИД корневого раздела (пусто - все разделы первого уровня)',
        'required' => false,
      ),
      'htmlOptions' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'array()',
        'label' => 'Атрибуты корневого ul (исполняемое выражение)',
        'required' => true,
      ),
      'activeCssClass' => array(
        'type' => DataType::VARCHAR,
        'default' => '',
        'label' => 'css-класс для активного элемента',
        'required' => false,
      ),
      'itemCssClass' => array(
        'type' => DataType::VARCHAR,
        'default' => '',
        'label' => 'css-класс элементов',
        'required' => false,
      ),
      'encodeLabel' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'false',
        'label' => 'Кодировать ли подпись (исполняемое выражение)',
        'required' => true,
      ),
      'drawImage' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'false',
        'label' => 'Выводить ли иконки у разделов меню)',
        'required' => true,
      ),
      'submenuHtmlOptions' => array(
        'type' => DataType::EVAL_EXPRESSION,
        'default' => 'array()',
        'label' => 'Атрибуты для ul кроме корневого (исполняемое выражение)',
        'required' => true,
      ),
      'maxChildLevel' => array(
        'type' => DataType::INT,
        'default' => 1,
        'label' => 'Кол-во выводимых уровней (-1 - все, 0-первый и т.д.)',
        'required' => true,
      ),
      'baseTemplate' => array(
        'type' => DataType::VARCHAR,
        'default' => '',
        'label' => 'Шаблон для оборачивания всего меню (доступна переменная {menu})',
        'required' => false,
      ),

    );
  }

  /**
   * Родительский раздел, дети которого будут отрисовываться
   * @var Menu
   */
  public $rootItem = null;
  /**
   * Количество отрисовываемых дочерних уровней
   * Если 0 то рисуем только один уровень (текущий).
   * Если -1, то рисуем все уровни без ограничения.
   * @var int
   */
  public $maxChildLevel = 0;
  
  /**
   * Шаблон названия
   * Например <b>{label}</b>
   * @var string
   */
  public $labelTemplate = false;
  
  /**
   * Атрибуты для ссылок
   * @var array
   */
  public $linkOptions = array();
  /**
   * Атрибуты для ссылок у разделов с вложенными разделами
   * @var array
   */
  public $linkDropDownOptions = array();
  /**
   * Атрибуты для ссылок у разделов с вложенными разделами 2-го уровня
   * @var array
   */
  public $linkDropDownOptionsSecondLevel = array();
  /**
   * Атрибуты для li
   * @var array
   */
  public $itemOptions = array();
  /**
   * Атрибуты для li у разделов с вложенными разделами
   * @var array
   */
  public $itemDropDownOptions = array();
  /**
   * Атрибуты для li у разделов 3 уровня
   * @var array
   */
  public $itemDropDownOptionsSecondLevel = array();
  /**
   * Шаблон для подписи разделов с вложенными разделами
   * @var array
   */
  public $labelDropDownTemplate = null;
  /**
   * Выводить ли картинку, загруженную в раздел
   * @var array
   */
  public $drawImage = false;
  /**
   * Общий шаблон для виджета, позволяющий обернуть данные нужным тэгом
   * @var array
   */
  public $baseTemplate = null;
  
  
  /**
   * Рекурсивно обходит меню и подготавливает данные для отрисовки
   * @param Menu $root
   * @param int $level
   */
  protected function prepareItemsRecursive(Menu $root, $level) {
    $preparedItems = array();
    if ($this->maxChildLevel != -1 && $level > $this->maxChildLevel) {
      return $preparedItems;
    }
    
    if ($root->getVisibleChildCount() == 0) {
      return $preparedItems;
    }
    
    $menuItems = $root->getChild();
    foreach ($menuItems as $menuItem) {
      /**
       * @var $menuItem Menu
       */

      if (!$menuItem->isVisible) {
        continue;
      }
      
      $childItems = $this->prepareItemsRecursive($menuItem, $level + 1);
      
      $labelTemlate = count($childItems) == 0 ? $this->labelTemplate : ($this->labelDropDownTemplate !== null ? $this->labelDropDownTemplate : $this->labelTemplate);
      $linkOptions = $this->linkOptions;
      $itemOptions = $this->itemOptions;
      if ($level > 0) { // если 2 и больше уровень
        if (count($childItems) > 0){
          $itemOptions = (count($this->itemDropDownOptionsSecondLevel) > 0 ? $this->itemDropDownOptionsSecondLevel : $this->itemOptions);
          $linkOptions = (count($this->linkDropDownOptionsSecondLevel) > 0 ? $this->linkDropDownOptionsSecondLevel : $this->linkOptions);
        }
      } else {
        if (count($childItems) > 0){
          $itemOptions = (count($this->itemDropDownOptions) > 0 ? $this->itemDropDownOptions : $this->itemOptions);
          $linkOptions = (count($this->linkDropDownOptions) > 0 ? $this->linkDropDownOptions : $this->linkOptions);
        }
      }
      if ($this->drawImage && $menuItem->image != null) {
        $itemOptions['style'] = 'background:url('.$menuItem->imageFile->getUrlPath().')';
      }
      if ($menuItem->external_link_type == 1) $linkOptions['target'] = '_blank';
      $preparedItem = array(
        'active' => $this->isMenuItemActive($menuItem),
        'label' => $labelTemlate ? strtr($labelTemlate, array('{label}' => $menuItem->name)) : $menuItem->name,
        'url' => $menuItem->url,
        'linkOptions' => $linkOptions,
        'itemOptions' => $itemOptions,
      );
      
      if (!empty($childItems)) {
        $preparedItem['items'] = $childItems;
      }
      
      array_push($preparedItems, $preparedItem);
    }
    
    return $preparedItems;
  }
  
  
  protected function isMenuItemActive(Menu $item) {
    $curMenu = Yii::app()->menu->current;
    return $curMenu !== null && ($curMenu->id == $item->id || ($this->activateParents && $item->isAncestor($curMenu)));
  }
  
  
  public function init() {
    if ($this->rootItem == null) $this->rootItem = Yii::app()->menu->all;
      else if (is_numeric($this->rootItem)) $this->rootItem = Yii::app()->menu->all->getById($this->rootItem);
    if ($this->rootItem != null) {
      $this->items = $this->prepareItemsRecursive($this->rootItem, 0);
    }
    parent::init();
  }
  public function run() {
    if ($this->baseTemplate == null) {
      parent::run();
    } else {
      ob_start();
      ob_implicit_flush(false);
      parent::run();
      echo strtr($this->baseTemplate, array('{menu}' => ob_get_clean()));
    }
  }
  
}