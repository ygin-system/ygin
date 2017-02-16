<?php if (count($comments) > 0): ?>
<?php //Yii::app()->getClientScript()->registerScript('comments_backgr', "$('.b-comment-widget .item:even').css('background', '#F8F8F8');", CClientScript::POS_READY); ?>
<div class="b-comment-list">
<?php 
$this->render('_list_item', array('comments' => $comments)); 
?>
</div>
<?php endif; ?>
