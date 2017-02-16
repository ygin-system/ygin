<?php
class DaMenu extends CApplicationComponent {

  private $_current = null;
  
  /**
   * Устанавливает текущий раздел
   * @param string $route - Роут
   * @param array $actionParams - Параметры, переданные действию 
   * @return boolean
   */
  public function setCurrent($route, $actionParams, $urlAlias=null) {
    $current = null;
    //Если статическая страница
    if (is_array($actionParams) && !isset($actionParams[MenuModule::ROUTE_STATIC_MENU_PARAM]) && $urlAlias == null) {
      $idMenu = Yii::app()->domain->model->id_default_page;
      $current = $this->getAll()->getById($idMenu);
      if ($route != MenuModule::ROUTE_STATIC_MENU && Yii::app()->request->url != '/') {
        // не главная страница. Текущий контроллер не связан с каким-либо разделом.
        // Даем ему все свойства главной страницы, а набор виджетов присваеваем набору по умолчанию
        $current->id_module_template = SiteModuleTemplate::getIdDefaultTemplate();
      }
    } else if ($urlAlias != null || isset($actionParams[MenuModule::ROUTE_STATIC_MENU_PARAM])) {
      $alias = $urlAlias;
      if ($alias == null) {
        $aliases = explode(Menu::SEPARATOR, $actionParams[MenuModule::ROUTE_STATIC_MENU_PARAM]);
        $alias = array_pop($aliases);       
      }
      $current = $this->getAll()->getByAlias($alias);
      
    } else if ($route == MenuModule::ROUTE_STATIC_MENU && isset($actionParams[MenuModule::ROUTE_STATIC_MENU_PARAM])) {
      $aliases = explode(Menu::SEPARATOR, $actionParams[MenuModule::ROUTE_STATIC_MENU_PARAM]);
      $alias = array_pop($aliases);
      $current = $this->getAll()->getByAlias($alias);
    } else {//Если динамическая
      
      $posLastSlash = mb_strrpos($route, '/');
      
      $controller = mb_substr($route, 0, $posLastSlash);
      $action = mb_substr($route, $posLastSlash + 1);
      
      $current = $this->getAll()->getByRoute($controller, $action);
    }
    
    $this->_current = $current;
    
    return $current !== null;
  }
  /**
   * Текущий раздел меню
   * @return Menu
   */
  public function getCurrent() {
    return $this->_current;
  }
  
  /**
   * Возвращает все меню
   * @return Menu
   */
  public function getAll() {
    return Menu::getAll();
  }
}