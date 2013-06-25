<?php
/**
 * Хелпер содержащий всякие вспомогательные функции, шорткаты
 * @author timofeev_ro
 */

class HU {
  public static function dump($var) {
    CVarDumper::dump($var, 10, true);
  }
  
  public static function getUserIp() {
    $ip = null;
    if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
      $ip = $_SERVER["HTTP_X_REAL_IP"];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = Yii::app()->request->userHostAddress;
    }
    return $ip;
  }
  
  /**
   * Добавление строки в стандартный лог
   * Фиксируется время, ip, логин в системе
   * @param string $str строка для добавления в лог
   * @param integer $flag оставлен для совместимости TODO
   */
  public static function log_da($str, $flag = 1) {
    if (is_array($str) || is_object($str)) $str = print_r($str, true);
    $path = Yii::app()->getRuntimePath().'/backend_log.log';
    HU::loging($path, $str);
  }

  /**
   * Добавление лога в произвольный файл
   * Фиксируется время, ip, логин в системе
   * @param string $fileName абсолютный пусть и имя файла лога
   * @param string $str строка для записи
   * @param integer $flag оставлен для совместимости TODO
   */
  public static function loging($fileName, $str, $flag = 1, $rn = false) {
    $exists = true;
    if (!file_exists($fileName)) {
      $exists = false;
    }

    if ($fp=fopen($fileName, "a")) {
      //OK. Work with file
      $s = date("Y.m.d H:i:s")." ip:".HU::getUserIp().' ';
      if (Yii::app()->hasModule('user') && !Yii::app()->user->isGuest) {
        $s .= Yii::app()->user->name;
      } else {
        $s .= 'guest';
      }
      $s .= " ".$str."\r\n";
      if ($rn) $s = "\r\n".$s;
      fwrite($fp, $s);
      fclose($fp);
    }

    if (!$exists) {
      chmod($fileName, 0777);
    }
  }
  
  
  public static function checkEmail($email) {
    return HEmailEncode::checkEmail($email);
  }

  /**
   * Возвращает значение ключа $name из массива $_GET
   * @package url
   * @param  string
   * @param  string
   * @return string
   */
  public static function get($name, $default=null) {
    return Yii::app()->getRequest()->getQuery($name, $default);
  }
  
  /**
   * Возвращает значение ключа $name из массива $_POST
   * @package url
   * @param  string
   * @param  string
   * @return string
   */
  public static function post($name, $default=null) {
    return Yii::app()->getRequest()->getPost($name, $default);
  }
  public static function postModelAttr($model, $attributeName, $default=null) {
    $modelClass = (is_string($model) ? $model : get_class($model));
    $val = self::post($modelClass);
    if (isset($val[$attributeName])) $val = $val[$attributeName];
      else $val = $default;
    return $val;
  }
  public static function unsetPostModelAttr($model, $attributeName) {
    $modelClass = (is_string($model) ? $model : get_class($model));
    if (isset($_POST[$modelClass][$attributeName])) unset($_POST[$modelClass][$attributeName]);
  }


}


