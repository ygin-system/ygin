<?php
// http://ru2.php.net/manual/en/function.curl-setopt.php
// http://snippy.ru/tags/curl-1.html
class TransferData {
  const METHOD_GET =  1;
  const METHOD_POST = 2;
  
  private $isConnect = false;
  private $hCurl = null;
  private $arrayWithValues = array();
  private $methodTransfer = null;
  private $target = null;
  private $isHeaderNeed = false;
  private $followLocation = false;
  private $httpCode = null;
  private $curlInfo = array();
  private $authInfo = null;
  private $useDnsGlobalCache = true;
  private $timeout = 7;    // 0 - no timeout
  private $referrer = null;
  private $cookieJar = null;
  private $cookieFile = null;
  private $noBody = false;  // не получать тело странички]
  private $httpHeader = array();  // дополнительные опции хттп-заголовка
  
  private $redirect = false;
  private $maxRedirect = 5;
  private $curCountRedirect = 0;  
  
  // доп. св-ва
  private $userAgent = null;

  private $resultData = null;
  private $resultHead = null;

  public function TransferData() {
    $this->methodTransfer = TransferData::METHOD_GET;
  }

  public function setHttpHeader(array $header) {
    $this->httpHeader = $header;
  }
  
  public function setIsRedirect($bool) {
    $this->redirect = $bool;
  }
    
  public function setUserAgent($userAgent) {
    $this->userAgent = $userAgent;
  }
  
  public function setAuthInfo($string) {
    // $authInfo = $_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW'];
    $this->authInfo = $string;
  } 
  public function setVariable($name, $strValue) {
    // $curl->setVariable($name, "@".$newFilePath); - files
    $this->arrayWithValues[$name] = $strValue;
  }
  public function clearVariables() {
    $this->arrayWithValues = array();
  }
  public function methodIsPost() {
    $this->methodTransfer = TransferData::METHOD_POST;
  }
  public function methodIsGet() {
    $this->methodTransfer = TransferData::METHOD_GET;
  }
  public function setTarget($target) {
    $this->target = $target;
  }
  public function getResultData() {
    return $this->resultData;
  }
  public function getResultHead() {
    return $this->resultHead;
  }
  public function getHttpCode() {
    return $this->httpCode;
  }
  public function getCurlInfo() {
    return $this->curlInfo;
  }
  public function isTransferSuccess() {
    $code = intval($this->getHttpCode());
    $r = false;
    if ($code == 200) $r = true;
    return $r;
  }
  public function isHeaderNeed($bool) {
    $this->isHeaderNeed = $bool;
  }
  public function isFollowLocation($bool) {
    $this->followLocation = $bool;
  }
  public function useDnsGlobalCache($bool) {
    $this->useDnsGlobalCache = $bool;
  }
  public function setTimeout($timeout) {
    $this->timeout = intval($timeout);
  }
  public function setReferrer($string) {
    $this->referrer = $string;
  }
  public function setCookieJar($string) {
    $this->cookieJar = $string;
  }
  public function setCookieFile($string) {
    $this->cookieFile = $string;
  }
  public function noBody($bool) {
    $this->noBody = $bool;
  }
  
  private function dataEncode($keyprefix = "", $keypostfix = "") {
    assert(is_array($this->arrayWithValues));
    $vars = null;
    foreach($this->arrayWithValues as $key => $value) {
      if(is_array($value)) $vars .= $this->data_encode($value, $keyprefix.$key.$keypostfix.urlencode("["), urlencode("]"));
        else $vars .= $keyprefix.$key.$keypostfix."=".urlencode($value)."&";
    }
    return $vars;
  } 
  
  public function exec() {
    if ($this->redirect && $this->curCountRedirect >= $this->maxRedirect) {
      throw new Exception("Достигнуто максимальное число (".$this->maxRedirect.") редиректов. Последний адрес=".$this->target);
    }
    
    if (!$this->isConnect) {
      $this->hCurl = curl_init();
      $this->isConnect = true;
    }
    if ($this->redirect) $this->isHeaderNeed = true;

    curl_setopt($this->hCurl, CURLOPT_HEADER , $this->isHeaderNeed);
    curl_setopt($this->hCurl, CURLOPT_FOLLOWLOCATION , $this->followLocation);
    curl_setopt($this->hCurl, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($this->hCurl, CURLOPT_DNS_USE_GLOBAL_CACHE, $this->useDnsGlobalCache);
    curl_setopt ($this->hCurl, CURLOPT_URL, $this->target);
    curl_setopt($this->hCurl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    curl_setopt($this->hCurl, CURLOPT_NOBODY, $this->noBody);
    curl_setopt($this->hCurl, CURLOPT_HTTPHEADER, $this->httpHeader);
    
//    curl_setopt($this->hCurl, CURLINFO_HEADER_OUT, true);

    if ($this->userAgent != null) curl_setopt($this->hCurl, CURLOPT_USERAGENT, $this->userAgent);
    
    if ($this->authInfo != null) {
      curl_setopt($this->hCurl, CURLOPT_USERPWD, $this->authInfo);
    }
    if ($this->referrer != null) {
      curl_setopt($this->hCurl, CURLOPT_REFERER, $this->referrer);
    }
    if ($this->cookieJar != null) {
      curl_setopt($this->hCurl, CURLOPT_COOKIEJAR, $this->cookieJar);
    }
    if ($this->cookieFile != null) {
      curl_setopt($this->hCurl, CURLOPT_COOKIEFILE, $this->cookieFile);
    }

    $vars = $this->dataEncode();
    if ($this->methodTransfer == TransferData::METHOD_POST) {
      curl_setopt($this->hCurl, CURLOPT_POST, true);
      //curl_setopt($this->hCurl, CURLOPT_POSTFIELDS, $vars);
      curl_setopt($this->hCurl, CURLOPT_POSTFIELDS, $this->arrayWithValues);
    } else {
      curl_setopt($this->hCurl, CURLOPT_POST, false);
      if (count($this->arrayWithValues) > 0)
        curl_setopt ($this->hCurl, CURLOPT_URL, $this->target."?".$vars);
    }

    $this->resultHead = null;
    $this->resultData = curl_exec($this->hCurl);

    $this->httpCode = curl_getinfo($this->hCurl, CURLINFO_HTTP_CODE);
    $this->curlInfo = curl_getinfo($this->hCurl);

    if ($this->isHeaderNeed) {
      $this->resultHead = mb_substr($this->resultData, 0, $this->curlInfo['header_size']);
      $this->resultData = mb_substr($this->resultData, $this->curlInfo['header_size']);
    }
    
    if ($this->redirect && ($this->httpCode == 301 || $this->httpCode == 302)) {
      $matches = array();
      preg_match('/Location:(.*?)\n/', $this->resultHead, $matches);
      //$url = @parse_url(trim(array_pop($matches)));
      if (is_array($matches) && count($matches) > 1) {
        $url = @parse_url(trim($matches[1]));
        $lastUrl = parse_url(curl_getinfo($this->hCurl, CURLINFO_EFFECTIVE_URL));
        if (!array_key_exists('scheme', $url)) $url['scheme'] = $lastUrl['scheme'];
        if (!array_key_exists('host', $url)) $url['host'] = $lastUrl['host'];
        if (!array_key_exists('path', $url)) $url['path'] = $lastUrl['path'];
        $q = "";
        if (array_key_exists('query', $url)) $q = '?'.$url['query'];
          else if (array_key_exists('query', $lastUrl)) $q = '?'.$lastUrl['query'];

        $newUrl = $url['scheme'] . '://' . $url['host'] . $url['path'] . $q;

        $this->setTarget($newUrl);
        $this->curCountRedirect++;
        $this->exec();
      } else {
        $this->curCountRedirect = 0;
      }     
    } else {
      $this->curCountRedirect = 0;
    }    
  }
  
  public function close() {
    if ($this->isConnect) {
      curl_close($this->hCurl);
      $this->isConnect = false;
    }
  }
  
  // static method
/*  public static function getResourceHeader($url) {
    
  }*/
  public static function isResourceValid($url, $timeout = 5, $agent=null) {
    $curl = new TransferData();
    $curl->setTarget($url);
    $curl->setTimeout($timeout);
    if ($agent != null) $curl->setUserAgent($agent);
    $curl->noBody(true);
    $curl->exec();
    $r = $curl->isTransferSuccess();
    return $r;
  }
}
