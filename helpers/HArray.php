<?php
/**
 * Хелпер для работы с массивами
 * @author timofeev_ro
 *
 */
class HArray {
  
  /**
   * Возвращает значение массива $array по ключу $key. Если ключа не существует, то вернет значение $default
   * @param array $array
   * @param mixed $key
   * @param mixed $default
   * @return mixed
   */
  public static function val($array, $key, $default = null) {
    if (array_key_exists($key, $array)) {
      return $array[$key];
    }
    return $default;
  }
  
  /**
   * Добавляет к значениям массива $a значения из массива $b.
   * Значения по совпадающим ключам не будут перезаписаны.
   * @param array $a
   * @param array $b
   * @return array
   */
  public static function addArray($a, $b) {
    $res = $a;
    foreach ($b as $k => $v) {
      if (!array_key_exists($k, $res)) {
        $res[$k] = $v;
      }
    }
    return $res;
  }
  /**
   * Возвращает указаный столбец из списка массивов
   * Напр.:
   * $members = array(
   *   array('name' => 'Саша', 'age' => 18),
   *   array('name' => 'Катя', 'age' => 21),
   *   ....
   * );
   *
   * HArray::column($members, 'name') вернет array('Саша', 'Катя', ...);
   *
   * @param array $rows
   * @param mixed $column
   * @param boolean $skip пропускать строку, если ключ массива в ней не существует
   * @return array
   */
  public static function column($rows, $column, $skip = true) {
    $res = array();
    foreach ($rows as $row) {
      if (isset($row[$column]) || array_key_exists($column, $row)) {
        $res[] = $row[$column];
      } else {
        if (!$skip) {
          throw new ErrorException('Column '.$column.' not exist.');
        }
      }
    }
    return $res;
  }
  /**
   * Применяет пользовательскую функцию поиска к массиву.
   * В случае успеха возвращает индекс найденного элемента иначе возвращает false
   * @param array $array
   * @param mixed $function
   * @throws InvalidArgumentException
   * @return mixed
   */
  public static function search(array $array, $function) {
    if (!is_callable($function)) {
      throw new InvalidArgumentException('Parameter $function must be a valid callback.');
    }
    foreach ($array as $key => $value) {
      if ($function($value) !== false) {
        return $key;
      }
    }
    return false;
  }
}