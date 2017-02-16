<?php
/**
 * Нужен для верстальщиков
 * @author timofeev_ro
 *
 */
class HtmlController extends Controller {

  public $layout = 'webroot.themes.business.views.layouts.main';

  public function actionIndex($view, $path) {
    if (!YII_DEBUG) throw new CHttpException(404);
    $path = str_replace('/','.',$path);
    $this->render('webroot.'.$path.$view);
  }
}
