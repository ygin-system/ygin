<div>
  <h3>Варианты ответов:</h3>
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php

/**
 * @var $this AnswerListWidget
 * @var $model Voting
 * @var $form CActiveForm
 */

$answers = $this->answers;
$totalCount = (($this->countAnswers - count($answers)) < 5 ? count($answers) + 5 : $this->countAnswers); // минимум будет 5 доп. пустых ответов

$totalVote = 0;
foreach($answers AS $answer) {
  $totalVote += $answer->count;
}

foreach($answers AS $i => $answer) {
  /**
   * @var $answer VotingAnswer
   */
  echo '<tr>
   <td>'.$form->textField($answer, '['.$answer->id_voting_answer.']name', array('maxlength'=>'100', 'style'=>'width:100%')).'</td>
   <td> Голосов: '.$answer->count.' ('.($totalVote > 0 ? round($answer->count / $totalVote * 100) : 0).'%)</td>
</tr>';
}
$className = get_class(VotingAnswer::model());
for ($i = 0; $i < ($totalCount-count($answers)); $i++) {
  echo '<tr>
   <td>'.CHtml::textField($className.'['.(-1*($i+1)).'][name]', '', array('maxlength'=>'100', 'style'=>'width:100%')).'</td>
   <td>&nbsp;</td>
</tr>';

}
?>
  </table>
</div>
