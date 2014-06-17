<?php
$assetsPath = $this->getAssetsPath();
$urlBase = CHtml::asset($assetsPath)."/";
$cs = Yii::app()->clientScript;
$cs->registerCssFile($urlBase."style.css");

// поделиться:
?>
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-orientation="horizontal" data-text-color="ffffff" data-share-shape="round-rectangle" data-buttons-color="ff9300" data-sn-ids="fb.ok.vk.gp.mr." data-counter-background-color="ffffff" data-share-counter-size="10" data-share-size="20" data-background-color="ededed" data-share-counter-type="separate" data-pid="1268028" data-counter-background-alpha="1.0" data-share-style="10" data-mode="share" data-following-enable="false" data-like-text-enable="false" data-selection-enable="true" data-icon-color="ffffff" class="b-like-buttons uptolike-buttons" ></div>