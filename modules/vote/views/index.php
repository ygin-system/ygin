<?php 
  $this->registerCssFile('vote.css');
  $votingList = CHtml::listData($voting, 'id_voting', 'name');
?>

<div class="b-vote">
  <?php echo CHtml::form(Yii::app()->createUrl(VoteModule::ROUTE_VOTE), 'get'); ?>
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="choose_vote">Выберите опрос:</label>
      <div class="controls">
        <?php echo CHtml::dropDownList('id_voting', $idVotingCurrent, $votingList, array(
          'class' => 'inputbox',
          'empty' => '',
          'id'    => 'choose_vote',
          'onchange' => 'window.location="'.Yii::app()->createUrl(VoteModule::ROUTE_VOTE).'"+this.value+"/";'
        //'onchange' => CHtml::ajax(array('update' => '.voteRes', 'url' => '/vote/voting/vote', 'type' => 'POST',)),
        ));
        ?>
      </div>
    </div>
  </fieldset>
  <?php echo CHtml::endForm(); ?>
<div class="voteRes">
<?php $this->widget('VoteWidget', array('inModule' => false, 'idVoting' => $idVotingCurrent));  ?>
</div>

</div>