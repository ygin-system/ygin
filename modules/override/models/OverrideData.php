<?php
class OverrideData extends CFormModel {
  
  const RW_TYPE_REWRITE = 1;
  const RW_TYPE_SKIP    = 2;
  
  public $theme;
  public $data;
  public $overrideDataItemTree;
  public $rewriteType = self::RW_TYPE_SKIP;
  
  
  public function getRewriteTypes() {
    return array(
      self::RW_TYPE_SKIP => 'Пропустить',
      self::RW_TYPE_REWRITE => 'Перезаписать',
    );
  }
  
  public function rules() {
    return array(
      array('rewriteType', 'in', 'range' => array_keys($this->getRewriteTypes())),
      array('data', 'safe'),
    );
  }
  
  
  
}