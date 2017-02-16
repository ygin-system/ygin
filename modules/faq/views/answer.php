<?php
/**
 * @var $model Question
 */
$msg = "С сайта ".Yii::app()->request->hostInfo." из раздела Вопрос-ответ вам ответили на вопрос.\n".
  "Вопрос: {question}\n".
  "Ответ: {answer}\n".
  "---\n".
  "Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($msg, array(
  '{question}' => $model->question,
  '{answer}'   => $model->answer,
));