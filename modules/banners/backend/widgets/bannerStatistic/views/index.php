<?php

/**
 * @var $form CActiveForm
 * @var $model Banner
 */

if ($model->isNewRecord) return;
$idBanner = $model->getIdInstance();

$sql = 'SELECT view_type AS type, view_count AS stat FROM da_stat_view WHERE id_object=:obj AND id_instance=:inst';
$rows = Yii::app()->db->createCommand($sql)->queryAll(true, array(':obj' => Banner::ID_OBJECT, ':inst' => $idBanner));
$view = array();
foreach($rows AS $row) {
  $view[$row['type']] = $row['stat'];
}

?>
<b>Количество кликов:</b><br>
за день: <?php echo (isset($view[BannerPlace::CLICK_DAY])) ? $view[BannerPlace::CLICK_DAY] : 0; ?><br>
за месяц: <?php echo (isset($view[BannerPlace::CLICK_MONTH])) ? $view[BannerPlace::CLICK_MONTH] : 0; ?><br>
всего: <?php echo (isset($view[BannerPlace::CLICK_ALL])) ? $view[BannerPlace::CLICK_ALL] : 0; ?><br>
<?php if (Yii::app()->getModule('banners')->viewStatisticAvailable): ?>
  <b>Количество показов:</b><br>
  за день: <?php echo (isset($view[BannerPlace::VIEWING_TYPE_DAY])) ? $view[BannerPlace::VIEWING_TYPE_DAY] : 0; ?><br>
  за месяц: <?php echo (isset($view[BannerPlace::VIEWING_TYPE_MONTH])) ? $view[BannerPlace::VIEWING_TYPE_MONTH] : 0; ?><br>
  всего: <?php echo (isset($view[BannerPlace::VIEWING_TYPE_ALL])) ? $view[BannerPlace::VIEWING_TYPE_ALL] : 0; ?>
<?php endif; ?>