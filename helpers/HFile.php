<?php
/**
 * Хелпер для работы с файлами
 * @author timofeev_ro
 *
 */
class HFile extends CFileHelper {
  
  /**
   * Получает расширение файла
   * @param string $fileName - имя файла
   * @param string $lower - приводить расширение к нижнему регистру
   * @return string 
   */
  public static function getExtension($fileName, $lower = true) {
    $ext = parent::getExtension($fileName);
    if ($lower) {
      $ext = mb_strtolower($ext);
    }
    return $ext;
    
    preg_match_all('~\.([^\.]*)$~u', $fileName, $matches);
    $ext = '';
    if (isset($matches[1][0])) {
      $ext = $matches[1][0];
    }
    return $ext; 
  }
  
  /**
   * Удаляет файл
   * @param string $path Путь до файла
   * @param type $aliasForDir yii-алиас до $path
   */
  public static function removeFile($path, $aliasForDir='webroot') {
    if ($aliasForDir != null) $path = Yii::getPathOfAlias($aliasForDir).DIRECTORY_SEPARATOR.$path;
    if (file_exists($path) && (is_file($path) || is_link($path))) {
      unlink($path);
    }
  }
  /**
   * Удаляет директорию если в ней нет других файлов или папок
   * @param string $path Путь до директории
   * @param type $aliasForDir yii-алиас до path-директории
   */
  public static function removeDir($path, $aliasForDir='webroot') {
    if ($aliasForDir != null) $path = Yii::getPathOfAlias($aliasForDir).DIRECTORY_SEPARATOR.$path;
    if (file_exists($path)) {
      $files = self::findFiles($path);
      if (count($files) == 0) {
        rmdir($path);
      }
    }
  }

  /**
   * Рекурсивное удаление файлов и папок
   *
   * @param string  Путь к директории, которую надо удалить
   * @param boolean Удалять ли директорию $dir в конце
   * @param boolean Вести лог при работе функции
   * @return boolean
   */
  public static function removeDirectoryRecursive($dir, $removeSelf=true, $log=false, $errorEnable=true, $excludeFiles = array()) {
    if ($dir == null) return false; // если кто-то вызовет метод с пустым значением, то метод затерет все данные на диске
    $dir = self::addSlashPath($dir);
    if (strpos(self::normalizePath($dir), self::normalizePath(realpath(Yii::getPathOfAlias('webroot')))) === false) { // и ещё защита, чтоб случано не удалили файлы, которые расположены выше корня сайта
      return false;
    }
    if (!($handle = opendir($dir))) {
      if ($log) HU::log_da('Не удалось открыть дирикторию ('.$dir.')');
      return false;
    }
    while($entry = readdir($handle)) {
      if ($entry == ".." || $entry == ".") continue;
      if (is_dir($dir.$entry)) {
        self::removeDirectoryRecursive($dir.$entry, true, $log);
      } else {
        if (in_array($entry, $excludeFiles) || in_array($dir.$entry, $excludeFiles)) continue;
        if (!(unlink($dir.$entry))) {
          if ($log) HU::log_da('Не удалось удалить файл ('.$dir.$entry.')');
        }
      }
    }
    closedir($handle);
    if ($removeSelf) {
      if ($errorEnable && !rmdir($dir) || !$errorEnable && !@rmdir($dir) ) {
        if ($log) HU::log_da('Не удалось удалить дирикторию ('.$dir.')');
        return false;
      }
    }
    return true;
  }

  /**
   * Добавляет слэш к переданному пути (если слэш уже есть, возвращает без изменения)
   * @param string  Путь к файлу
   * @return string Обработанный путь
   */
  public static function addSlashPath($s) {
    $rest = substr($s, -1);
    if (($rest == "/") || ($rest == "\\")) return $s;
    $s = $s."/";
    return $s;
  }
  
  /**
   * Извлекает имя файла по полному пути
   * @param string $path Путь к файлу
   * @param boolean $withOutExt Надо ли убирать расширение
   * @return string Имя файла
   */
  public static function getFileNameByPath($path, $withOutExt = false) {
    $file = $path;
    $path = self::normalizePath($path);
    if ($path != null) {
      $lastPos = mb_strrpos($path, "/");
      if ($lastPos !== false) {
        $file = mb_substr($path, $lastPos+1);
      }
    }

    if ($withOutExt === true || is_string($withOutExt)) {
      $ext = self::getExtension($file);
      $l = mb_strlen($ext);
      
      if ($withOutExt === true) {
        $file = mb_substr($file, 0, mb_strlen($file) - $l - 1);
      } elseif (is_string($withOutExt) && ($ext == mb_strtolower($withOutExt))) { //вырезаем только указанное расширение
        $file = mb_substr($file, 0, mb_strlen($file) - $l - 1);
      }
    } 
    return $file;
  }
  
  /**
   * Является ли расширение файла расширением картинок
   * @param string $ext  Расширение файла
   * @return boolean
   */
  public static function isImage($ext) {
    static $imgExt = array(
      'jpg', 'jpeg', 'gif', 'bmp', 'png',
    );
    return in_array(mb_strtolower($ext), $imgExt);
  }
  
  /**
   * Нормализует путь 
   * @param string $path
   * @return string Нормализованный путь
   */
  public static function normalizePath($path) {
    return str_replace(array('\\', '//'), '/', $path);
  }
  /**
   * Возвращает путь до последнего прямого слеша
   * Напр. path/to/smth, вернет path/to/
   * @param string $path Путь
   * @return string 
   */
  public static function getDir($filePath) {
    $path = self::normalizePath($filePath);
    $p = mb_strrpos($path, "/");
    if ($p === false) {
      return '';
    } else {
      return mb_substr($path, 0, $p+1);
    }
  }
  /**
   * Добавляет к имени файла $fileName дополнительную подстроку $postfix
   * @param string $fileName Имя файла
   * @param string $postfix Подстрока, которую надо добавить
   * @return string Измененное имя файла
   */
  public static function addPostfix($fileName, $postfix) {
    $dir = self::getDir($fileName);
    $ext = self::getExtension($fileName);
    $baseFileName = self::getFileNameByPath($fileName, true);
    $resFileName = $dir.$baseFileName.$postfix.'.'.$ext;
    return $resFileName;
  }

  public static function copyFile($src, $dst, $permission=0777) {
    $dir = self::getDir($dst);
    if (!is_dir($dir)) {
      mkdir($dir, $permission, true);
    }
    copy($src, $dst);
    @chmod($dst, $permission);
  }

  public static function replaceData($search, $replace, $filePath) {
    if (!is_file($filePath)) {
      $filePath = Yii::getPathOfAlias($filePath);
      if (!is_file($filePath)) return false;
    }
    $data = file_get_contents($filePath);
    if (is_array($search)) {
      $c = count($search);
      for($i = 0; $i < $c; $i++) {
        $data = str_replace($search[$i], $replace[$i], $data);
      }
    } else {
      $data = str_replace($search, $replace, $data);
    }
    file_put_contents($filePath, $data);
  }

  private static function toBytes($str){
    $val = trim($str);
    $last = strtolower($str[strlen($str)-1]);
    switch($last) {
      case 'g': $val *= 1024;
      case 'm': $val *= 1024;
      case 'k': $val *= 1024;
    }
    return $val;
  }

  public static function getMaxUploadFileSize() {
    $postSize = self::toBytes(ini_get('post_max_size'));
    $uploadSize = self::toBytes(ini_get('upload_max_filesize'));
    return min($postSize, $uploadSize);
  }

}