<?php

$this->breadcrumbs[$model->title] = $model->getUrl();

$this->registerCssFile('news.css');

?>

<div class="b-news-single">
 <a title="Версия для печати" rel="nofollow" class="print ui-icon ui-icon-print" href="<?php echo $model->getUrl(); ?>" target="_blank"></a>  
 <div class="date">
 <?php echo Yii::app()->dateFormatter->format(Yii::app()->getModule('news')->singleNewsDateFormat, $model->date); ?>
 </div>
 <div class="text"><?php echo $model->content; ?></div>
 <?php $this->widget('ygin.widgets.likeAndShare.LikeAndShareWidget', array("title" => $model->title)); ?>
 <div class="archive">«&nbsp;<?php echo CHtml::link('Архив новостей', array('index'))?></div>
</div>
<?php $this->widget('ygin.modules.comments.widgets.ECommentsListWidget', array('model' => $model));?>
