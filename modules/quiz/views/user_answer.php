<?php
/**
 * @var $this DefaultController
 * @var $quiz Quiz
 */

function isEmpty($value, $trim = false) {
	return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
}

// Подготавливаем данные
$i = 0;
$data = array();
foreach ($quiz->getRelated('questions') as $question) {
	$item = array('question' => $question->question);

	$value = $quiz->user_answer;
	$pk    = $question->getPrimaryKey();
	if (!is_array($value) || !array_key_exists($pk, $value) || isEmpty($value[$pk], true)) {
		$item['answer'] = 'нет ответа';
	} elseif (!is_array($value[$pk])) {
		foreach ($question->getRelated('answers') as $answer) { /** @var $answer QuizAnswer */
			if ($answer->getPrimaryKey() == $value[$pk]) {
				$item['answer'] = $answer->answer;
				break;
			}
		}
	} else {
		foreach ($question->getRelated('answers') as $answer) { /** @var $answer QuizAnswer */
			if (in_array($answer->getPrimaryKey(), $value[$pk])) {
				$item['answer'][] = $answer->answer;
			}
		}
	}
	$data[++$i] = $item;
}
?>
Ответы пользователя:
<? foreach ($data as $n => $item) : ?>

<?= $n; ?>. <?= $item['question']; ?>

Ответ: <? if (!is_array($item['answer'])) : ?><?= $item['answer']; ?>
<? else : ?>
<? foreach ($item['answer'] as $answer) : ?>
<?= "\n - " . $answer; ?>
<? endforeach; ?>
<? endif; ?>
<? endforeach; ?>