<?php
/**
 * HMailEncode encodes emails in a html-source string.
 */
class HEmailEncode {
  /**
   * Checking an email
   * @param $email email for checking
   * @return bool it returns the result of the email check
   */
  public static function checkEmail($email) {
    // from yii framework, CEmailValidator
    return is_string($email) && strlen($email)<=254 && (preg_match(self::getMailPattern(), $email));
  }

  private static function getMailPattern($strict=true, $withSlashes=true) {
    // from yii framework, CEmailValidator::pattern
    $pattern = '[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?';
    if ($strict) $pattern = '^'.$pattern.'$';
    if ($withSlashes) $pattern = '/'.$pattern.'/';
    return $pattern;
  }

  /**
   * Encodes an email by javascript
   * @param $mail email for encoding
   * @return string encoded email
   */
  public static function getJsEmail($mail) {
    $len = strlen($mail);
    $res = '';
    for ($i = 0; $i < $len; $i++) {
      $char = $mail{$i};
      if ($char == '@') {
        $res .= "' + '&' + '#6' + '4;' + '";
      } else {
        if ($i % 2 == 0) {
          $res .= htmlentities($char, ENT_QUOTES, 'utf-8');
        } else {
          $res .= $char;
        }
      }
    }
    $res = "'".$res."'";
    return $res;
  }

  private static function getJs($js) {
    if (trim($js) == '') return '';
    return '<script type="text/javascript">
<!--
  '.$js.'
//-->\n </script>';
  }

  public static function getJsEmailEx($mail, $content = null, $addParameter = null, $tagName = null, $isPairTag = true, $isCloseTag = false) {
    if ($tagName == null) $tagName = "a";
    $res = self::getJsEmail($mail);
    $rndName = "da".rand(1, pow(10, 5) - 1);

    $addParameter = $addParameter != ''? addslashes($addParameter) : '';
    $closeStr = ">";
    if ($isCloseTag) $closeStr = "/>";
    $pairStr = $isPairTag ? "</".$tagName.">" : '';

    $result = 'var prefix = "&#109;a" + "i&#108;" + "&#116;o";
  var path = "hr"+"ef=";
  var '.$rndName.' = '.$res.';
  document.write("<" + "'.$tagName.' " + path + '.'"\"" + prefix + ":" + '.$rndName.' + "\"'.$addParameter.$closeStr.'");';
    if ($content == $mail) {
      $result .= 'document.write('.$rndName.' + "'.$pairStr.'");';
      $result = self::getJs($result);
    } else {
      $result = self::getJs($result).$content.self::getJs('document.write("'.$pairStr.'");');
    }
    return $result;
  }

  private static function processEmailInText($innerText, $t=1) {
    if ($innerText != "") {
      $p = '/'.self::getMailPattern(false, false).'(?=[^>]*?<)/s';
      preg_match_all($p, $innerText, $newMatches, PREG_PATTERN_ORDER);
      if (count($newMatches[0]) > 0) {
        $innerText = preg_replace($p, '{@@@}', $innerText);
      }
      $c = 0;
      if (is_array($newMatches) && is_array($newMatches[0])) {
        $c = count($newMatches[0]);
      }
      for ($i = 0; $i < $c; $i++) {
        $mail = $newMatches[0][$i];
        if (self::checkEmail($mail)) {
          $encode = self::getJsEmail($mail);
          $mail = self::getJs('document.write('.$encode.');');
        }
        $innerText = preg_replace("/{@@@}/", $mail, $innerText, 1);
      }
    }
    return $innerText;
  }

  private static function processMatchesEmail($htmlSrc, array $matches) {
    $c = count($matches);
    for ($i = 0; $i < $c; $i++) {
      $srcBlock = $matches[$i][0];
      $tagName = $matches[$i][1];
      $attr = trim(trim($matches[$i][2])." ".trim($matches[$i][4]));    // Объединить 2 и 3 совпадения в единую строку атрибутов (атрибуты могут стоять как до href, так и после)
      $emailHref = $matches[$i][3];
      $innerText = isset($matches[$i][5]) ? $matches[$i][5] : '';
      self::processEmailInText($innerText);
      $newBlock = self::getJsEmailEx($emailHref, $innerText, $attr, $tagName);
      $htmlSrc = str_replace($srcBlock, $newBlock, $htmlSrc);
    }
    return $htmlSrc;
  }

  /**
   * The main method, which encodes emails in a html source
   * @param $htmlSrc HTML source
   * @return string Encoded HTML source
   */
  public static function encodeHtmlSource($htmlSrc) {
    $matches = array();
    $tags = array("a", "area");
    // 1 вариант - теги закрыты: <a>...</a>
    preg_match_all("/\<(".implode("|", $tags).")\s{1}([^<]*?)href=[\'|\"]mailto\:(".self::getMailPattern(false, false).")[\'|\"]{1}([^\>]*)\>(.*?)\<\/(".implode("|", $tags).")\>/iu", $htmlSrc, $matches, PREG_SET_ORDER);
    $htmlSrc = self::processMatchesEmail($htmlSrc, $matches);

    // Разновидность 1 варианта - на случай, если теги не закрыты
    preg_match_all("/\<(".implode("|", $tags).")\s{1}([^<]*?)href=[\'|\"]mailto\:(".self::getMailPattern(false, false).")[\'|\"]{1}([^\>\/]*)\>/i", $htmlSrc, $matches, PREG_SET_ORDER);
    $htmlSrc = self::processMatchesEmail($htmlSrc, $matches);

    // 2 вариант - теги пустые, но закрыты: <area />
    preg_match_all("/\<(".implode("|", $tags).")\s{1}([^<]*?)href=[\'|\"]mailto\:(".self::getMailPattern(false, false).")[\'|\"]{1}([^\>]*)\/\>/i", $htmlSrc, $matches, PREG_SET_ORDER);
    $htmlSrc = self::processMatchesEmail($htmlSrc, $matches);

    // 3 вариант - mail вне тегов.
    $htmlSrc = self::processEmailInText($htmlSrc);
    return $htmlSrc;
  }
}