<?php
class DaBcryptPasswordStrategy extends ABcryptPasswordStrategy {
  protected function getRandomBytes($count = 16)
  {
    $bytes = "";
    if (function_exists("openssl_random_pseudo_bytes") && strtoupper(substr(PHP_OS,0,3)) !== "WIN") {
      $bytes = openssl_random_pseudo_bytes($count);
    }
    else if(
      $bytes == ""
      && @is_readable("/dev/urandom")
      && ($handle = @fopen("/dev/urandom", "rb")) !== false
    ) {
      $bytes = fread($handle,$count);
      fclose($handle);
    }
  
    if (strlen($bytes) < $count) {
      $key = uniqid(Yii::app()->name, true);
  
      // we need to pad with some pseudo random bytes
      while(strlen($bytes) < $count) {
        $value = $bytes;
        for($i = 0; $i < 12; $i++) {
          $hashFunc = 'sha1';
          if (version_compare(PHP_VERSION, '5.3.0') >= 0 && version_compare(PHP_VERSION, '5.4.0') < 0) {
            $hashFunc = 'salsa20';
          }
          $value = hash_hmac($hashFunc,microtime().$value,$key,true);
          usleep(10); // make sure microtime() returns a new value
        }
        $bytes = substr($value,0,$count);
      }
    }
    return $bytes;
  }
}