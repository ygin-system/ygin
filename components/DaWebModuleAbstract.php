<?php 
abstract class DaWebModuleAbstract extends CWebModule {
  
  protected $_urlRules = array();
  
  public function setUrlRules(array $rules) {
    foreach($this->_urlRules AS $pattern => $route) {
      if (!array_key_exists($pattern, $rules)) {
        $rules[$pattern] = $route;
      } else if ($rules[$pattern] == null) {
        unset($rules[$pattern]);
      }
    }
    $this->_urlRules = $rules;
  }
  public function getUrlRules() {
    return $this->_urlRules;
  }
  
  public function setModels(array $models) {
    Yii::app()->setModels($models);
  }
  
  public function setModules($modules) {
    $newModules = array();
    foreach ($modules as $id => $module) {
      if (is_int($id)) {
        $id = $module;
        $module = array();
      }
      if (strpos($id, "ygin.") !== false) {
        $id = str_replace("ygin.", "", $id);
        if ($id != 'ygin')
          Yii::setPathOfAlias($id, Yii::getPathOfAlias($this->getId().'.modules.' . $id));
        //print_r($this->getId().'.modules.' . $id);exit;
        $module['class'] = $id . '.' . ucfirst($id) . 'Module';
      }
      $newModules[$id] = $module;
    }
    //print_r($newModules);exit;
    parent::setModules($newModules);
  }
}
