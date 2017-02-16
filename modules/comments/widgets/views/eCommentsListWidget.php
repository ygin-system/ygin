<div id="<?=$this->id?>" class="b-comment-widget">
  <h2 id="comment-open" class="b-comment-tag"><a data-object="<?=$this->model->getIdObject();?>" data-instance="<?=$this->model->getIdInstance();?>" href="#" onclick="$('#addCommentDialog-<?=$this->id?>,.b-comment-list').slideToggle(); return false"><?php echo Yii::t('CommentsModule.msg', 'Comments') . " (" .$count. ")";?></a></h2>
<?php
  if ($this->disableAddComments === false) {
    echo "<div id=\"addCommentDialog-$this->id\">";
    $this->widget('comments.widgets.ECommentsFormWidget', array(
      'model' => $this->model,
    ));
    echo "</div>";
  }
  $this->render('eCommentsWidgetComments', array('comments' => $comments));
?>

</div>