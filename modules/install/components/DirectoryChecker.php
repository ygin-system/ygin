<?php

class DirectoryChecker {

  public static function check() {
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $directories = array(
      $webroot.'/assets',
      $webroot.'/protected/runtime',
      $webroot.'/protected/config',
      $webroot.'/temp',
      $webroot.'/content',
    );
    $notWritable = array();
    foreach ($directories as $directory) {
      if (!is_writable($directory)) {
        $notWritable[] = $directory;
      }
    }
    if ($notWritable) {
      echo "The following directories must be writable by the webserver:<br><br>";
      echo implode("<br>", $notWritable);
      exit;
    }
  }

}