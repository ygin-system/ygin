<?php
class LikeAndShareWidget extends DaWidget {
  
  public $title = null;
  public $url = null;
  
  public function run() {
    if ($this->url == null)
      $this->url = Yii::app()->request->getBaseUrl(true).Yii::app()->request->getUrl();
    //Если есть гет параметры то, кодируем урл
    if (($pos = mb_strpos($this->url, '?')) !== false) {
      $uri = mb_substr($this->url, 0, $pos + 1);
      $query = mb_substr($this->url, $pos + 1);
      $encodedQuery = '';
      if (!empty($query)) {
        $first = true;
        foreach (explode('&', $query) as $param) {
          $pair = explode('=', $param);
          if (count($pair) != 2) continue;
          list($paramName, $paramValue) = $pair;
          if ($first) {
            $first = false;
          } else {
            $encodedQuery .= '&';
          }
          $encodedQuery .= $paramName.'='.CHtml::encode($paramValue);
        }
      }
      $this->url = $uri.$encodedQuery;
    }
    $this->render("view", array("title" => $this->title, "url" => $this->url) );
  }
  
}