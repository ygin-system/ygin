<?php
class OverrideDataItem extends CModel {
  public $name;
  public $value;
  public $path;
  public $_items = array();
  public $mayBeEmpty = false;
  public $parent = null;
  
  public function setItems($items) {
    foreach ($items as $item) {
      $item->parent = $this;
    }
    $this->_items = $items;
  }
  
  public function addItem($item) {
    $item->parent = $this;
    $this->_items[] = $item;
  }
  
  public function getItems() {
    return $this->_items;
  }
  
  public function attributeNames() {
    return array();
  }
  
  public function getFullName() {
    $name = strtr($this->name, array(
      '/' => '_',
      '.' => '_',
    ));
    if ($this->parent !== null) {
      return $this->parent->getFullName().'_'.$name;
    }
    return $name;
  }
  
  public function deleteEmpty() {
    foreach($this->_items as $key => $item) {
      if ($item->deleteEmpty()) {
        unset($this->_items[$key]);
      }
    }
    return (count($this->_items) == 0 && !$this->mayBeEmpty);
  }
  public function getByFullName($fullName) {
    if ($this->getFullName() == $fullName) {
      return $this;
    }
    foreach($this->_items as $item) {
      if ($find = $item->getByFullName($fullName)) {
        return $find;
      }
    }
    return null;
  }
  
  public function getByName($name) {
    if ($this->name == $name) {
      return $this;
    }
    foreach ($this->_items as $item) {
      if ($find = $item->getByName($name)) {
        return $find;
      }
    }
    return null;
  }
  
  public function isAssets() {
    return $this->findParentByName('assets') !== null;
  }
  
  public function isViews() {
    return $this->findParentByName('views') !== null;
  }
  
  public function findParentByName($name) {
    if ($this->parent) {
      if ($this->parent->name == $name) {
        return $this->parent;
      } else {
        return $this->parent->findParentByName($name);
      }
    }
    return null;
  }
  
  private function getDir($path) {
    return dirname(ltrim($this->name, '/'));
  }
  
  public function getOverridingDir() {
    $result = '';
    if ($this->isModuleAssets() || $this->isModuleViews()) {
      $moduleName = $this->getModuleName();
      if ($this->isModuleAssets()) {
        $result = '/assets';
      } else {
        $dir = '/'.$this->getDir($this->name);
        $result = $dir;
      }
      $result = $moduleName.$result;
    } elseif ($this->isWidgetAssets() || $this->isWidgetViews()) {
      $widgetName = $this->getWidgetName();
      if ($this->isWidgetAssets()) {
        $widgetName .= '/assets';
      } else {
        $dir = '/'.$this->getDir($this->name);
        $result = $dir;
      }
      $result = $widgetName.$result;
    }
    return $result;
  }
  
  public function getModuleName() {
    if ($this->parent) {
      if ($this->parent->name == 'modules') {
        return $this->name;
      } else {
        return $this->parent->getModuleName();
      }
    }
    return null;
  }
  
  public function getWidgetName() {
    if ($this->parent) {
      if ($this->parent->name == 'widgets') {
        return $this->name;
      } else {
        return $this->parent->getWidgetName();
      }
    }
    return null;
  }
  
  public function isModuleAssets() {
    return $this->isAssets() && !$this->inWidget();
  }
  
  public function isModuleViews() {
    return $this->isViews() && !$this->inWidget();
  }
  
  public function isWidgetAssets() {
    return $this->isAssets() && $this->inWidget();
  }
  
  public function isWidgetViews() {
    return $this->isViews() && $this->inWidget();
  }
  
  public function isWidget() {
    return $this->inWidget() && !$this->isAssets() && !$this->isViews();
  }
  
  public function inWidget() {
    return $this->findParentByName('widgets') !== null;
  }
  
  public function inModule() {
    return $this->findParentByName('modules') !== null;
  }
  
  public function getItemsForOverride() {
    $result = array();
    if ($this->mayBeEmpty) {
      $result[] = $this;
    }
    foreach ($this->_items as $item) {
      $result = array_merge($result, $item->getItemsForOverride());
    }
    return $result;
  }
}