<?php

class StaticController extends Controller {
  
  public $defaultAction = 'page';
  
  public $view404 = '/404';
  public $view403 = '/access_denied';
  public $viewError = '/error';

  private function processViewPath($view, $viewName, $engineDir) {
    if ($view === false) {
      preg_match('~[a-zA-Z\-\_\d]+$~', $viewName, $matches);
      $path = Yii::getPathOfAlias($engineDir.'.'.$matches[0]).'.php';
      if (is_file($path)) $view = Yii::app()->findLocalizedFile($path);
    }
    return $view;
  }
  public function getViewFile($viewName) {
    $view = parent::getViewFile($viewName);
    return $this->processViewPath($view, $viewName, 'ygin.views');
  }
  public function getLayoutFile($viewName) {
    $view = parent::getLayoutFile($viewName);
    return $this->processViewPath($view, $viewName, 'ygin.views.layouts');
  }

  //Действие для статических страниц
  public function actionPage() {
    $current = Yii::app()->menu->current;
    if ($current !== null) {
      if (empty($current->content)) {
        if ($current->go_to_type == Menu::GO_TO_LIST_CHILD && $current->getVisibleChildCount() > 0) {
          $this->render('/treeMenu', array('menu' => $current));
        } else if ($current->go_to_type == Menu::GO_TO_SHOW_BLANK) {
          $this->render('/blankPage');
        } else {
          $this->render('/emptyPage', array('menu' => $current));
        }
      } else {
        $this->render('/staticPage', array('menu' => $current));
      }
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
  }
  
  /**
   * This is the action to handle external exceptions.
   */
  public function actionError() {
    $view = $this->viewError;
    if ($error=Yii::app()->errorHandler->error) {
      if ($error['code'] == 404) { // Устанавливаем свой макет для отображения 404 ошибки
        $this->layout = '404';
        $view = $this->view404;
      } else if ($error['code'] == 403) { // доступ запрещен
        $view = $this->view403;
        if (empty($error['message'])) $error['message'] = 'Доступ к странице запрещен.';
      }
       
      if(Yii::app()->request->isAjaxRequest) {
        echo $error['message'];
        return;
      }
    } else {
      $this->layout = '404';
      $view = $this->view404;
    }
    $this->render($view, $error);
  }
}