<div id="<?=$this->id?>" class="itemComments comment-widget mCommentArea">
<h2 id="cCommentTag" class="mCommentTag"><a data-object="<?=$this->model->getIdObject();?>" data-instance="<?=$this->model->getIdInstance();?>" href="#" onclick="$('#addCommentDialog-<?=$this->id?>,.mCommentList').slideToggle(); return false"><?php echo Yii::t('CommentsModule.msg', 'Comments') . " (" .$this->model->relationCountComment(). ")";?></a></h2>
<?php
/* $this->isObjectBlog = ($this->model->getIdObject() == BlogPost::ID_OBJECT);
if ($this->isObjectBlog === true && DaUser::isGuest() === true && $this->model->comment_type == BlogPost::COMMENTS_ALLOWED_FOR_AUTHORIZED) {
  $this->disableAddComments = true;
}
if ($this->isObjectBlog === true) {
  $this->isOwnerBlog = $this->model->isOwner();
} */
  if($this->showPopupForm === false) {
    if ($this->disableAddComments === false) {
      echo "<div id=\"addCommentDialog-$this->id\">";
      $this->widget('comments.widgets.ECommentsFormWidget', array(
        'model' => $this->model,
      ));
      echo "</div>";
    }
  }
  $this->render('eCommentsWidgetComments', array('comments' => $comments));
?>

</div>