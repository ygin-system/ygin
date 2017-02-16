<table class="result-list" cellspacing="0" cellpadding="0">
  <?php foreach ($voting->answer as $ans):?>
  <tr>
    <th><?php echo $ans->name; ?></th>
    <th>&nbsp;</th>
  </tr>
  <tr>
    <td style="width: 65%">
      <div class="progress"><div class="bar" style="width: <?php echo ($voteCount)?round($ans->count/$voteCount*100):0?>%;"></div></div>
    </td>
    <td class="percent"><?php echo $ans->count.' ('.(($voteCount)?round($ans->count/$voteCount*100):0).'%)'?></td>
  </tr>
  <?php endforeach;?>
</table>
<a class="archive btn btn-mini" href="<?php echo Yii::app()->createUrl(VoteModule::ROUTE_VOTE); ?>">Все голосования</a>