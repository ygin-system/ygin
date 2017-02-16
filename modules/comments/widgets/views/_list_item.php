<ul rel="0" class="media-list">
  <?php foreach($comments as $comment):?>
      <?php if ($comment->childs == false && $comment->moderation != CommentYii::STATUS_APPROVED) :?>
      <?php continue; ?>
      <?php endif; ?>
      <li id="comment-<?=$comment->id_comment;?>" class="media <?php if ($comment->isUnWatchComment) echo $this->classUnWatchCommentView;?>">
        <div id="comment_<?=$comment->id_comment;?>" class="item">
        <?php if ($comment->moderation != CommentYii::STATUS_APPROVED) : ?>
          <?php 
          if ($comment->childs == true) {
            $this->render('_item_delete', array('comment' => $comment));
          }
          ?>
        <?php else :?>
        <?php //TODO: надо выводить юзерпик ?>
              <?php // <a class="pull-left userpic" href="#"><img src="http://dummyimage.com/64x64/eeeeee/000" class="media-object"></a> ?>
              <div class="media-body item-body">
                <div class="media-heading hdr">
                  <div class="tools">
                  <?php
                  
                    if ($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false)) {
                      echo '<button class="btn btn-xs minimize" rel="'.$comment->id_comment.'" title="'.Yii::t('CommentsModule.msg', 'Свернуть').'"><span class="glyphicon glyphicon-minus"></span></button>';
                      /*echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Свернуть'), '#',
                        array('rel'=>$comment->id_comment, 'class'=>'minimize')) . "] ";*/
                      if ($this->disableAddComments == false) {
                        echo '<button class="btn btn-xs add-comment" rel="'.$comment->id_comment.'"><span class="glyphicon glyphicon-share" title="'.Yii::t('CommentsModule.msg', 'Ответить').'"></span></button>';
                        /*echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Ответить'), '#',
                          array('rel'=>$comment->id_comment, 'class'=>'add-comment')) . "]";*/
                      }
                      //Удаление коммента разрешено либо владельцу поста либо владельцу этого коммента
                      if (($this->isObjectBlog == true && $this->isOwnerBlog == true) || $comment->isOwnerComment() == true) {
                        echo '<a href="/comments/comment/setStatusDeleteComment" class="btn btn-xs delete-comment" rel="'.$comment->id_comment.'" title="'.Yii::t('CommentsModule.msg', 'Удалить').'"><span class="glyphicon glyphicon-remove"></span></a>';
                        /*echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Удалить'), '/comments/comment/setStatusDeleteComment',
                          array('rel'=>$comment->id_comment, 'class'=>'delete-comment')) . "]";*/
                      }
                      
                    }

                  ?>
                  </div>
                  <div class="author label label-default">
                  <?php
                  if (isset($comment->user)) {
                    echo CHtml::encode($comment->user->full_name);
                  } else {
                    echo $comment->processTextFromFoul(CHtml::encode($comment->comment_name));
                  }
                  ?>
                  </div>
                  <div class="date"><?=Yii::app()->dateFormatter->formatDateTime($comment->comment_date);?></div>
                </div>
                <div class="txt-body">
                  <b class="repl"></b>
                  <h4 class="title"><?=$comment->comment_theme;?></h4>
                  <div class="txt"><?=$comment->processTextFromFoul(nl2br(trim(CHtml::encode($comment->comment_text))));?></div>
                </div>
              </div>
          <?php endif;?>
        </div>
        <?php 
        if (count($comment->childs) > 0 && $this->allowSubcommenting === true) {
          $this->render('_list_item', array('comments' => $comment->childs));
        }  
        ?>
      </li>
  <?php endforeach;?>
</ul>
