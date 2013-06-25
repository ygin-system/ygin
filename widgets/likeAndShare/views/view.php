<?php
$assetsPath = $this->getAssetsPath();
$urlBase = CHtml::asset($assetsPath)."/";
$cs = Yii::app()->clientScript;

$cs->registerCssFile($urlBase."style.css");
$cs->registerScriptFile($urlBase."share42.js");

 // поделиться:
 ?>
<table cellspadding="0" cellspacing="0" class="wShare">
<tr>
  <td style=" padding-bottom:10px">
    <div class="share42init" data-url="<?php echo $url; ?>" data-title="<?php echo CHtml::encode($title); ?>"></div>
    <script type="text/javascript">share42('<?php echo $urlBase; ?>')</script>
  </td>
 </tr>
 <tr>
  <td>
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style " addthis:url="<?php echo $url; ?>" addthis:title="<?php echo CHtml::encode($title); ?>">
      <a class="addthis_button_facebook_like" fb:like:width="95" fb:like:locale="en_US"></a>
      <a class="addthis_button_tweet"></a>
      <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fa15d1f3218bd6e"></script>
    <!-- AddThis Button END -->
  </td>
</tr>
</table>