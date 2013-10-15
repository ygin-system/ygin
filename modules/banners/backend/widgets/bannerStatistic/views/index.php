<?php

/**
 * @var $model Banner
 */
$viewStat = $this->viewStat;
?>
<b>Количество кликов:</b><br>
за день: <?php echo (isset($viewStat[BannerPlace::CLICK_DAY])) ? $viewStat[BannerPlace::CLICK_DAY] : 0; ?><br>
за месяц: <?php echo (isset($viewStat[BannerPlace::CLICK_MONTH])) ? $viewStat[BannerPlace::CLICK_MONTH] : 0; ?><br>
всего: <?php echo (isset($viewStat[BannerPlace::CLICK_ALL])) ? $viewStat[BannerPlace::CLICK_ALL] : 0; ?><br>
<?php if (Yii::app()->getModule('banners')->viewStatisticAvailable): ?>
  <b>Количество показов:</b><br>
  за день: <?php echo (isset($viewStat[BannerPlace::VIEWING_TYPE_DAY])) ? $viewStat[BannerPlace::VIEWING_TYPE_DAY] : 0; ?><br>
  за месяц: <?php echo (isset($viewStat[BannerPlace::VIEWING_TYPE_MONTH])) ? $viewStat[BannerPlace::VIEWING_TYPE_MONTH] : 0; ?><br>
  всего: <?php echo (isset($viewStat[BannerPlace::VIEWING_TYPE_ALL])) ? $viewStat[BannerPlace::VIEWING_TYPE_ALL] : 0; ?>
<?php endif; ?>