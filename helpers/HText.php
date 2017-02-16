<?php
/**
 * Хелпер для работы с текстом, строками
 * @author timofeev_ro
 *
 */
class HText {
  /**
   * Обрезает строку больше $length символов и добовляет в конце $ending
   * @param string $text Текст для обрезки
   * @param int $length Размер текста, после которого он будет обрезан
   * @param sting $ending Символы, которые будут добавлены к концу обрезаной строки
   * @return string Обрезаная строка
   */
  public static function crop($text, $length, $ending = '...') {
    if (mb_strlen($text) > $length) {
      return mb_substr($text, 0, $length).$ending;
    }
    return $text;
  }
 /**
 * Обрезает строку $text по длине $length. Далее ищет ближайшую справа точку и обрезает по ней.
 * Если точка в строке не найдена, ищет пробел либо таб, и обрезает по ним.
 * Суть в том, чтобы длинные тексты обрезать ровно по окончаниям предложений.
 * @param string  $text Строка
 * @param integer $length Длина
 * @param sting $ending Символы, которые будут добавлены к концу обрезаной строки
 * @param integer $minTextLength Минимальная длина текста, при которой ищутся символы справа
 * @return string Обрезаная строка
 */
  public static function smartCrop($text, $length, $ending = '...', $minTextLength = 10) {
    $len = mb_strlen($text);
    if ($len <= $length) {
      return $text;
    }
    
    $s = mb_substr($text, 0, $length);
    if (mb_strrpos($s, '.') > $minTextLength) {
      $s = mb_substr($s, 0, mb_strrpos($s, '.')) . '.';
      return $s;
    } else if (mb_strrpos($s, ' ') > $minTextLength) {
      $s = mb_substr($s, 0, mb_strrpos($s, ' '));
    } else if (mb_strrpos($s, ' ') > $minTextLength) {
      $s = mb_substr($s, 0, mb_strrpos($s, ' '));
    }
    return $s.$ending;
  }
  
  /**
   * Вырезает окончание у слова
   * @package string
   * @param   string Слово
   * @return  string
   */
  public static function cutEnding($word) {
    $endings_array = array(
  //              'ование','ания','ация','ание','ение','ство','ому','инг','ный','ого','ний','ное',
      'ому','ный','ого','ний','ное',
      'ое','ов','ой','ом','ок', 'ая',
      'ии','ия','ик','ий', 'ие',
      'ый','ых','ые',
      'ла','ли',
      'ка','ки','ся',
      'яя','ях',
      'ее','еи',
      'у','а','и','ы','я','о','е','ю',
      'ly','ment','cy','er','o','i','a','y'
    );
    if (trim($word) == ''){
      return $word;
    }
    $saved = false;
    foreach ($endings_array as $v) {
      if ($saved) {
        continue;
      }
      if (strlen($word) < 5){
        break;
      }
      if ($v != '' && stristr(substr($word, strlen($word) - strlen($v), strlen($v)), $v)) {
        $word_base = substr($word, 0, strlen($word) - strlen($v)); // без окончания
        $word_end  = substr($word, strlen($word_base), strlen($v)); // окончание
        $word1 = $word_base . str_replace($v, "", $word_end);
        $soft1 = $word1;
        $saved = true;
        break;
      }
    }
    if (!$saved){
      $soft1 = $word;
    }
    return $soft1;
  }
  
  
  // Пачка функций, посвященная подсветке слов в тексте
  private static function stripos($s, $find, $offset = 0) {
    $offset != 0 ? $s = mb_substr($s, $offset) : true;
    if (!$a = mb_stristr($s, $find)) {
      return false;
    }
    return mb_strpos($s, $a) + $offset;
  }
  private static function wordLight($text, $word, $template) {
    if (is_null($text) || trim($text) == "" || is_null($word) || trim($word) == "") {
      return $text;
    }
    
    $startText = $text;
    $startWord = $word;

    $text = mb_strtolower($text);
    $word = mb_strtolower($word);
    
    $word = str_replace(array("(", ")"), array("\(", "\)"), $word);
    
    $from = "(\w*)$word(\w*)";
    $text = mb_eregi_replace($from, "%s%", $text);

    $pos1 = mb_strpos($text, "%s%");
    
    while (!($pos1 === false)) {
      $pos2 = $pos1 + 3;
      $pos = 0;
//echo "===".$i.":::".$text.":::".$startText.":::".$ch.":::".$pos1.":::".mb_strlen($text).":::".$pos2.":::";
      if (mb_strlen($text) == $pos2) {
        $pos = mb_strlen($startText);
      } else {
        $ch = mb_substr($text, $pos2, 1);
        $pos = mb_strpos($startText, $ch, $pos1);
      }
      $newWord = $word;
      if (!($pos === false)) {
        $newWord = mb_substr($startText, $pos1, $pos-$pos1);
      }
      $newWord = str_replace("%s", $newWord, $template);
      $text = mb_substr($text, 0, $pos1).$newWord.mb_substr($text, $pos2);
      $startText = mb_substr($startText, 0, $pos1).$newWord.mb_substr($startText, $pos);
      $pos1 = mb_strpos($text, "%s%");
    }
    return $startText;
  }
  /**
   * Подстветка слов в тексте
   * @param string $text Текст, в котором будут подсвечены слова
   * @param array $phrase Массив слов для подсветки
   * @param string $template Шаблон, по которому будут заменены найденные слова. Пример: <span class="cSearchSel">%s</span>
   * @param int $length Длина текста на выходе. Если=0, то текст не будет обрезан
   */
  public static function highlightText($text, array $phrase, $template, $length=0) {
    $result = array();
    
    $doCut = mb_strlen($text) > ($length * 2);
    // массив позиций слов
    $positions = array();
    foreach ($phrase as $k => $q) {
      if (($position = self::stripos($text, $q)) !== false) {
        if ($doCut) {
          $positions[] = $position;
        } else {
          $text = self::wordLight($text, $q, $template);
        }
      }
    }
    if (!$doCut) {
      return $text;
    }
    if (count($positions) == 0) {
      return mb_substr($text, 0, $length);
    }
    // символов провеью на слово запроса
    $part = round($length * 2 / count($positions));
    $res = null;

    // проходим по позициям и вырезаем превью текст
    sort($positions);
    foreach ($positions as $p) {
      $p = $p - $part / 2; // начало превью, смещаем на пол-части влево
      if ($p < 0) {
        $p = 0;
      }
      $end = '';
      if (isset($prev)) {
        if ($p <= $prev) { // если пред. конец больше
          $p = $prev;
          $end = ' ';
        } else {
          $end = ' ... ';
        }
      }
      $res .= $end . mb_substr($text, $p, $part);
      $prev = $p + $part; // конец превью предыдущий
    }
    $res = mb_substr($res, mb_strpos($res, ' ') + 1);
    foreach ($phrase as $k => $q) {
      $res = self::wordLight($res, $q, $template);
    }
    return $res;
  }
  
  /**
   * Генерирует строку со случайными символами
   * @param int $length Длина генерируемой строки
   * @return string
   */
  public static function getRandomString($length) {
    $result = "";
    $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
    $l = strlen($str);
    for ($i = 0; $i < $length; $i++) {
      $result .= $str{rand(0, ($l-1))};
    }
    return $result;
  }

  /**
   * Добавление условия к sql-фразе where
   * @param string $where исходное условие, допутсимо null
   * @param string $add дополнительное условие
   * @param string $cond операнд объединения
   * @return string
   */
  public static function addCondition($where, $add, $cond = 'AND') {
    if ($add == null || $add == '') {
      return $where;
    }
    if ($where != null && !empty($where)) {
      $add = " ".$cond." (".$add.")";
      $where = "($where)";  // Т.к. where может содеражать менее приоритетные операции, например OR.
    }
    return $where.$add;
  }

  /**
   * Транслит
   * @param string Строка
   * @param string Чем заменять пробелы/табы
   * @return string
   */ 
  public static function translit($str, $spaceReplace='_', $clear = true) {
    // очищаем строку от недопустимых символов
    if ($clear) $str = preg_replace("/[^a-zа-яA-ZА-ЯёйЁЙ0-9_.\- \t]+/iu", '', $str);
    return str_replace(
      array(
        "а","б","в","г","д","е","ж","з","и","к",
        "л","м","н","о","п","р","с","т","у","ф",
        "х","ц","ч","ш","щ","ь","ы","ъ","э","ю",
        "я","ё","й", " ", "\t",
        "А","Б","В","Г","Д","Е","Ж","З","И","К",
        "Л","М","Н","О","П","Р","С","Т","У","Ф",
        "Х","Ц","Ч","Ш","Щ","Ь","Ы","Ъ","Э","Ю",
        "Я","Ё","Й"
      ), array(
        "a","b","v","g","d","e","gh","z","i","k",
        "l","m","n","o","p","r","s","t","u","f",
        "h","z","ch","sch","sch","","y","","e","yu",
        "ya","e","i", $spaceReplace, $spaceReplace,
        "A","B","V","G","D","E","Gh","Z","I","K",
        "L","M","N","O","P","R","S","T","U","F",
        "H","Z","Ch","Sch","Sch","","Y","","E","Yu",
        "Ya","E","I"
      ), $str
    );
  }

  /**
   * Удалить двойные символы из строки
   * @package string
   * @param string Строка
   * @param string Символ
   * @return string
   */
  public static function cutDoubleChars($str, $c) {
    $pos = strpos($str, $c.$c);
    while ($pos !== false) {
      $str = str_replace($c.$c, $c, $str);
      $pos = strpos($str, $c.$c);
    }
    return $str;
  }


}
