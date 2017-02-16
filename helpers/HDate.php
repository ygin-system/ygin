<?php
/**
 * Хелпер для работы с датой
 * @author timofeev_ro
 *
 */
class HDate {
  const BEGINNING_DAY = 0;
  const BEGINNING_MONTH = 1;
  const BEGINNING_YEAR = 2;
  
  /**
   * Получает timestamp на начало временного периода
   * @param int $timestamp
   * @param int $beginningType : HDate::BEGINNING_DAY, HDate::BEGINNING_MONTH, HDate::BEGINNING_YEAR
   * @throws BadMethodCallException
   * @return number
   */
  public static function getTimestampOnBeginning($timestamp = null, $beginningType = self::BEGINNING_DAY) {
    if ($timestamp === null) {
      $timestamp = time();
    }
    $resultTimestamp = 0;
    $dateInfo = getdate($timestamp);
    switch ($beginningType) {
      case self::BEGINNING_DAY:
        $resultTimestamp = mktime(0, 0, 0, $dateInfo['mon'], $dateInfo['mday'], $dateInfo['year']);
        break;
      case self::BEGINNING_MONTH:
        $resultTimestamp = mktime(0, 0, 0, $dateInfo['mon'], 1, $dateInfo['year']);
        break;
      case self::BEGINNING_YEAR:
        $resultTimestamp = mktime(0, 0, 0, 1, 1, $dateInfo['year']);
        break;
      default:
        throw new BadMethodCallException('Unknown $beginningType');
    }
    return $resultTimestamp;
  }
  
  /**
   * Получает timestamp с разницей в $diffMonthCount.
   * $diffMonthCount может быть и отрицательным, 
   * напр, если $timestamp соответствует дате 25.01.12, то при $diffMonthCount = 2 метод вернет timestamp на 25.03.12;
   * если $diffMonthCount = -5, то метод вернет timestamp на 25.10.11
   * @param int $timestamp
   * @param int $diffMonthCount Разница в количестве месяцев
   * @return number
   */
  public static function getTimestampDiffMonth($timestamp = null, $diffMonthCount = 1) {
    if ($timestamp === null) {
      $timestamp = time();
    }
    $dateInfo = getdate($timestamp);
    $allMonth = $dateInfo['mon'] + $dateInfo['year']*12;
    $allMonth = $allMonth + $diffMonthCount;
    $newYear = floor(($allMonth - 1) / 12);
    $newMonth = $allMonth - $newYear * 12;
    return mktime($dateInfo['hours'], $dateInfo['minutes'], $dateInfo['seconds'], $newMonth, $dateInfo['mday'], $newYear);
  }
 
}

