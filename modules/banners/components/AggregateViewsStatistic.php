<?php
Yii::import('ygin.modules.banners.models.*');

class AggregateViewsStatistic extends SchedulerJob {

  public function run() {
    $fileName = Yii::app()->getRuntimePath().'/banner_stat.dat';
    if (!file_exists($fileName)) {  // статистики нет
      return self::RESULT_OK;
    }
    $tmpFile = $fileName.".tmp";
    if (file_exists($tmpFile)) {
      Yii::log(
        'Обнаружен файл "'.$tmpFile.'", возможно, его обработка еще не завершена.',
        CLogger::LEVEL_ERROR,
        __CLASS__
      );
      return 1;
    }
    rename($fileName, $tmpFile);
    $resultArr = array();
    $fp = fopen($tmpFile, "r");
    if ($fp) {
      Yii::beginProfile('aggregate views stat', __CLASS__);
      while ($data = fgets($fp)) {
        $data = trim($data);
        if ($data == "") continue;
        $arr = explode(",", $data);
        $d = trim($arr[0]);
        $id = trim($arr[1]);
        if (array_key_exists($id, $resultArr)) {
          $resultArr[$id][] = $d;
        } else {
          $resultArr[$id] = array($d);
        }
      }
      Yii::beginProfile('aggregate views stat', __CLASS__);
    }

    StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::VIEWING_TYPE_DAY, 'd.m.Y', false);
    StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::VIEWING_TYPE_MONTH, 'm.Y', false);
    StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::VIEWING_TYPE_ALL, '', false);

    @unlink($tmpFile);
    if (file_exists($tmpFile)) {
      Yii::log(
        "Не удалось удалить временный файл " . $tmpFile,
        CLogger::LEVEL_WARNING,
        __CLASS__
      );
    }
    return self::RESULT_OK;
  }

}