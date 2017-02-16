  
    <?php echo CHtml::form(null, null, array('class'=>'vote-form'));?>      
    <?php echo CHtml::hiddenField('id_voting', $voting->id_voting, array('id'=>'id_voting_field'));?>
    <?php echo CHtml::hiddenField('vote_widget', 1);?>
    <ul class="answer-list">
    <?php foreach ($voting->answer as $ans):?>
      <li class="answer">
        <?php if ($voting->is_checkbox): ?>
          <label for="<?php echo "ans_ext_{$ans->id_voting_answer}" ?>" class="checkbox">
          <?php echo CHtml::activeCheckBox($ans, 'name[]', array('value'=>$ans->id_voting_answer, 'id'=>"ans_ext_{$ans->id_voting_answer}", 'uncheckValue'=>null));?>
        <?php else:?>
          <label for="<?php echo "ans_ext_{$ans->id_voting_answer}" ?>" class="radio">
          <?php echo CHtml::activeRadioButton($ans, 'name', array('value'=>$ans->id_voting_answer, 'id'=>"ans_ext_{$ans->id_voting_answer}", 'uncheckValue'=>null));?>
        <?php endif;?>
        <?php echo $ans->name; ?>
        </label>
      </li>
    <?php endforeach;?>
    </ul> 
    <div>
    <?php 
       echo CHtml::ajaxSubmitButton('Голосовать', Yii::app()->createUrl(VoteModule::ROUTE_VOTE_ACTION), array(
         'type' => 'POST',
         'replace' => '#vote_widget_'.$voting->id_voting.' .vote-form',
       ),
       array(
         'type' => 'submit',
         'class' => 'btn btn-primary',
       ));
    ?>
    </div>
  <?php echo CHtml::endForm();?>  