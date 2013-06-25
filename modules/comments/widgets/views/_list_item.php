<ul class="comments-list" rel="0">
  <?php foreach($comments as $comment):?>
      <?php if ($comment->childs == false && $comment->moderation != CommentYii::STATUS_APPROVED) :?>
      <?php continue; ?>
      <?php endif; ?>
      <li id="comment-<?=$comment->id_comment;?>" <?php if ($comment->isUnWatchComment) echo ' class="'.$this->classUnWatchCommentView.'"';?>>
      <div id="comment_<?=$comment->id_comment;?>" class="addComments item">
        <?php if ($comment->moderation != CommentYii::STATUS_APPROVED) : ?>
          <?php 
          if ($comment->childs == true) {
            $this->render('_item_delete', array('comment' => $comment));
          }
          ?>
        <?php else :?>
          <div class="comment-header">
            <div class="author">
              <table cellpadding="0" cellspacing="0">
              <tr>

              <td>
                <div class="commentheader name">
                  <span class="commentauthor"><b>
                  <?php
                  if (isset($comment->user)) {
                    echo CHtml::encode($comment->user->full_name);
                  } else {
                    echo $comment->processTextFromFoul(CHtml::encode($comment->comment_name));                   
                  }
                  ?>
                  </b>, <div class="date"><?=Yii::app()->dateFormatter->formatDateTime($comment->comment_date);?></div></span>
                  <div class="tools">
                  <?php
                  
                    if ($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false)) {
                      echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Свернуть'), '#',
                        array('rel'=>$comment->id_comment, 'class'=>'minimize')) . "] ";
                      if ($this->disableAddComments == false) {
                        echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Ответить'), '#',
                          array('rel'=>$comment->id_comment, 'class'=>'add-comment')) . "]";
                      }
                      //Удаление коммента разрешено либо владельцу поста либо владельцу этого коммента
                      if (($this->isObjectBlog == true && $this->isOwnerBlog == true) || $comment->isOwnerComment() == true) {
                        echo "[" . CHtml::link(Yii::t('CommentsModule.msg', 'Удалить'), '/comments/comment/setStatusDeleteComment',
                          array('rel'=>$comment->id_comment, 'class'=>'delete-comment')) . "]";
                      }
                      
                    }

                  ?>
                  </div>
                </div>
                <div class="commentbody body">
                  <b class="repl"></b>
                   <div class="commenttitle"><b><?=$comment->comment_theme;?></b></div>
                   <div class="comment txt"><?=$comment->processTextFromFoul(nl2br(trim(CHtml::encode($comment->comment_text))));?></div>
                </div>
              </td>
              </tr>
              </table>
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
